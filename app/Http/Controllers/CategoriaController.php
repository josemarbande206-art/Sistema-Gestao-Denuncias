<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $pesquisa = $request->pesquisa;

        $categorias = DB::table('categorias')
            ->when($pesquisa, function ($query) use ($pesquisa) {
                $query->where('nome', 'like', "%{$pesquisa}%");
            })
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        $total = DB::table('categorias')->count();

        return view('modules.categorias', compact(
            'categorias',
            'total',
            'pesquisa'
        ));
    }

    public function create()
    {
        return view('modules.categorias-form');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:100|unique:categorias,nome',
            'descricao' => 'nullable|string',
        ]);

        DB::table('categorias')->insert([
            'nome' => $dados['nome'],
            'descricao' => $dados['descricao'] ?? null,
            'criado_em' => now(),
        ]);

        return redirect()
            ->route('categorias.index')
            ->with('sucesso', 'Categoria registada com sucesso!');
    }

    public function edit(int $id)
    {
        $categoria = DB::table('categorias')->where('id', $id)->first();

        abort_if(!$categoria, 404);

        return view('modules.categorias-form', compact('categoria'));
    }

    public function update(Request $request, int $id)
    {
        $categoria = DB::table('categorias')->where('id', $id)->first();

        abort_if(!$categoria, 404);

        $dados = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categorias', 'nome')->ignore($id, 'id'),
            ],
            'descricao' => 'nullable|string',
        ]);

        DB::table('categorias')->where('id', $id)->update([
            'nome' => $dados['nome'],
            'descricao' => $dados['descricao'] ?? null,
        ]);

        return redirect()
            ->route('categorias.index')
            ->with('sucesso', 'Categoria atualizada com sucesso!');
    }

    public function destroy(int $id)
    {
        $categoria = DB::table('categorias')->where('id', $id)->first();

        abort_if(!$categoria, 404);

        $utilizada = DB::table('ocorrencias')
            ->where('categoria_id', $id)
            ->exists();

        if ($utilizada) {
            return redirect()
                ->route('categorias.index')
                ->with('erro', 'Não é possível eliminar esta categoria porque está associada a denúncias.');
        }

        DB::table('categorias')->where('id', $id)->delete();

        return redirect()
            ->route('categorias.index')
            ->with('sucesso', 'Categoria eliminada com sucesso!');
    }
}

