@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Visão geral')

@section('content')

<div class="page-heading">
    <div>
        <h2>Visão geral do sistema</h2>
        <p>
            Acompanhe as denúncias de vandalização e o estado
            das ocorrências registadas.
        </p>
    </div>

    <a href="{{ route('denuncias.create') }}" class="button">
        + Nova denúncia
    </a>
</div>

<div class="dashboard-grid">

    <div class="stat-card">
        <div class="stat-label">Total de denúncias</div>
        <div class="stat-number">{{ $total }}</div>
        <div class="stat-description">Registos no sistema</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Pendentes</div>
        <div class="stat-number">{{ $pendentes }}</div>
        <div class="stat-description">Aguardam análise</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Em análise</div>
        <div class="stat-number">{{ $emAnalise }}</div>
        <div class="stat-description">Em verificação</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Confirmadas</div>
        <div class="stat-number">{{ $confirmadas }}</div>
        <div class="stat-description">Ocorrências confirmadas</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Resolvidas</div>
        <div class="stat-number">{{ $resolvidas }}</div>
        <div class="stat-description">Tratamento concluído</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Rejeitadas</div>
        <div class="stat-number">{{ $rejeitadas }}</div>
        <div class="stat-description">Não aceites após análise</div>
    </div>

</div>

<div class="dashboard-panel">

    <div class="panel-header">
        <div>
            <h3>Denúncias recentes</h3>
            <p>Últimas ocorrências registadas no sistema.</p>
        </div>

        <a href="{{ route('denuncias.index') }}" class="panel-link">
            Ver todas →
        </a>
    </div>

    <div class="table-wrapper">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Data de registo</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recentes as $denuncia)
                    <tr>
                        <td class="code-cell">
                            {{ $denuncia->codigo }}
                        </td>

                        <td>{{ $denuncia->titulo }}</td>

                        <td>
                            {{ $denuncia->categoria ?? 'Não definida' }}
                        </td>

                        <td>
                            {{ $denuncia->data_registo ?? 'Não disponível' }}
                        </td>

                        <td>
                            <span class="state-badge state-{{ $denuncia->estado }}">
                                {{ ucfirst(str_replace('_', ' ', $denuncia->estado)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            Ainda não existem denúncias registadas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection

@push('styles')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 26px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e4e7ec;
        border-radius: 12px;
        padding: 22px;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #176b57;
    }

    .stat-label {
        color: #667085;
        font-size: 12px;
        font-weight: 600;
    }

    .stat-number {
        font-size: 32px;
        font-weight: 800;
        margin: 14px 0 8px;
        color: #17243a;
    }

    .stat-description {
        color: #667085;
        font-size: 11px;
    }

    .dashboard-panel {
        background: white;
        border: 1px solid #e4e7ec;
        border-radius: 12px;
        overflow: hidden;
    }

    .panel-header {
        padding: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        border-bottom: 1px solid #e4e7ec;
    }

    .panel-header h3 {
        margin: 0 0 7px;
        font-size: 16px;
    }

    .panel-header p {
        margin: 0;
        color: #667085;
        font-size: 12px;
    }

    .panel-link {
        color: #176b57;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .dashboard-table th {
        text-align: left;
        padding: 14px 18px;
        background: #f8fafc;
        color: #667085;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .dashboard-table td {
        padding: 16px 18px;
        border-top: 1px solid #eef0f4;
        white-space: nowrap;
    }

    .code-cell {
        color: #176b57;
        font-weight: 700;
    }

    .state-badge {
        display: inline-block;
        border-radius: 20px;
        padding: 6px 9px;
        font-size: 10px;
        font-weight: 700;
        background: #eef2f6;
        color: #344054;
    }

    .state-pendente {
        background: #fff2cc;
        color: #855b00;
    }

    .state-em_analise {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .state-confirmada {
        background: #d1fae5;
        color: #065f46;
    }

    .state-resolvida {
        background: #dcfce7;
        color: #166534;
    }

    .state-rejeitada {
        background: #fee2e2;
        color: #991b1b;
    }

    .empty-state {
        padding: 30px !important;
        text-align: center;
        color: #667085;
    }

    @media (max-width: 1100px) {
        .dashboard-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 520px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .panel-header {
            align-items: flex-start;
        }
    }
</style>
@endpush
