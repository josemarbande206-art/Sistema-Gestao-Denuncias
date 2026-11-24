@extends('layouts.app')

@section('title', 'Relatórios e Estatísticas')

@section('content')

<div class="relatorios-page">

    <div class="relatorios-header">
        <div>
            <h1>Relatórios e Estatísticas</h1>
            <p>Acompanhe os dados das denúncias de vandalização de bens públicos.</p>
        </div>
    </div>
	
</a>
    {{-- FILTROS --}}
    <div class="relatorios-card">

        <h3>Filtrar relatórios</h3>

        <form method="GET" action="{{ route('relatorios.index') }}" class="filtros-form">

            <div class="filtro-grupo">
                <label>Data inicial</label>
                <input type="date" name="data_inicio"
                       value="{{ request('data_inicio') }}">
            </div>

            <div class="filtro-grupo">
                <label>Data final</label>
                <input type="date" name="data_fim"
                       value="{{ request('data_fim') }}">
            </div>

            <div class="filtro-grupo">
                <label>Categoria</label>
                <select name="categoria_id">
                    <option value="">Todas as categorias</option>

                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filtro-grupo">
                <label>Município</label>
                <select name="municipio">
                    <option value="">Todos os municípios</option>

                    @foreach($municipios as $municipio)
                        <option value="{{ $municipio->municipio }}"
                            {{ request('municipio') == $municipio->municipio ? 'selected' : '' }}>
                            {{ $municipio->municipio }}
                        </option>
                    @endforeach
                </select>
            </div>
		

            <div class="filtro-acoes">
                <button type="submit" class="btn-filtrar">
                    Aplicar filtros
                </button>

                <a href="{{ route('relatorios.index') }}" class="btn-limpar">
                    Limpar
                </a>
            </div>

        </form>

    </div>
<a href="{{ route('relatorios.pdf', request()->query()) }}"
   style="display:inline-block; background:#176b57; color:white;
          padding:10px 16px; text-decoration:none; border-radius:5px;">
    Exportar PDF
</a>
    {{-- INDICADORES --}}
    <div class="relatorios-indicadores">

        <div class="indicador-card">
            <span>Total de denúncias</span>
            <strong>{{ $total }}</strong>
        </div>

        <div class="indicador-card pendente">
            <span>Pendentes</span>
            <strong>{{ $estatisticas['pendente'] }}</strong>
        </div>

        <div class="indicador-card analise">
            <span>Em análise</span>
            <strong>{{ $estatisticas['em_analise'] }}</strong>
        </div>

        <div class="indicador-card confirmada">
            <span>Confirmadas</span>
            <strong>{{ $estatisticas['confirmada'] }}</strong>
        </div>

        <div class="indicador-card resolvida">
            <span>Resolvidas</span>
            <strong>{{ $estatisticas['resolvida'] }}</strong>
        </div>

        <div class="indicador-card rejeitada">
            <span>Rejeitadas</span>
            <strong>{{ $estatisticas['rejeitada'] }}</strong>
        </div>

    </div>
	

{{-- GRÁFICOS ESTATÍSTICOS --}}
<div class="relatorios-graficos">

    <div class="relatorios-card">
        <h3>Denúncias por estado</h3>
        <div class="grafico-container">
            <canvas id="graficoEstados"></canvas>
        </div>
    </div>

    <div class="relatorios-card">
        <h3>Denúncias por categoria</h3>
        <div class="grafico-container">
            <canvas id="graficoCategorias"></canvas>
        </div>
    </div>

    <div class="relatorios-card">
        <h3>Denúncias por município</h3>
        <div class="grafico-container">
            <canvas id="graficoMunicipios"></canvas>
        </div>
    </div>

