<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GestaoDenunciasController extends Controller
{
    /**
     * Apresentar e filtrar as denúncias.
     */
    public function index(Request $request)
    {
        $request->validate([
            'pesquisa' => ['nullable', 'string', 'max:150'],
            'estado' => [
                'nullable',
                Rule::in([
                    'pendente',
                    'em_analise',
                    'confirmada',
                    'resolvida',
                    'rejeitada',
                ]),
            ],
        ]);

        $consulta = DB::table('ocorrencias')
            ->leftJoin(
                'categorias',
                'ocorrencias.categoria_id',
                '=',
                'categorias.id'
            )
            ->select(
                'ocorrencias.id',
                'ocorrencias.codigo',
                'ocorrencias.titulo',
                'ocorrencias.data_ocorrencia',
                'ocorrencias.data_registo',
                'ocorrencias.estado',
                'categorias.nome as categoria'
            );

        if ($request->filled('pesquisa')) {
            $pesquisa = trim($request->input('pesquisa'));

            $consulta->where(function ($query) use ($pesquisa) {
                $query->where(
                    'ocorrencias.codigo',
                    'like',
                    "%{$pesquisa}%"
                )->orWhere(
                    'ocorrencias.titulo',
                    'like',
                    "%{$pesquisa}%"
                );
            });
        }

        if ($request->filled('estado')) {
            $consulta->where(
                'ocorrencias.estado',
                $request->input('estado')
            );
        }

        $denuncias = $consulta
            ->orderByDesc('ocorrencias.id')
            ->paginate(10)
            ->withQueryString();

        $estatisticas = [
            'total' => DB::table('ocorrencias')->count(),

            'pendentes' => DB::table('ocorrencias')
                ->where('estado', 'pendente')
                ->count(),

            'em_analise' => DB::table('ocorrencias')
                ->where('estado', 'em_analise')
                ->count(),

            'resolvidas' => DB::table('ocorrencias')
                ->where('estado', 'resolvida')
                ->count(),
        ];

        return view(
            'gestao.denuncias.index',
            compact('denuncias', 'estatisticas')
        );
    }

    /**
     * Consultar os detalhes de uma denúncia.
     */
    public function show(int $id)
    {
        $denuncia = DB::table('ocorrencias')
            ->leftJoin(
                'categorias',
                'ocorrencias.categoria_id',
                '=',
                'categorias.id'
            )
            ->leftJoin(
                'localizacoes',
                'ocorrencias.localizacao_id',
                '=',
                'localizacoes.id'
            )
            ->where('ocorrencias.id', $id)
            ->select(
                'ocorrencias.*',
                'categorias.nome as categoria',
                'localizacoes.provincia as provincia',
                'localizacoes.municipio as municipio'
            )
            ->first();

        abort_if(!$denuncia, 404, 'Denúncia não encontrada.');

        // Consultar as evidências anexadas à denúncia.
        $evidencias = DB::table('evidencias')
            ->where('ocorrencia_id', $id)
            ->orderBy('id')
            ->get();

        // Consultar o histórico das alterações de estado.
        $historico = DB::table('historico_ocorrencias')
            ->leftJoin(
                'utilizadores',
                'historico_ocorrencias.operador_id',
                '=',
                'utilizadores.id'
            )
            ->where('historico_ocorrencias.ocorrencia_id', $id)
            ->select(
                'historico_ocorrencias.*',
                'utilizadores.nome as operador_nome'
            )
            ->orderByDesc('historico_ocorrencias.id')
            ->get();

        return view(
            'gestao.denuncias.show',
            compact('denuncia', 'evidencias', 'historico')
        );
    }

    /**
     * Atualizar o estado e guardar o histórico da alteração.
     */
    public function atualizarEstado(Request $request, int $id)
    {
        $dados = $request->validate([
            'estado' => [
                'required',
                Rule::in([
                    'pendente',
                    'em_analise',
                    'confirmada',
                    'resolvida',
                    'rejeitada',
                ]),
            ],
            'observacao' => ['nullable', 'string', 'max:2000'],
        ]);

        $denuncia = DB::table('ocorrencias')
            ->where('id', $id)
            ->first();

        abort_if(!$denuncia, 404, 'Denúncia não encontrada.');

        DB::transaction(function () use ($id, $dados, $denuncia) {
            // Não registar alterações quando o estado é o mesmo.
            if ($denuncia->estado === $dados['estado']) {
                return;
            }

            // Atualizar o estado da denúncia.
            DB::table('ocorrencias')
                ->where('id', $id)
                ->update([
                    'estado' => $dados['estado'],
                ]);

            // Guardar a alteração no histórico.
            DB::table('historico_ocorrencias')->insert([
                'ocorrencia_id' => $id,
                'estado_anterior' => $denuncia->estado,
                'estado_novo' => $dados['estado'],
                'operador_id' => null,
                'observacao' => $dados['observacao'] ?? null,
                'created_at' => now(),
            ]);
        });

        return redirect()
            ->route('gestao.denuncias.show', $id)
            ->with(
                'sucesso',
                'Estado atualizado e histórico registado com sucesso.'
            );
    }
}