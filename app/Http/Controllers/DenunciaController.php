<?php

namespace App\Http\Controllers;

use App\Models\Ocorrencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DenunciaController extends Controller
{
    /**
     * Apresentar o formulário de registo.
     */
    public function create()
    {
        $categorias = DB::table('categorias')
            ->orderBy('nome')
            ->get();

        $bensPublicos = DB::table('bens_publicos')
            ->orderBy('nome')
            ->get();

        $localizacoes = DB::table('localizacoes')
            ->orderBy('provincia')
            ->orderBy('municipio')
            ->get();

           return view('denuncias.create', compact(
        'categorias',
        'bensPublicos',
        'localizacoes'
    ));
}
    public function index()
{
    $denuncias = DB::table('ocorrencias')
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
            'ocorrencias.estado',
            'categorias.nome as categoria'
        )
        ->orderByDesc('ocorrencias.id')
        ->get();

    return view('denuncias.index', compact('denuncias'));


    }

    /**
     * Guardar uma nova denúncia.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo' => 'required|string|max:150',
            'descricao' => [
    'required',
    'string',
    'min:20',
    'max:1000',

    // Rejeitar quatro ou mais letras iguais consecutivas.
    'not_regex:/([a-záàâãéêíóôõúç])\1{3,}/iu',

    // Rejeitar quatro ou mais caracteres especiais consecutivos.
    'not_regex:/[^a-zA-Z0-9\sáàâãéêíóôõúçÁÀÂÃÉÊÍÓÔÕÚÇ.,!?;:()\-]{4,}/u',

    // Exigir pelo menos uma vogal.
    'regex:/[aeiouáàâãéêíóôõú]/iu',

],
		'descricao.min' => 'A descrição deve ter pelo menos 20 caracteres.',
		'descricao.max' => 'A descrição não pode ultrapassar 1.000 caracteres.',
		'descricao.not_regex' => 'A descrição contém repetições exageradas de letras ou caracteres especiais.',
		'descricao.regex' => 'A descrição deve conter texto com pelo menos uma letra.',
            'data_ocorrencia' => 'required|date',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'bem_publico_id' => 'nullable|integer|exists:bens_publicos,id',
            'localizacao_id' => 'required|integer|exists:localizacoes,id',

            'evidencias' => 'nullable|array|max:5',
            'evidencias.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'titulo.required' => 'Introduza o título da ocorrência.',
            'descricao.required' => 'Descreva a ocorrência.',
            'data_ocorrencia.required' => 'Indique a data da ocorrência.',
            'categoria_id.required' => 'Selecione uma categoria.',
            'categoria_id.exists' => 'A categoria selecionada não existe.',
            'localizacao_id.required' => 'Selecione uma localização.',
            'localizacao_id.exists' => 'A localização selecionada não existe.',
            'evidencias.max' => 'Pode enviar no máximo cinco fotografias.',
            'evidencias.*.image' => 'Cada evidência deve ser uma imagem.',
            'evidencias.*.max' => 'Cada fotografia deve ter no máximo 5 MB.',
        ]);

        $ficheirosGuardados = [];

        try {
            $ocorrencia = DB::transaction(function () use (
                $dados,
                $request,
                &$ficheirosGuardados
            ) {
                // Gerar um código único para a denúncia.
                do {
                    $codigo = 'DEN-' . Str::upper(Str::random(10));
                } while (
                    Ocorrencia::where('codigo', $codigo)->exists()
                );

                $ocorrencia = Ocorrencia::create([
                    'codigo' => $codigo,
                    'titulo' => $dados['titulo'],
                    'descricao' => $dados['descricao'],
                    'data_ocorrencia' => $dados['data_ocorrencia'],
                    'estado' => 'pendente',
                    'utilizador_id' => null,
                    'operador_id' => null,
                    'categoria_id' => $dados['categoria_id'],
                    'bem_publico_id' => $dados['bem_publico_id'] ?? null,
                    'localizacao_id' => $dados['localizacao_id'],
                ]);

                // Guardar as fotografias e os respetivos registos.
                foreach ($request->file('evidencias', []) as $ficheiro) {
                    $caminho = $ficheiro->store(
                        'evidencias',
                        'public'
                    );

                    if (!$caminho) {
                        throw new \RuntimeException(
                            'Não foi possível guardar uma fotografia.'
                        );
                    }

                    $ficheirosGuardados[] = $caminho;

                    DB::table('evidencias')->insert([
                        'ocorrencia_id' => $ocorrencia->id,
                        'nome_arquivo' => $ficheiro->getClientOriginalName(),
                        'caminho_arquivo' => $caminho,
                        'tipo_arquivo' => $ficheiro->getMimeType(),
                        'data_envio' => now(),
                    ]);
                }

                return $ocorrencia;
            });

            return redirect()
                ->route('denuncias.create')
                ->with(
                    'sucesso',
                    'Denúncia registada com sucesso! Código: '
                    . $ocorrencia->codigo
                );

        } catch (\Throwable $e) {
            // Remover fotografias se a operação falhar.
            foreach ($ficheirosGuardados as $caminho) {
                Storage::disk('public')->delete($caminho);
            }

            report($e);

            return back()
                ->withInput()
                ->with(
                    'erro',
                    'Não foi possível registar a denúncia. Verifique os dados e tente novamente.'
                );
        }
    }
}
