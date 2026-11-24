@extends('layouts.app')

@section('title', 'Gestão de Evidências')
@section('page-title', 'Gestão de Evidências')
@section('breadcrumb', 'Evidências')

@push('styles')
<style>
    /* Página de evidências */
    .evidencias-page {
        width: 100%;
        animation: evidenciasEntrada 0.8s ease both;
    }

    @keyframes evidenciasEntrada {
        from {
            opacity: 0;
            transform: translateY(18px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .evidencias-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .evidencias-header h2 {
        margin: 0 0 7px;
        font-size: 23px;
        font-weight: 700;
        color: #202124;
    }

    .evidencias-header p {
        margin: 0;
        color: #70757a;
        font-size: 13px;
    }

    .evidencias-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 17px;
        background: #176b57;
        color: #ffffff;
        border: 1px solid #176b57;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: 0.25s ease;
        cursor: pointer;
    }

    .evidencias-btn:hover {
        background: #105441;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .evidencias-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 18px;
        margin-bottom: 22px;
    }

    .evidencias-stat {
        background: #ffffff;
        border: 1px solid #e8eaed;
        border-radius: 10px;
        padding: 20px;
        animation: evidenciasEntrada 0.8s ease both;
    }

    .evidencias-stat span {
        display: block;
        color: #70757a;
        font-size: 13px;
        margin-bottom: 9px;
    }

    .evidencias-stat strong {
        color: #176b57;
        font-size: 27px;
        font-weight: 700;
    }

    .evidencias-card {
        background: #ffffff;
        border: 1px solid #e8eaed;
        border-radius: 10px;
        margin-bottom: 22px;
        overflow: hidden;
        animation: evidenciasEntrada 0.9s ease both;
        animation-delay: 0.1s;
    }

    .evidencias-card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e8eaed;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .evidencias-card-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #202124;
    }

    .evidencias-card-header span {
        color: #70757a;
        font-size: 12px;
    }

    .evidencias-search {
        padding: 20px 22px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .evidencias-search input {
        flex: 1;
        min-width: 220px;
        padding: 11px 13px;
        border: 1px solid #e0e3e7;
        border-radius: 7px;
        outline: none;
        font-size: 13px;
    }

    .evidencias-search input:focus {
        border-color: #176b57;
        box-shadow: 0 0 0 3px rgba(23, 107, 87, 0.10);
    }

    .evidencias-btn-secondary {
        padding: 11px 16px;
        border: 1px solid #dfe3e7;
        background: #f7f8fa;
        color: #444;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: 0.2s;
    }

    .evidencias-btn-secondary:hover {
        background: #e8eaed;
        color: #202124;
    }

    .evidencias-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .evidencias-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    .evidencias-table thead {
        background: #f7f8fa;
    }

    .evidencias-table th {
        padding: 14px 17px;
        color: #626970;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        text-align: left;
        border-bottom: 1px solid #e8eaed;
    }

    .evidencias-table td {
        padding: 15px 17px;
        color: #444;
        font-size: 13px;
        border-bottom: 1px solid #f0f1f2;
        vertical-align: middle;
    }

    .evidencias-table tbody tr {
        transition: background 0.2s;
    }

    .evidencias-table tbody tr:hover {
        background: #f8fbf9;
    }

    .evidencia-id {
        color: #176b57;
        font-weight: 700;
    }

    .evidencia-denuncia strong {
        display: block;
        color: #202124;
        margin-bottom: 4px;
    }

    .evidencia-denuncia small {
        color: #70757a;
        font-size: 12px;
    }

    .evidencia-ficheiro {
        display: inline-block;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #444;
    }

    .evidencia-tipo {
        display: inline-block;
        padding: 5px 9px;
        background: #e6f4ef;
        color: #176b57;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
    }

    .evidencia-acoes {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .evidencia-ver {
        display: inline-block;
        padding: 7px 11px;
        background: #176b57;
        color: #ffffff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
        transition: 0.2s;
    }

    .evidencia-ver:hover {
        background: #105441;
        color: #ffffff;
    }

    .evidencia-eliminar {
        padding: 7px 11px;
        background: #ffffff;
        color: #555;
        border: 1px solid #dfe3e7;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .evidencia-eliminar:hover {
        background: #f1f2f3;
        color: #202124;
    }

    .evidencias-empty {
        text-align: center;
        padding: 40px 20px !important;
        color: #70757a !important;
    }

    .evidencias-pagination {
        padding: 18px 22px;
    }

    .evidencias-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .evidencias-alert {
        padding: 13px 16px;
        margin-bottom: 18px;
        border-radius: 7px;
        font-size: 13px;
    }

    .evidencias-alert-success {
        background: #e6f4ef;
        color: #176b57;
        border: 1px solid #c8e5d9;
    }

    .evidencias-alert-error {
        background: #f7f8fa;
        color: #444;
        border: 1px solid #dfe3e7;
    }

    @media (max-width: 650px) {
        .evidencias-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .evidencias-header .evidencias-btn {
            width: 100%;
        }

        .evidencias-search {
            flex-direction: column;
        }

        .evidencias-search input,
        .evidencias-search button,
        .evidencias-search a {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .evidencias-page,
        .evidencias-stat,
        .evidencias-card {
            animation: none;
        }
    }
</style>
@endpush

@section('content')

<div class="evidencias-page">

    <div class="evidencias-header">
        <div>
            <h2>Gestão de Evidências</h2>
            <p>
                Consulte e gira os ficheiros associados às denúncias
                de vandalização de bens públicos.
            </p>
        </div>

        <a href="{{ route('evidencias.create') }}" class="evidencias-btn">
            + Registar Evidência
        </a>
    </div>

    @if(session('sucesso'))
        <div class="evidencias-alert evidencias-alert-success">
            {{ session('sucesso') }}
        </div>
    @endif

    @if(session('erro'))
        <div class="evidencias-alert evidencias-alert-error">
            {{ session('erro') }}
        </div>
    @endif

    <div class="evidencias-stats">
        <div class="evidencias-stat">
            <span>Total de evidências registadas</span>
            <strong>{{ $total }}</strong>
        </div>
    </div>

    <div class="evidencias-card">

        <div class="evidencias-card-header">
            <h3>Lista de Evidências</h3>
            <span>{{ $evidencias->total() }} registo(s) encontrado(s)</span>
        </div>

        <form action="{{ route('evidencias.index') }}"
              method="GET"
              class="evidencias-search">

            <input type="text"
                   name="pesquisa"
                   placeholder="Pesquisar por ficheiro, código ou denúncia..."
                   value="{{ $pesquisa }}">

            <button type="submit" class="evidencias-btn">
                Pesquisar
            </button>

            <a href="{{ route('evidencias.index') }}"
               class="evidencias-btn-secondary">
                Limpar
            </a>
        </form>

        <div class="evidencias-table-wrapper">

            <table class="evidencias-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Denúncia</th>
                        <th>Ficheiro</th>
                        <th>Tipo</th>
                        <th>Data de envio</th>
                        <th>Acções</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($evidencias as $evidencia)
                        <tr>
                            <td>
                                <span class="evidencia-id">
                                    #{{ $evidencia->id }}
                                </span>
                            </td>

                            <td class="evidencia-denuncia">
                                <strong>{{ $evidencia->codigo }}</strong>
                                <small>{{ $evidencia->titulo }}</small>
                            </td>

                            <td>
                                <span class="evidencia-ficheiro"
                                      title="{{ $evidencia->nome_arquivo }}">
                                    {{ $evidencia->nome_arquivo }}
                                </span>
                            </td>

                            <td>
                                <span class="evidencia-tipo">
                                    {{ $evidencia->tipo_arquivo ?? 'Não definido' }}
                                </span>
                            </td>

                            <td>
                                {{ $evidencia->data_envio }}
                            </td>

                            <td>
                                <div class="evidencia-acoes">

                                    <a href="{{ asset('storage/' . $evidencia->caminho_arquivo) }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="evidencia-ver">
                                        Visualizar
                                    </a>

                                    <form action="{{ route('evidencias.destroy', $evidencia->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Tens a certeza de que pretendes eliminar esta evidência?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="evidencia-eliminar">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="evidencias-empty">
                                Não foram encontradas evidências.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <div class="evidencias-pagination">
            {{ $evidencias->links() }}
        </div>

    </div>

</div>

@endsection
