@extends('layouts.app')

@section('title', 'Minhas Denúncias')
@section('page-title', 'Minhas Denúncias')
@section('breadcrumb', 'Minhas Denúncias')

@push('styles')

<style>
    /* Área principal */
    .denuncias-page {
        width: 100%;
    }

    .denuncias-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .denuncias-header h2 {
        margin: 0 0 7px;
        font-size: 23px;
        color: #202124;
    }

    .denuncias-header p {
        margin: 0;
        color: #70757a;
        font-size: 13px;
        line-height: 1.6;
    }

    .btn-registar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 17px;
        background: #176b57;
        color: #ffffff;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 700;
        transition: .2s;
        white-space: nowrap;
    }

    .btn-registar:hover {
        background: #125443;
        color: #ffffff;
    }

    /* Cartão da tabela */
    .denuncias-card {
        background: #ffffff;
        border: 1px solid #e8eaed;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(16,24,40,.025);
    }

    .denuncias-card-header {
        padding: 20px 22px;
        border-bottom: 1px solid #e8eaed;
    }

    .denuncias-card-header h3 {
        margin: 0 0 5px;
        font-size: 16px;
        color: #202124;
    }

    .denuncias-card-header p {
        margin: 0;
        color: #70757a;
        font-size: 12px;
    }

    /* Pesquisa e filtros */
    .filtros-denuncias {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 22px;
        border-bottom: 1px solid #e8eaed;
    }

    .campo-pesquisa {
        position: relative;
        flex: 1;
    }

    .campo-pesquisa input,
    .filtro-estado select {
        width: 100%;
        height: 42px;
        padding: 0 13px;
        border: 1px solid #e0e3e7;
        border-radius: 7px;
        background: #ffffff;
        color: #202124;
        font-family: inherit;
        font-size: 13px;
        outline: none;
    }

    .campo-pesquisa input:focus,
    .filtro-estado select:focus {
        border-color: #176b57;
        box-shadow: 0 0 0 3px rgba(23,107,87,.08);
    }

    .filtro-estado {
        width: 190px;
    }

    .btn-filtrar {
        height: 42px;
        padding: 0 18px;
        border: none;
        border-radius: 7px;
        background: #176b57;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-filtrar:hover {
        background: #125443;
    }

    .btn-limpar {
        color: #70757a;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .btn-limpar:hover {
        color: #176b57;
    }

    /* Tabela */
    .tabela-responsiva {
        width: 100%;
        overflow-x: auto;
    }

    .tabela-denuncias {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    .tabela-denuncias thead {
        background: #f7f8fa;
    }

    .tabela-denuncias th {
        padding: 14px 18px;
        text-align: left;
        color: #70757a;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        border-bottom: 1px solid #e8eaed;
    }

    .tabela-denuncias td {
        padding: 16px 18px;
        border-bottom: 1px solid #f0f1f2;
        color: #444444;
        font-size: 13px;
    }

    .tabela-denuncias tbody tr:hover {
        background: #f9fbfa;
    }

    .codigo-denuncia {
        color: #176b57;
        font-weight: 700;
        white-space: nowrap;
    }

    .titulo-denuncia {
        color: #202124;
        font-weight: 600;
    }

    /* Estados */
    .estado {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .estado-pendente {
        background: #f2f3f3;
        color: #555b59;
    }

    .estado-em_analise {
        background: #e6f4ef;
        color: #176b57;
    }

    .estado-confirmada {
        background: #dcece5;
        color: #125443;
    }

    .estado-resolvida {
        background: #176b57;
        color: #ffffff;
    }

    .estado-rejeitada {
        background: #eeeeee;
        color: #555555;
    }

    /* Estado vazio */
    .denuncias-vazio {
        padding: 55px 20px !important;
        text-align: center;
    }

    .denuncias-vazio h4 {
        margin: 12px 0 7px;
        color: #202124;
        font-size: 15px;
    }

    .denuncias-vazio p {
        margin: 0;
        color: #70757a;
        font-size: 12px;
    }

    /* Rodapé e paginação */
    .denuncias-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 17px 22px;
    }

    .denuncias-footer p {
        margin: 0;
        color: #70757a;
        font-size: 12px;
    }

    .denuncias-paginacao nav {
        display: flex;
        justify-content: flex-end;
    }

    .denuncias-paginacao nav div:first-child {
        display: none;
    }

    .denuncias-paginacao nav div:last-child {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .denuncias-paginacao a,
    .denuncias-paginacao span[aria-current="page"] span {
        display: inline-block;
        padding: 7px 11px;
        border: 1px solid #e8eaed;
        border-radius: 5px;
        color: #176b57;
        font-size: 12px;
        text-decoration: none;
    }

    .denuncias-paginacao span[aria-current="page"] span {
        background: #176b57;
        color: #ffffff;
        border-color: #176b57;
    }

    @media (max-width: 700px) {
        .denuncias-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .filtros-denuncias {
            align-items: stretch;
            flex-direction: column;
        }

        .filtro-estado {
            width: 100%;
        }

        .denuncias-footer {
            align-items: flex-start;
            flex-direction: column;
        }
    /* Animações de entrada */
@keyframes entradaSuave {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }

    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.denuncias-page {
    animation: entradaSuave 1s ease both;
}

.denuncias-header {
    animation: entradaSuave 0.8s ease both;
}

.denuncias-page .card {
    animation: entradaSuave 1s ease both;
    animation-delay: 0.25s;
}

@media (prefers-reduced-motion: reduce) {
    .denuncias-page,
    .denuncias-header,
    .denuncias-page .card {
        animation: none;
    }
}

</style>
@endpush

@section('content')

<div class="denuncias-page">

    <div class="denuncias-header">
        <div>
            <h2>Minhas Denúncias</h2>
            <p>
                Consulte e acompanhe as denúncias de vandalização
                de bens públicos que registou no sistema.
            </p>
        </div>

        <a href="{{ route('denuncias.create') }}" class="btn-registar">
            + Registar denúncia
        </a>
    </div>

    <div class="denuncias-card">

        <div class="denuncias-card-header">
            <h3>Lista de denúncias</h3>
            <p>Consulte os detalhes e o estado das suas ocorrências.</p>
        </div>

        <form method="GET"
              action="{{ route('denuncias.index') }}"
              class="filtros-denuncias">

            <div class="campo-pesquisa">
                <input
                    type="text"
                    name="pesquisa"
                    placeholder="Pesquisar por código ou título..."
                    value="{{ request('pesquisa') }}"
                >
            </div>

            <div class="filtro-estado">
                <select name="estado">
                    <option value="">Todos os estados</option>

                    <option value="pendente"
                        {{ request('estado') == 'pendente' ? 'selected' : '' }}>
                        Pendente
                    </option>

                    <option value="em_analise"
                        {{ request('estado') == 'em_analise' ? 'selected' : '' }}>
                        Em análise
                    </option>

                    <option value="confirmada"
                        {{ request('estado') == 'confirmada' ? 'selected' : '' }}>
                        Confirmada
                    </option>

                    <option value="resolvida"
                        {{ request('estado') == 'resolvida' ? 'selected' : '' }}>
                        Resolvida
                    </option>

                    <option value="rejeitada"
                        {{ request('estado') == 'rejeitada' ? 'selected' : '' }}>
                        Rejeitada
                    </option>
                </select>
            </div>

            <button type="submit" class="btn-filtrar">
                Pesquisar
            </button>

            <a href="{{ route('denuncias.index') }}" class="btn-limpar">
                Limpar
            </a>

        </form>

        <div class="tabela-responsiva">

            <table class="tabela-denuncias">

                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Data da ocorrência</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($denuncias as $denuncia)

                        <tr>
                            <td>
                                <span class="codigo-denuncia">
                                    {{ $denuncia->codigo }}
                                </span>
                            </td>

                            <td>
                                <span class="titulo-denuncia">
                                    {{ $denuncia->titulo }}
                                </span>
                            </td>

                            <td>
                                {{ $denuncia->categoria ?? 'Não definida' }}
                            </td>

                            <td>
                                {{ $denuncia->data_ocorrencia }}
                            </td>

                            <td>
                                <span class="estado estado-{{ $denuncia->estado }}">
                                    {{ ucfirst(str_replace('_', ' ', $denuncia->estado)) }}
                                </span>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="denuncias-vazio">
                                <h4>Nenhuma denúncia encontrada</h4>
                                <p>
                                    Ainda não existem denúncias para apresentar
                                    ou não foram encontrados resultados para a pesquisa.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="denuncias-footer">

            <p>
                @if($denuncias->total() > 0)
                    A apresentar {{ $denuncias->firstItem() }}
                    a {{ $denuncias->lastItem() }}
                    de {{ $denuncias->total() }} denúncias.
                @else
                    Nenhuma denúncia registada.
                @endif
            </p>

            <div class="denuncias-paginacao">
                {{ $denuncias->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
