@extends('layouts.app')

@section('title', 'Painel Administrativo')
@section('page-title', 'Painel Administrativo')
@section('breadcrumb', 'Visão geral')

@section('content')

@php
    $estados = [
        [
            'nome' => 'Pendentes',
            'valor' => $pendentes,
            'cor' => '#c69b32',
            'classe' => 'pending'
        ],
        [
            'nome' => 'Em análise',
            'valor' => $emAnalise,
            'cor' => '#718b7d',
            'classe' => 'analysis'
        ],
        [
            'nome' => 'Confirmadas',
            'valor' => $confirmadas,
            'cor' => '#47856a',
            'classe' => 'confirmed'
        ],
        [
            'nome' => 'Resolvidas',
            'valor' => $resolvidas,
            'cor' => '#176b57',
            'classe' => 'resolved'
        ],
        [
            'nome' => 'Rejeitadas',
            'valor' => $rejeitadas,
            'cor' => '#9b665d',
            'classe' => 'rejected'
        ],
    ];
@endphp

<div class="dashboard-container">

    {{-- CABEÇALHO --}}
    <div class="dashboard-header">
        <div>
            <h2>Painel Administrativo</h2>
            <p>Acompanhamento geral das denúncias de vandalização de bens públicos.</p>
        </div>

        <div class="dashboard-date">
            <span>DATA ACTUAL</span>
            <strong>{{ now()->translatedFormat('d/m/Y') }}</strong>
        </div>
    </div>

    {{-- INDICADORES --}}
    <section class="dashboard-section">

        <div class="section-title">
            <div>
                <h3>Indicadores gerais</h3>
                <p>Estado actual das ocorrências registadas no sistema.</p>
            </div>
        </div>

        <div class="stats-grid">

            <div class="stat-card total">
                <div class="stat-card-header">
                    <span>Total de denúncias</span>
                    <span class="stat-symbol">T</span>
                </div>
                <strong>{{ $total }}</strong>
                <small>Registos existentes</small>
            </div>

            <div class="stat-card pending">
                <div class="stat-card-header">
                    <span>Pendentes</span>
                    <span class="stat-symbol">P</span>
                </div>
                <strong>{{ $pendentes }}</strong>
                <small>Aguardam análise</small>
            </div>

            <div class="stat-card analysis">
                <div class="stat-card-header">
                    <span>Em análise</span>
                    <span class="stat-symbol">A</span>
                </div>
                <strong>{{ $emAnalise }}</strong>
                <small>Em verificação</small>
            </div>

            <div class="stat-card confirmed">
                <div class="stat-card-header">
                    <span>Confirmadas</span>
                    <span class="stat-symbol">C</span>
                </div>
                <strong>{{ $confirmadas }}</strong>
                <small>Ocorrências confirmadas</small>
            </div>

            <div class="stat-card resolved">
                <div class="stat-card-header">
                    <span>Resolvidas</span>
                    <span class="stat-symbol">R</span>
                </div>
                <strong>{{ $resolvidas }}</strong>
                <small>Tratamento concluído</small>
            </div>

            <div class="stat-card rejected">
                <div class="stat-card-header">
                    <span>Rejeitadas</span>
                    <span class="stat-symbol">X</span>
                </div>
                <strong>{{ $rejeitadas }}</strong>
                <small>Não aceites após análise</small>
            </div>

        </div>
    </section>

    {{-- DISTRIBUIÇÃO ESTATÍSTICA --}}
 	{{-- GRÁFICOS ESTATÍSTICOS --}}
