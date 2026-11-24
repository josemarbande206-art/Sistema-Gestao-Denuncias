<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index(Request $request)
    {
        $consulta = DB::table('ocorrencias');

        // Filtro por data inicial
        if ($request->filled('data_inicio')) {
            $consulta->whereDate(
                'data_registo',
                '>=',
                $request->data_inicio
            );
        }

        // Filtro por data final
        if ($request->filled('data_fim')) {
            $consulta->whereDate(
                'data_registo',
                '<=',
                $request->data_fim
            );
        }

        // Filtro por categoria
        if ($request->filled('categoria_id')) {
            $consulta->where(
                'categoria_id',
                $request->categoria_id
            );
        }

        // Filtro por município
        if ($request->filled('municipio')) {
            $consulta->whereIn('localizacao_id', function ($query) use ($request) {
                $query->select('id')
                    ->from('localizacoes')
                    ->where('municipio', $request->municipio);
            });
        }

        // Total geral com os filtros aplicados
        $total = (clone $consulta)->count();

        // Totais por estado
        $estados = [
            'pendente',
            'em_analise',
            'confirmada',
            'resolvida',
            'rejeitada',
        ];

        $estatisticas = [];

        foreach ($estados as $estado) {
            $estatisticas[$estado] = (clone $consulta)
                ->where('estado', $estado)
                ->count();
        }

        // Estatísticas por categoria
        $porCategoria = (clone $consulta)
            ->join('categorias', 'ocorrencias.categoria_id', '=', 'categorias.id')
            ->select(
                'categorias.nome',
                DB::raw('COUNT(ocorrencias.id) as total')
            )
            ->groupBy('categorias.id', 'categorias.nome')
            ->orderByDesc('total')
            ->get();

        // Estatísticas por município
        $porMunicipio = (clone $consulta)
            ->join('localizacoes', 'ocorrencias.localizacao_id', '=', 'localizacoes.id')
            ->select(
                'localizacoes.municipio',
                DB::raw('COUNT(ocorrencias.id) as total')
            )
            ->groupBy('localizacoes.municipio')
            ->orderByDesc('total')
            ->get();

        // Dados dos filtros
        $categorias = DB::table('categorias')
            ->orderBy('nome')
            ->get();

        $municipios = DB::table('localizacoes')
            ->select('municipio')
            ->distinct()
            ->orderBy('municipio')
            ->get();

        return view('modules.relatorios', compact(
            'total',
            'estatisticas',
            'porCategoria',
            'porMunicipio',
            'categorias',
            'municipios'
        ));


    }

public function exportarPDF(Request $request)
{
    $consulta = DB::table('ocorrencias');

    // Filtro por data inicial
    if ($request->filled('data_inicio')) {
        $consulta->whereDate('data_registo', '>=', $request->data_inicio);
    }

    // Filtro por data final
    if ($request->filled('data_fim')) {
        $consulta->whereDate('data_registo', '<=', $request->data_fim);
    }

    // Filtro por categoria
    if ($request->filled('categoria_id')) {
        $consulta->where('categoria_id', $request->categoria_id);
    }

    // Filtro por município
    if ($request->filled('municipio')) {
        $consulta->whereIn('localizacao_id', function ($query) use ($request) {
            $query->select('id')
                ->from('localizacoes')
                ->where('municipio', $request->municipio);
        });
    }

    // Total de denúncias
    $total = (clone $consulta)->count();

    // Estatísticas por estado
    $estados = [
        'pendente',
        'em_analise',
        'confirmada',
        'resolvida',
        'rejeitada',
    ];

    $estatisticas = [];

    foreach ($estados as $estado) {
        $estatisticas[$estado] = (clone $consulta)
            ->where('estado', $estado)
            ->count();
    }

    // Estatísticas por categoria
    $porCategoria = (clone $consulta)
        ->join('categorias', 'ocorrencias.categoria_id', '=', 'categorias.id')
        ->select('categorias.nome', DB::raw('COUNT(ocorrencias.id) as total'))
        ->groupBy('categorias.id', 'categorias.nome')
        ->orderByDesc('total')
        ->get();

    // Estatísticas por município
    $porMunicipio = (clone $consulta)
        ->join('localizacoes', 'ocorrencias.localizacao_id', '=', 'localizacoes.id')
        ->select('localizacoes.municipio', DB::raw('COUNT(ocorrencias.id) as total'))
        ->groupBy('localizacoes.municipio')
        ->orderByDesc('total')
        ->get();

    $pdf = Pdf::loadView('modules.relatorios-pdf', [
        'total' => $total,
        'estatisticas' => $estatisticas,
        'porCategoria' => $porCategoria,
        'porMunicipio' => $porMunicipio,
        'filtros' => $request->only([
            'data_inicio',
            'data_fim',
            'categoria_id',
            'municipio',
        ]),
        'dataGeracao' => now(),
    ]);

    return $pdf->setPaper('a4', 'portrait')
        ->download('relatorio-denuncias-' . now()->format('Y-m-d_H-i-s') . '.pdf');
}

}


