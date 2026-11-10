<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BemPublicoController extends Controller
{
    /**
     * Listar e pesquisar bens públicos.
     */
    public function index(Request $request)
    {
        $request->validate([
            'pesquisa' => ['nullable', 'string', 'max:150'],
            'tipo' => ['nullable', 'string', 'max:100'],
            'estado' => [
                'nullable',
                Rule::in(['bom', 'danificado', 'destruido']),
            ],
        ]);

        $consulta = DB::table('bens_publicos')
            ->leftJoin(
                'localizacoes',
                'bens_publicos.localizacao_id',
                '=',
                'localizacoes.id'
            )
            ->select(
                'bens_publicos.*',
                'localizacoes.provincia as provincia',
                'localizacoes.municipio as municipio'
            );

        if ($request->filled('pesquisa')) {
            $pesquisa = trim($request->input('pesquisa'));

            $consulta->where(
                'bens_publicos.nome',
                'like',
                "%{$pesquisa}%"
            );
        }

        if ($request->filled('tipo')) {
            $consulta->where(
                'bens_publicos.tipo',
                $request->input('tipo')
            );
        }

        if ($request->filled('estado')) {
            $consulta->where(
                'bens_publicos.estado_conservacao',
                $request->input('estado')
            );
        }

        $bens = $consulta
            ->orderByDesc('bens_publicos.id')
            ->paginate(10)
            ->withQueryString();

        $estatisticas = [
            'total' => DB::table('bens_publicos')->count(),

            'bons' => DB::table('bens_publicos')
                ->where('estado_conservacao', 'bom')
                ->count(),

            'danificados' => DB::table('bens_publicos')
                ->where('estado_conservacao', 'danificado')
                ->count(),

            'destruidos' => DB::table('bens_publicos')
                ->where('estado_conservacao', 'destruido')
                ->count(),
        ];

        $tipos = DB::table('bens_publicos')
            ->whereNotNull('tipo')
            ->where('tipo', '<>', '')
            ->distinct()
            ->orderBy('tipo')
            ->pluck('tipo');

        return view(
            'modules.bens-publicos',
            compact('bens', 'estatisticas', 'tipos')
        );
    }

    /**
     * Apresentar o formulário de cadastro.
     */
    public function create()
    {
        $localizacoes = DB::table('localizacoes')
            ->orderBy('provincia')
            ->orderBy('municipio')
            ->get();

        return view(
            'modules.bens-publicos-form',
            compact('localizacoes')
        );
    }

    /**
     * Guardar um novo bem público.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:150'],
            'descricao' => ['nullable', 'string'],
            'tipo' => ['nullable', 'string', 'max:100'],
            'estado_conservacao' => [
                'required',
                Rule::in(['bom', 'danificado', 'destruido']),
            ],
            'localizacao_id' => [
                'nullable',
                'integer',
                Rule::exists('localizacoes', 'id'),
            ],
        ]);

        DB::table('bens_publicos')->insert([
            'nome' => $dados['nome'],
            'descricao' => $dados['descricao'] ?? null,
            'tipo' => $dados['tipo'] ?? null,
            'estado_conservacao' => $dados['estado_conservacao'],
            'localizacao_id' => $dados['localizacao_id'] ?? null,
            'criado_em' => now(),
        ]);

        return redirect()
            ->route('bens-publicos.index')
            ->with('sucesso', 'Bem público cadastrado com sucesso.');
    }

    /**
     * Apresentar o formulário de edição.
     */
    public function edit(int $id)
    {
        $bem = DB::table('bens_publicos')
            ->where('id', $id)
            ->first();

        abort_if(!$bem, 404, 'Bem público não encontrado.');

        $localizacoes = DB::table('localizacoes')
            ->orderBy('provincia')
            ->orderBy('municipio')
            ->get();

        return view(
            'modules.bens-publicos-form',
            compact('bem', 'localizacoes')
        );
    }

    /**
     * Atualizar um bem público.
     */
    public function update(Request $request, int $id)
    {
        $bem = DB::table('bens_publicos')
            ->where('id', $id)
            ->first();

        abort_if(!$bem, 404, 'Bem público não encontrado.');

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:150'],
            'descricao' => ['nullable', 'string'],
            'tipo' => ['nullable', 'string', 'max:100'],
            'estado_conservacao' => [
                'required',
                Rule::in(['bom', 'danificado', 'destruido']),
            ],
            'localizacao_id' => [
                'nullable',
                'integer',
                Rule::exists('localizacoes', 'id'),
            ],
        ]);

        DB::table('bens_publicos')
            ->where('id', $id)
            ->update([
                'nome' => $dados['nome'],
                'descricao' => $dados['descricao'] ?? null,
                'tipo' => $dados['tipo'] ?? null,
                'estado_conservacao' => $dados['estado_conservacao'],
                'localizacao_id' => $dados['localizacao_id'] ?? null,
            ]);

        return redirect()
            ->route('bens-publicos.index')
            ->with('sucesso', 'Bem público atualizado com sucesso.');
    }

    /**
     * Eliminar um bem público.
     */
    public function destroy(int $id)
    {
        $bem = DB::table('bens_publicos')
            ->where('id', $id)
            ->first();

        abort_if(!$bem, 404, 'Bem público não encontrado.');

        $emUso = DB::table('ocorrencias')
            ->where('bem_publico_id', $id)
            ->exists();

        if ($emUso) {
            return redirect()
                ->route('bens-publicos.index')
                ->with(
                    'erro',
                    'Este bem está associado a denúncias. Não pode ser eliminado.'
                );
        }

        DB::table('bens_publicos')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('bens-publicos.index')
            ->with('sucesso', 'Bem público eliminado com sucesso.');
    }
}