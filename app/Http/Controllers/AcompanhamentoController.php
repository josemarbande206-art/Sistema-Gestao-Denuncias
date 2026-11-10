<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcompanhamentoController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'codigo' => ['nullable', 'string', 'max:50'],
        ]);

        $codigo = trim($request->input('codigo', ''));

        $denuncia = null;
        $pesquisou = $request->has('codigo');

        if ($pesquisou && $codigo !== '') {
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
                ->where('ocorrencias.codigo', $codigo)
                ->select(
                    'ocorrencias.codigo',
                    'ocorrencias.titulo',
                    'ocorrencias.descricao',
                    'ocorrencias.data_ocorrencia',
                    'ocorrencias.data_registo',
                    'ocorrencias.estado',
                    'categorias.nome as categoria'
                )
                ->first();
        }

        return view('modules.acompanhamento', [
            'codigo' => $codigo,
            'denuncia' => $denuncia,
            'pesquisou' => $pesquisou,
        ]);
    }
}