</div>
    {{-- ESTATÍSTICAS POR CATEGORIA --}}
    <div class="relatorios-card">

        <h3>Denúncias por categoria</h3>

        @if($porCategoria->isEmpty())
            <p class="sem-dados">Não existem dados para apresentar.</p>
        @else
            <div class="tabela-responsiva">
                <table>
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Total de denúncias</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($porCategoria as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

    {{-- ESTATÍSTICAS POR MUNICÍPIO --}}
    <div class="relatorios-card">

        <h3>Denúncias por município</h3>

        @if($porMunicipio->isEmpty())
            <p class="sem-dados">Não existem dados para apresentar.</p>
        @else
            <div class="tabela-responsiva">
                <table>
                    <thead>
                        <tr>
                            <th>Município</th>
                            <th>Total de denúncias</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($porMunicipio as $item)
                            <tr>
                                <td>{{ $item->municipio }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

</div>

@endsection

@push('styles')
<style>
.relatorios-page {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

/* GRÁFICOS ESTATÍSTICOS */

.relatorios-graficos {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}

.grafico-container {
    position: relative;
    width: 100%;
    height: 300px;
}

.relatorios-graficos .relatorios-card:last-child {
    grid-column: 1 / -1;
}

@media (max-width: 900px) {
    .relatorios-graficos {
        grid-template-columns: 1fr;
    }

    .relatorios-graficos .relatorios-card:last-child {
        grid-column: auto;
    }
}
.relatorios-header h1 {
    margin: 0 0 7px;
    color: #176b57;
    font-size: 25px;
}

.relatorios-header p {
    margin: 0;
    color: #777;
}

.relatorios-card,
.indicador-card {
    background: #fff;
    border: 1px solid #e8ecea;
    border-radius: 12px;
    padding: 22px;
}

.relatorios-card h3 {
    margin: 0 0 20px;
    color: #176b57;
    font-size: 17px;
}

.filtros-form {
    display: grid;
    grid-template-columns: repeat(4, minmax(150px, 1fr));
    gap: 16px;
}

.filtro-grupo {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.filtro-grupo label {
    font-size: 13px;
    font-weight: 600;
    color: #444;
}

.filtro-grupo input,
.filtro-grupo select {
    width: 100%;
    min-height: 42px;
    padding: 9px 11px;
    border: 1px solid #dce3df;
    border-radius: 7px;
    background: #fff;
    color: #333;
}

.filtro-acoes {
    display: flex;
    align-items: end;
    gap: 10px;
    grid-column: 1 / -1;
}

.btn-filtrar,
.btn-limpar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 40px;
    padding: 9px 17px;
    border-radius: 7px;
    text-decoration: none;
    cursor: pointer;
    font-size: 13px;
}

.btn-filtrar {
    border: 0;
    background: #176b57;
    color: #fff;
}

.btn-limpar {
    border: 1px solid #dce3df;
    color: #444;
    background: #f7f9f8;
}

.relatorios-indicadores {
    display: grid;
    grid-template-columns: repeat(3, minmax(160px, 1fr));
    gap: 16px;
}

.indicador-card {
    display: flex;
    flex-direction: column;
    gap: 12px;
    border-left: 4px solid #176b57;
}

.indicador-card span {
    color: #666;
    font-size: 13px;
}

.indicador-card strong {
    color: #176b57;
    font-size: 28px;
}

.indicador-card.pendente {
    border-left-color: #c28b27;
}

.indicador-card.analise {
    border-left-color: #777;
}

.indicador-card.confirmada {
    border-left-color: #176b57;
}

.indicador-card.resolvida {
    border-left-color: #176b57;
}

.indicador-card.rejeitada {
    border-left-color: #777;
}

.tabela-responsiva {
    width: 100%;
    overflow-x: auto;
}

.relatorios-card table {
    width: 100%;
    border-collapse: collapse;
}

.relatorios-card th,
.relatorios-card td {
    padding: 13px 12px;
    text-align: left;
    border-bottom: 1px solid #edf0ee;
    font-size: 13px;
}

.relatorios-card th {
    color: #176b57;
    background: #f5f8f6;
}

.sem-dados {
    color: #777;
    font-size: 13px;
}

@media (max-width: 900px) {
    .filtros-form {
        grid-template-columns: repeat(2, minmax(140px, 1fr));
    }

    .relatorios-indicadores {
        grid-template-columns: repeat(2, minmax(140px, 1fr));
    }
}

@media (max-width: 550px) {
    .filtros-form,
    .relatorios-indicadores {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Dados dos estados
    const estados = @json($estatisticas);

    // Dados das categorias
    const categorias = @json($porCategoria->pluck('total'));
    const nomesCategorias = @json($porCategoria->pluck('nome'));

    // Dados dos municípios
    const municipios = @json($porMunicipio->pluck('total'));
    const nomesMunicipios = @json($porMunicipio->pluck('municipio'));

    // Paleta institucional
    const verde = '#176b57';
    const cinza = '#777777';
    const dourado = '#c28b27';

    // Gráfico de estados
    new Chart(document.getElementById('graficoEstados'), {
        type: 'doughnut',

        data: {
            labels: [
                'Pendentes',
                'Em análise',
                'Confirmadas',
                'Resolvidas',
                'Rejeitadas'
            ],

            datasets: [{
                data: [
                    estados.pendente,
                    estados.em_analise,
                    estados.confirmada,
                    estados.resolvida,
                    estados.rejeitada
                ],

                backgroundColor: [
                    dourado,
                    cinza,
                    verde,
                    verde,
                    cinza
                ],

                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfico de categorias
    new Chart(document.getElementById('graficoCategorias'), {
        type: 'bar',

        data: {
            labels: nomesCategorias,

            datasets: [{
                label: 'Número de denúncias',
                data: categorias,
                backgroundColor: verde,
                borderRadius: 6
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
                    }
                }
            }
        }
    });

    // Gráfico de municípios
    new Chart(document.getElementById('graficoMunicipios'), {
        type: 'bar',

        data: {
            labels: nomesMunicipios,

            datasets: [{
                label: 'Número de denúncias',
                data: municipios,
                backgroundColor: dourado,
                borderRadius: 6
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
                    }
                }
            }
        }
    });

});
</script>

@endpush
