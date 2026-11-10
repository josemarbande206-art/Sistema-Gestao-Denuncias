<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocalizacaoController extends Controller
{
    public function index(Request $request)
    {
        $pesquisa = $request->pesquisa;

        $localizacoes = DB::table('localizacoes')
            ->when($pesquisa, function ($query) use ($pesquisa) {
                $query->where(function ($q) use ($pesquisa) {
                    $q->where('provincia', 'like', "%{$pesquisa}%")
                        ->orWhere('municipio', 'like', "%{$pesquisa}%")
                        ->orWhere('bairro', 'like', "%{$pesquisa}%");
                });
            })
            ->orderBy('provincia')
            ->orderBy('municipio')
            ->paginate(10)
            ->withQueryString();

        $total = DB::table('localizacoes')->count();

        return view('modules.localizacoes', compact(
            'localizacoes',
            'total',
            'pesquisa'
        ));
    }

    public function create()
    {
        return view('modules.localizacoes-form');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'provincia' => 'required|string|max:100',
            'municipio' => 'required|string|max:100',
            'bairro' => 'nullable|string|max:150',
            'endereco' => 'nullable|string|max:255',
            'referencia' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        DB::table('localizacoes')->insert([
            'provincia' => $dados['provincia'],
            'municipio' => $dados['municipio'],
            'bairro' => $dados['bairro'] ?? null,
            'endereco' => $dados['endereco'] ?? null,
            'referencia' => $dados['referencia'] ?? null,
            'latitude' => $dados['latitude'] ?? null,
            'longitude' => $dados['longitude'] ?? null,
            'criado_em' => now(),
        ]);

        return redirect()
            ->route('localizacoes.index')
            ->with('sucesso', 'Localização registada com sucesso!');
    }

    public function edit(int $id)
    {
        $localizacao = DB::table('localizacoes')
            ->where('id', $id)
            ->first();

        abort_if(!$localizacao, 404);

        return view('modules.localizacoes-form', compact('localizacao'));
    }

    public function update(Request $request, int $id)
    {
        $localizacao = DB::table('localizacoes')
            ->where('id', $id)
            ->first();

        abort_if(!$localizacao, 404);

        $dados = $request->validate([
            'provincia' => 'required|string|max:100',
            'municipio' => 'required|string|max:100',
            'bairro' => 'nullable|string|max:150',
            'endereco' => 'nullable|string|max:255',
            'referencia' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        DB::table('localizacoes')
            ->where('id', $id)
            ->update([
                'provincia' => $dados['provincia'],
                'municipio' => $dados['municipio'],
                'bairro' => $dados['bairro'] ?? null,
                'endereco' => $dados['endereco'] ?? null,
                'referencia' => $dados['referencia'] ?? null,
                'latitude' => $dados['latitude'] ?? null,
                'longitude' => $dados['longitude'] ?? null,
            ]);

        return redirect()
            ->route('localizacoes.index')
            ->with('sucesso', 'Localização atualizada com sucesso!');
    }

    public function destroy(int $id)
    {
        $localizacao = DB::table('localizacoes')
            ->where('id', $id)
            ->first();

        abort_if(!$localizacao, 404);

        $temBens = DB::table('bens_publicos')
            ->where('localizacao_id', $id)
            ->exists();

        $temOcorrencias = DB::table('ocorrencias')
            ->where('localizacao_id', $id)
            ->exists();

        if ($temBens || $temOcorrencias) {
            return redirect()
                ->route('localizacoes.index')
                ->with(
                    'erro',
                    'Não é possível eliminar esta localização porque está associada a bens públicos ou denúncias.'
                );
        }

        DB::table('localizacoes')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('localizacoes.index')
            ->with('sucesso', 'Localização eliminada com sucesso!');
    }
}
