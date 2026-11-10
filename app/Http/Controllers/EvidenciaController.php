<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EvidenciaController extends Controller
{
    // Listar evidências
    public function index(Request $request)
    {
        $pesquisa = $request->pesquisa;

        $evidencias = DB::table('evidencias')
            ->join('ocorrencias', 'evidencias.ocorrencia_id', '=', 'ocorrencias.id')
            ->select(
                'evidencias.*',
                'ocorrencias.codigo',
                'ocorrencias.titulo'
            )
            ->when($pesquisa, function ($query) use ($pesquisa) {
                $query->where(function ($q) use ($pesquisa) {
                    $q->where('evidencias.nome_arquivo', 'like', "%{$pesquisa}%")
                        ->orWhere('ocorrencias.codigo', 'like', "%{$pesquisa}%")
                        ->orWhere('ocorrencias.titulo', 'like', "%{$pesquisa}%");
                });
            })
            ->orderByDesc('evidencias.id')
            ->paginate(10)
            ->withQueryString();

        $total = DB::table('evidencias')->count();

        return view('modules.evidencias', compact(
            'evidencias',
            'total',
            'pesquisa'
        ));
    }

    // Abrir formulário
    public function create()
    {
        $ocorrencias = DB::table('ocorrencias')
            ->select('id', 'codigo', 'titulo')
            ->orderByDesc('id')
            ->get();

        return view('modules.evidencias-form', compact('ocorrencias'));
    }

    // Registar evidência
    public function store(Request $request)
    {
        $dados = $request->validate([
            'ocorrencia_id' => 'required|exists:ocorrencias,id',
            'arquivo' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        $arquivo = $request->file('arquivo');

        $caminho = $arquivo->store('evidencias', 'public');

        DB::table('evidencias')->insert([
            'ocorrencia_id' => $dados['ocorrencia_id'],
            'nome_arquivo' => $arquivo->getClientOriginalName(),
            'caminho_arquivo' => $caminho,
            'tipo_arquivo' => $arquivo->getMimeType(),
            'data_envio' => now(),
        ]);

        return redirect()
            ->route('evidencias.index')
            ->with('sucesso', 'Evidência registada com sucesso!');
    }

    // Eliminar evidência
    public function destroy(int $id)
    {
        $evidencia = DB::table('evidencias')
            ->where('id', $id)
            ->first();

        abort_if(!$evidencia, 404);

        Storage::disk('public')->delete($evidencia->caminho_arquivo);

        DB::table('evidencias')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('evidencias.index')
            ->with('sucesso', 'Evidência eliminada com sucesso!');
    }
}
