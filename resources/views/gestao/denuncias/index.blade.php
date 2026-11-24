@extends('layouts.app')

@section('title', 'Gestão de denúncias')

@section('content')

<style>
    .denuncias-container {
    width: 100%;
    max-width: 100%;
    min-width: 0;
    margin: 0 auto;
    color: #202124;
    box-sizing: border-box;
}

.denuncias-container *,
.denuncias-container *::before,
.denuncias-container *::after {
    box-sizing: border-box;
}

    .denuncias-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 25px;
    }

    .denuncias-header h1 {
        margin: 0 0 7px;
        font-size: clamp(22px, 3vw, 28px);
        font-weight: 750;
        color: #176b57;
    }

    .denuncias-header p {
        margin: 0;
        color: #667085;
        font-size: 14px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 25px;
    }

    .stat-card {
        position: relative;
        background: #fff;
        border: 1px solid #e4e7ec;
        border-radius: 12px;
        padding: 20px;
        min-width: 0;
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(16, 84, 66, .08);
    }

    .stat-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 15px;
        bottom: 15px;
        width: 4px;
        border-radius: 0 5px 5px 0;
        background: #176b57;
    }

    .stat-label {
        display: block;
        color: #667085;
        font-size: 13px;
        margin-bottom: 12px;
    }

    .stat-value {
        display: block;
        color: #176b57;
        font-size: clamp(25px, 3vw, 32px);
        font-weight: 750;
        line-height: 1;
    }

    .stat-description {
        display: block;
        margin-top: 10px;
        color: #98a2b3;
        font-size: 11px;
    }

    .denuncias-panel {
        background: #fff;
        border: 1px solid #e4e7ec;
        border-radius: 12px;
        overflow: hidden;
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 20px 22px;
        border-bottom: 1px solid #eaecf0;
    }

    .panel-header h2 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #1d2939;
    }

    .panel-header p {
        margin: 5px 0 0;
        font-size: 12px;
        color: #667085;
    }

   .filters {
    display: grid;
    grid-template-columns: minmax(200px, 1.5fr) minmax(150px, 1fr) minmax(150px, 1fr) auto auto;
    gap: 12px;
    width: 100%;
    padding: 20px 22px;
    border-bottom: 1px solid #e8eaed;
    align-items: center;
}

    .filter-control {
        width: 100%;
        min-width: 0;
        height: 43px;
        padding: 0 12px;
        border: 1px solid #d0d5dd;
        border-radius: 8px;
        background: #fff;
        color: #344054;
        font-size: 13px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .filter-control:focus {
        border-color: #176b57;
        box-shadow: 0 0 0 3px rgba(23, 107, 87, .10);
    }

    .button {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
        min-height: 39px;
        padding: 9px 13px;
        border: 0;
        border-radius: 7px;
        background: #176b57;
        color: #fff;
        font-size: 12px;
        font-weight: 650;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
        transition: background .2s, transform .2s;
    }

    .button:hover {
        background: #105442;
        color: #fff;
        transform: translateY(-1px);
    }

    .button-secondary {
        background: #e4e7ec;
        color: #344054;
    }

    .button-secondary:hover {
        background: #d0d5dd;
        color: #1d2939;
    }

    .button-danger {
        background: #b42318;
    }

    .button-danger:hover {
        background: #912018;
    }

  .table-responsive {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

    .denuncias-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        text-align: left;
    }

    .denuncias-table thead {
        background: #f8faf9;
    }

    .denuncias-table th {
        padding: 15px 18px;
        color: #667085;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        white-space: nowrap;
    }

    .denuncias-table td {
        padding: 16px 18px;
        border-top: 1px solid #eaecf0;
        color: #475467;
        font-size: 13px;
        vertical-align: middle;
    }

    .denuncias-table tbody tr {
        transition: background .2s;
    }

    .denuncias-table tbody tr:hover {
        background: #f8faf9;
    }

    .codigo-denuncia {
        display: inline-block;
        color: #176b57;
        font-weight: 750;
        white-space: nowrap;
    }

    .titulo-denuncia {
        display: block;
        max-width: 240px;
        color: #344054;
        font-weight: 600;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .estado {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .estado::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .estado-pendente {
        background: #fff4e5;
        color: #a15c00;
    }

    .estado-em_analise {
        background: #e4e7ec;
        color: #475467;
    }

    .estado-confirmada {
        background: #e6f4ef;
        color: #176b57;
    }

    .estado-resolvida {
        background: #d1e7dd;
        color: #176b57;
    }

    .estado-rejeitada {
        background: #fee4e2;
        color: #b42318;
    }

    .table-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    min-width: 140px;
}

    .table-actions form {
        margin: 0;
    }

    .empty-state {
        padding: 45px 20px !important;
        text-align: center;
        color: #667085 !important;
    }

    .empty-state strong {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: 14px;
    }

    .pagination {
        display: flex;
        justify-content: flex-end;
        padding: 18px 22px;
        border-top: 1px solid #eaecf0;
    }

    .alert-success,
    .alert-error {
        padding: 14px 16px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 13px;
    }

    .alert-success {
        background: #e6f4ef;
        border: 1px solid #b7dfd0;
        color: #176b57;
    }

    .alert-error {
        background: #fee4e2;
        color: #b42318;
    }

@media (max-width: 1100px) {
    .stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .filters {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 600px) {
    .denuncias-header {
        align-items: flex-start;
    }

    .stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .stat-card {
        padding: 16px 14px;
    }

    .stat-label {
        font-size: 11px;
    }

    .stat-value {
        font-size: 25px;
    }

    .filters {
        grid-template-columns: 1fr;
        padding: 15px;
    }

    .filters .button {
        width: 100%;
    }

    .panel-header {
        padding: 16px;
    }

    .pagination {
        justify-content: center;
        padding: 15px;
    }

    .denuncias-table th,
    .denuncias-table td {
        padding: 13px 12px;
    }
}

@media (max-width: 360px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

</style>

<div class="denuncias-container">

    <div class="denuncias-header">
        <div>
            <h1>Todas as denúncias</h1>
            <p>Consulte, pesquise e acompanhe as denúncias de vandalização de bens públicos.</p>
        </div>
    </div>

    @if(session('success') || session('sucesso'))
        <div class="alert-success">
            {{ session('success') ?? session('sucesso') }}
        </div>
    @endif

    @if(session('erro'))
        <div class="alert-error">
            {{ session('erro') }}
        </div>
    @endif

    <div class="stats-grid">

        <div class="stat-card">
            <span class="stat-label">Total de denúncias</span>
            <strong class="stat-value">{{ $estatisticas['total'] }}</strong>
            <span class="stat-description">Registos no sistema</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Pendentes</span>
            <strong class="stat-value">{{ $estatisticas['pendentes'] }}</strong>
            <span class="stat-description">Aguardam análise</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Em análise</span>
            <strong class="stat-value">{{ $estatisticas['em_analise'] }}</strong>
            <span class="stat-description">Em acompanhamento</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Resolvidas</span>
            <strong class="stat-value">{{ $estatisticas['resolvidas'] }}</strong>
            <span class="stat-description">Ocorrências concluídas</span>
        </div>

    </div>

    <div class="denuncias-panel">

        <div class="panel-header">
            <div>
                <h2>Lista de denúncias</h2>
                <p>Visualize e administre os registos efectuados.</p>
            </div>
        </div>

        <form
            method="GET"
            action="{{ route('gestao.denuncias.index') }}"
            class="filters"
        >
            <input
                class="filter-control"
                type="search"
                name="pesquisa"
                placeholder="Pesquisar código ou título..."
                value="{{ request('pesquisa') }}"
            >

<select class="filter-control" name="categoria_id">
    <option value="">Todas as categorias</option>

    @foreach($categorias as $categoria)
        <option
            value="{{ $categoria->id }}"
            @selected((string) request('categoria_id') === (string) $categoria->id)
        >
            {{ $categoria->nome }}
        </option>
    @endforeach
</select>
            <select class="filter-control" name="estado">
                <option value="">Todos os estados</option>
                <option value="pendente" @selected(request('estado') === 'pendente')>Pendente</option>
                <option value="em_analise" @selected(request('estado') === 'em_analise')>Em análise</option>
                <option value="confirmada" @selected(request('estado') === 'confirmada')>Confirmada</option>
                <option value="resolvida" @selected(request('estado') === 'resolvida')>Resolvida</option>
                <option value="rejeitada" @selected(request('estado') === 'rejeitada')>Rejeitada</option>
            </select>

            <button type="submit" class="button">
                Pesquisar
            </button>

            <a href="{{ route('gestao.denuncias.index') }}" class="button button-secondary">
                Limpar filtros
            </a>
        </form>

        <div class="table-responsive">

            <table class="denuncias-table">

                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Data da ocorrência</th>
                        <th>Estado</th>
                        <th>Acções</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($denuncias as $denuncia)

                        @php
                            $estados = [
                                'pendente' => 'Pendente',
                                'em_analise' => 'Em análise',
                                'confirmada' => 'Confirmada',
                                'resolvida' => 'Resolvida',
                                'rejeitada' => 'Rejeitada',
                            ];
                        @endphp

                        <tr>
                            <td>
                                <span class="codigo-denuncia">
                                    {{ $denuncia->codigo }}
                                </span>
                            </td>

                            <td>
                                <span class="titulo-denuncia" title="{{ $denuncia->titulo }}">
                                    {{ $denuncia->titulo }}
                                </span>
                            </td>

                            <td>
                                {{ $denuncia->categoria ?? 'Não definida' }}
                            </td>

                            <td>
                                {{ $denuncia->data_ocorrencia
                                    ? \Illuminate\Support\Carbon::parse($denuncia->data_ocorrencia)->format('d/m/Y H:i')
                                    : 'Não indicada' }}
                            </td>

                            <td>
                                <span class="estado estado-{{ $denuncia->estado }}">
                                    {{ $estados[$denuncia->estado] ?? $denuncia->estado }}
                                </span>
                            </td>

                            <td>
                                <div class="table-actions">

                                    <a
                                        href="{{ route('gestao.denuncias.show', $denuncia->id) }}"
                                        class="button"
                                    >
                                        Ver
                                    </a>

                                    <form
                                        action="{{ route('denuncias.destroy', $denuncia->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Tens a certeza de que pretendes eliminar esta denúncia? Esta operação não pode ser desfeita.');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="button button-danger">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty-state">
                                <strong>Nenhuma denúncia encontrada</strong>
                                Não existem registos correspondentes aos critérios seleccionados.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($denuncias->hasPages())
            <div class="pagination">
                {{ $denuncias->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
