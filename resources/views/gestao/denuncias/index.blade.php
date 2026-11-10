@extends('layouts.app')

@section('content')

<style>
    .page-title {
        color: #172033;
        font-size: 27px;
        font-weight: 750;
        margin-bottom: 6px;
    }

    .page-subtitle {
        color: #64748b;
        margin-bottom: 25px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 25px;
    }

    .stat-card {
        padding: 22px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
    }

    .stat-card span {
        display: block;
        color: #64748b;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .stat-card strong {
        color: #1e3a8a;
        font-size: 29px;
    }

    .panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        overflow: hidden;
    }

    .filters {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        padding: 18px;
        border-bottom: 1px solid #e2e8f0;
    }

    .filters input,
    .filters select {
        min-height: 42px;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background: #fff;
    }

    .filters input {
        flex: 1;
        min-width: 200px;
    }

    .btn {
        display: inline-block;
        padding: 11px 15px;
        border: none;
        border-radius: 8px;
        background: #1e3a8a;
        color: #fff;
        font-size: 13px;
        font-weight: 650;
        text-decoration: none;
        cursor: pointer;
    }

    .btn:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .btn-light {
        background: #e2e8f0;
        color: #334155;
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    th {
        padding: 14px 16px;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    td {
        padding: 16px;
        border-top: 1px solid #f1f5f9;
        font-size: 13px;
    }

    tbody tr:hover {
        background: #f8fafc;
    }

    .code {
        color: #1d4ed8;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .pendente {
        color: #c2410c;
        background: #fff7ed;
    }

    .em_analise {
        color: #1d4ed8;
        background: #eff6ff;
    }

    .confirmada {
        color: #6d28d9;
        background: #f5f3ff;
    }

    .resolvida {
        color: #166534;
        background: #dcfce7;
    }

    .rejeitada {
        color: #b91c1c;
        background: #fee2e2;
    }

    .empty {
        padding: 30px;
        text-align: center;
        color: #64748b;
    }

    .pagination {
        padding: 18px;
    }

    .alert-success {
        padding: 14px 16px;
        margin-bottom: 20px;
        background: #dcfce7;
        color: #166534;
        border-radius: 9px;
    }

    @media (max-width: 900px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>

<div>
    <h1 class="page-title">Gestão de denúncias</h1>

    <p class="page-subtitle">
        Consulte, pesquise e acompanhe as ocorrências registadas.
    </p>
</div>

@if (session('sucesso'))
    <div class="alert-success">
        {{ session('sucesso') }}
    </div>
@endif

<div class="stats-grid">
    <div class="stat-card">
        <span>Total de denúncias</span>
        <strong>{{ $estatisticas['total'] }}</strong>
    </div>

    <div class="stat-card">
        <span>Pendentes</span>
        <strong>{{ $estatisticas['pendentes'] }}</strong>
    </div>

    <div class="stat-card">
        <span>Em análise</span>
        <strong>{{ $estatisticas['em_analise'] }}</strong>
    </div>

    <div class="stat-card">
        <span>Resolvidas</span>
        <strong>{{ $estatisticas['resolvidas'] }}</strong>
    </div>
</div>

<div class="panel">

    <form
        method="GET"
        action="{{ route('gestao.denuncias.index') }}"
        class="filters"
    >
        <input
            type="text"
            name="pesquisa"
            placeholder="Pesquisar por código ou título..."
            value="{{ request('pesquisa') }}"
        >

        <select name="estado">
            <option value="">Todos os estados</option>

            <option value="pendente" @selected(request('estado') === 'pendente')>
                Pendente
            </option>

            <option value="em_analise" @selected(request('estado') === 'em_analise')>
                Em análise
            </option>

            <option value="confirmada" @selected(request('estado') === 'confirmada')>
                Confirmada
            </option>

            <option value="resolvida" @selected(request('estado') === 'resolvida')>
                Resolvida
            </option>

            <option value="rejeitada" @selected(request('estado') === 'rejeitada')>
                Rejeitada
            </option>
        </select>

        <button type="submit" class="btn">Pesquisar</button>

        <a
            href="{{ route('gestao.denuncias.index') }}"
            class="btn btn-light"
        >
            Limpar
        </a>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Data da ocorrência</th>
                    <th>Estado</th>
                    <th>Ação</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($denuncias as $denuncia)
                    <tr>
                        <td class="code">
                            {{ $denuncia->codigo }}
                        </td>

                        <td>{{ $denuncia->titulo }}</td>

                        <td>
                            {{ $denuncia->categoria ?? 'Não definida' }}
                        </td>

                        <td>
                            @if ($denuncia->data_ocorrencia)
                                {{ \Illuminate\Support\Carbon::parse($denuncia->data_ocorrencia)->format('d/m/Y H:i') }}
                            @else
                                Não indicada
                            @endif
                        </td>

                        <td>
                            <span class="badge {{ $denuncia->estado }}">
                                @php
                                    $estados = [
                                        'pendente' => 'Pendente',
                                        'em_analise' => 'Em análise',
                                        'confirmada' => 'Confirmada',
                                        'resolvida' => 'Resolvida',
                                        'rejeitada' => 'Rejeitada',
                                    ];
                                @endphp

                                {{ $estados[$denuncia->estado] ?? $denuncia->estado }}
                            </span>
                        </td>

                        <td>
                            <a
                                href="{{ route('gestao.denuncias.show', $denuncia->id) }}"
                                class="btn"
                            >
                                Ver detalhes
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">
                            Não foram encontradas denúncias.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $denuncias->links() }}
    </div>

</div>

@endsection