<section class="dashboard-section">

    <div class="section-title">
        <div>
            <h3>Análise estatística das denúncias</h3>
            <p>Visualização gráfica das ocorrências por estado de tratamento.</p>
        </div>
    </div>

    @if($total > 0)

        <div class="real-charts-grid">

            {{-- GRÁFICO CIRCULAR --}}
            <div class="real-chart-card">
                <div class="real-chart-header">
                    <h4>Distribuição por estado</h4>
                    <p>Percentagem de denúncias em cada estado.</p>
                </div>

                <div class="real-chart-container">
                    <canvas id="graficoCircular"></canvas>
                </div>
            </div>

            {{-- GRÁFICO DE BARRAS --}}
            <div class="real-chart-card">
                <div class="real-chart-header">
                    <h4>Quantidade por estado</h4>
                    <p>Comparação do número de denúncias registadas.</p>
                </div>

                <div class="real-chart-container">
                    <canvas id="graficoBarras"></canvas>
                </div>
            </div>

        </div>

    @else

        <div class="real-chart-card real-chart-empty">
            Ainda não existem denúncias registadas para apresentar gráficos.
        </div>

    @endif

</section> 
</div>

@endsection

@push('styles')
<style>
    .dashboard-container {
        width: 100%;
        color: #263b30;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
    }

    .dashboard-header h2 {
        margin: 0 0 7px;
        color: #173b2d;
        font-size: 23px;
        font-weight: 750;
    }

    .dashboard-header p {
        margin: 0;
        color: #78847c;
        font-size: 13px;
    }

    .dashboard-date {
        min-width: 130px;
        padding: 13px 16px;
        background: #fff;
        border: 1px solid #e5ebe6;
        border-radius: 8px;
    }

    .dashboard-date span {
        display: block;
        margin-bottom: 6px;
        color: #89938d;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .8px;
    }

    .dashboard-date strong {
        color: #176b57;
        font-size: 15px;
    }

    .dashboard-section {
        margin-bottom: 28px;
    }

    .section-title {
        margin-bottom: 17px;
    }

    .section-title h3 {
        margin: 0 0 5px;
        color: #173b2d;
        font-size: 16px;
        font-weight: 750;
    }

    .section-title p {
        margin: 0;
        color: #89938d;
        font-size: 12px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .stat-card {
        min-width: 0;
        padding: 20px;
        background: #fff;
        border: 1px solid #e6ebe7;
        border-left: 4px solid #176b57;
        border-radius: 9px;
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 20px rgba(23, 59, 45, .07);
    }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        color: #64736a;
        font-size: 12px;
        font-weight: 650;
    }

    .stat-symbol {
        display: grid;
        place-items: center;
        width: 32px;
        height: 32px;
        border-radius: 7px;
        background: #edf4ef;
        color: #176b57;
        font-size: 12px;
        font-weight: 800;
    }

    .stat-card > strong {
        display: block;
        margin: 17px 0 6px;
        color: #173b2d;
        font-size: 31px;
        font-weight: 800;
        line-height: 1.1;
    }

    .stat-card small {
        color: #89938d;
        font-size: 11px;
    }

    .stat-card.total {
        border-left-color: #173b2d;
    }

    .stat-card.pending {
        border-left-color: #c69b32;
    }

    .stat-card.analysis {
        border-left-color: #718b7d;
    }

    .stat-card.confirmed {
        border-left-color: #47856a;
    }

    .stat-card.resolved {
        border-left-color: #176b57;
    }

    .stat-card.rejected {
        border-left-color: #9b665d;
    }

    .chart-card {
        padding: 24px;
        background: #fff;
        border: 1px solid #e6ebe7;
        border-radius: 10px;
    }

    .chart-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 18px;
        margin-bottom: 22px;
        border-bottom: 1px solid #edf0ed;
    }

    .chart-summary span {
        color: #64736a;
        font-size: 12px;
        font-weight: 650;
    }

    .chart-summary strong {
        color: #176b57;
        font-size: 22px;
        font-weight: 800;
    }

    .chart-content {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .chart-row {
        display: grid;
        grid-template-columns: 125px minmax(80px, 1fr) 95px;
        align-items: center;
        gap: 18px;
    }

    .chart-label {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #52645a;
        font-size: 12px;
        font-weight: 650;
    }

    .chart-dot {
        width: 9px;
        height: 9px;
        flex-shrink: 0;
        border-radius: 50%;
    }

    .chart-track {
        width: 100%;
        height: 10px;
        overflow: hidden;
        background: #edf1ed;
        border-radius: 20px;
    }

    .chart-bar {
        height: 100%;
        min-width: 0;
        border-radius: 20px;
        transition: width .5s ease;
    }

    .chart-value {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 9px;
    }

    .chart-value strong {
        color: #263b30;
        font-size: 13px;
    }

    .chart-value span {
        min-width: 48px;
        color: #89938d;
        font-size: 10px;
        text-align: right;
    }

    .chart-empty {
        padding: 25px 10px;
        color: #89938d;
        font-size: 12px;
        text-align: center;
    }

    @media (max-width: 900px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .dashboard-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .dashboard-date {
            width: 100%;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .chart-card {
            padding: 17px;
        }

        .chart-row {
            grid-template-columns: 100px minmax(50px, 1fr) 75px;
            gap: 9px;
        }

        .chart-label {
            font-size: 10px;
        }

        .chart-value {
            gap: 5px;
        }

        .chart-value span {
            min-width: 39px;
            font-size: 9px;
        }
    }
</style>
@endpush


@push('styles')
<style>
    .real-charts-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .real-chart-card {
        background: #fff;
        border: 1px solid #e5ebe6;
        border-radius: 10px;
        padding: 22px;
        min-width: 0;
    }

    .real-chart-header {
        margin-bottom: 20px;
    }

    .real-chart-header h4 {
        margin: 0 0 6px;
        color: #173b2d;
        font-size: 15px;
        font-weight: 700;
    }

    .real-chart-header p {
        margin: 0;
        color: #89938d;
        font-size: 12px;
    }

    .real-chart-container {
        position: relative;
        width: 100%;
        height: 300px;
    }

    .real-chart-empty {
        padding: 35px;
        text-align: center;
        color: #89938d;
        font-size: 13px;
    }

    @media (max-width: 900px) {
        .real-charts-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const estados = [
        'Pendentes',
        'Em análise',
        'Confirmadas',
        'Resolvidas',
        'Rejeitadas'
    ];

    const quantidades = [
    {{ $pendentes }},
    {{ $emAnalise }},
    {{ $confirmadas }},
    {{ $resolvidas }},
    {{ $rejeitadas }}
];

    const cores = [
        '#c69b32',
        '#718b7d',
        '#47856a',
        '#176b57',
        '#9b665d'
    ];

    // GRÁFICO CIRCULAR

    const circular = document.getElementById('graficoCircular');

    if (circular) {
        new Chart(circular, {
            type: 'doughnut',

            data: {
                labels: estados,

                datasets: [{
                    data: quantidades,
                    backgroundColor: cores,
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 8
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: 'bottom',

                        labels: {
                            padding: 18,
                            usePointStyle: true,
                            font: {
                                size: 11
                            }
                        }
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = quantidades.reduce(
                                    (a, b) => a + b, 0
                                );

                                const valor = context.raw;
                                const percentagem = total > 0
                                    ? (valor / total * 100).toFixed(1)
                                    : 0;

                                return valor + ' denúncias (' +
                                    percentagem + '%)';
                            }
                        }
                    }
                },

                cutout: '65%'
            }
        });
    }

    // GRÁFICO DE BARRAS

    const barras = document.getElementById('graficoBarras');

    if (barras) {
        new Chart(barras, {
            type: 'bar',

            data: {
                labels: estados,

                datasets: [{
                    label: 'Número de denúncias',
                    data: quantidades,
                    backgroundColor: cores,
                    borderRadius: 6,
                    maxBarThickness: 45
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        grid: {
                            color: '#edf1ee'
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        },

                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    }

});
</script>

@endpush
