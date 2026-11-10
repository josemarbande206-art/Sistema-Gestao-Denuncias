@extends('layouts.app')

@section('title', 'Bens Públicos')
@section('page-title', 'Gestão de Bens Públicos')
@section('breadcrumb', 'Recursos públicos / Bens públicos')

@section('content')

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 24px;
    }

    .stat-box {
        background: white;
        border: 1px solid #e4e7ec;
        border-radius: 10px;
        padding: 20px;
    }

    .stat-box span {
        color: #667085;
        font-size: 12px;
    }

    .stat-box strong {
        display: block;
        font-size: 27px;
        margin-top: 8px;
    }

    .filters {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .filters input,
    .filters select,
    .form-control {
        padding: 11px;
        border: 1px solid #d0d5dd;
        border-radius: 7px;
        font-size: 13px;
        background: white;
    }

    .filters input {
        flex: 1;
        min-width: 180px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 750px;
    }

    .data-table th,
    .data-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #eaecf0;
        text-align: left;
    }

    .data-table th {
        background: #f9fafb;
        color: #667085;
        font-size: 11px;
        text-transform: uppercase;
    }

    .badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .bom {
        background: #dcfce7;
        color: #166534;
    }

    .danificado {
        background: #fef3c7;
        color: #92400e;
    }

    .destruido {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-buttons {
        display: flex;
        gap: 7px;
        align-items: center;
    }

    .btn-edit {
        background: #e0edff;
        color: #175cd3;
        padding: 7px 10px;
        border-radius: 6px;
        font-size: 12px;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
        padding: 7px 10px;
        border: 0;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
    }

    .pagination-area {
        margin-top: 20px;
    }

    .empty-state {
        text-align: center;
        padding: 35px;
        color: #667085;
    }

    @media(max-width: 900px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width: 500px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<div class="page-heading">
    <div>
        <h2>Bens públicos</h2>
        <p>
            Registo, consulta e gestão dos bens pertencentes às entidades públicas.
        </p>
    </div>

    <a href="{{ route('bens-publicos.create') }}" class="button">
        + Cadastrar bem
    </a>
</div>

@if(session('sucesso'))
    <div class="alert alert-success">
        {{ session('sucesso') }}
    </div>
@endif

@if(session('erro'))
    <div class="alert alert-error">
        {{ session('erro') }}
    </div>
@endif

<div class="stats-grid">

    <div class="stat-box">
        <span>Total de bens públicos</span>
        <strong>{{ $estatisticas['total'] }}</strong>
    </div>

    <div class="stat-box">
        <span>Em bom estado</span>
        <strong>{{ $estatisticas['bons'] }}</strong>
    </div>

    <div class="stat-box">
        <span>Danificados</span>
        <strong>{{ $estatisticas['danificados'] }}</strong>
    </div>

    <div class="stat-box">
        <span>Destruídos</span>
        <strong>{{ $estatisticas['destruidos'] }}</strong>
    </div>

</div>

<div class="card">

    <h3 style="margin-top:0;">Consultar bens públicos</h3>

    <form method="GET"
          action="{{ route('bens-publicos.index') }}"
          class="filters">

        <input
            type="text"
            name="pesquisa"
            placeholder="Pesquisar pelo nome do bem..."
            value="{{ request('pesquisa') }}"
        >

        <select name="tipo">
            <option value="">Todos os tipos</option>

            @foreach($tipos as $tipo)
                <option value="{{ $tipo }}"
                    {{ request('tipo') == $tipo ? 'selected' : '' }}>
                    {{ $tipo }}
                </option>
            @endforeach
        </select>

        <select name="estado">
            <option value="">Todos os estados</option>

            <option value="bom" {{ request('estado') == 'bom' ? 'selected' : '' }}>
                Bom
            </option>

            <option value="danificado" {{ request('estado') == 'danificado' ? 'selected' : '' }}>
                Danificado
            </option>

            <option value="destruido" {{ request('estado') == 'destruido' ? 'selected' : '' }}>
                Destruído
            </option>
        </select>

        <button type="submit" class="button">Pesquisar</button>

        <a href="{{ route('bens-publicos.index') }}"
           class="button"
           style="background:#667085;">
            Limpar
        </a>

    </form>

    <div class="table-wrapper">

        <table class="data-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do bem</th>
                    <th>Tipo</th>
                    <th>Localização</th>
                    <th>Estado</th>
                    <th>Data de registo</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse($bens as $bem)

                    <tr>
                        <td>{{ $bem->id }}</td>

                        <td>
                            <strong>{{ $bem->nome }}</strong>
                        </td>

                        <td>{{ $bem->tipo ?? 'Não definido' }}</td>

                        <td>
                            @if($bem->provincia || $bem->municipio)
                                {{ $bem->provincia ?? '' }}
                                {{ $bem->municipio ? ' - '.$bem->municipio : '' }}
                            @else
                                Não definida
                            @endif
                        </td>

                        <td>
                            <span class="badge {{ $bem->estado_conservacao }}">
                                @switch($bem->estado_conservacao)
                                    @case('bom')
                                        Bom
                                        @break

                                    @case('danificado')
                                        Danificado
                                        @break

                                    @case('destruido')
                                        Destruído
                                        @break

                                    @default
                                        Não definido
                                @endswitch
                            </span>
                        </td>

                        <td>
                            {{ $bem->criado_em ? \Carbon\Carbon::parse($bem->criado_em)->format('d/m/Y') : '—' }}
                        </td>

                        <td>
                            <div class="action-buttons">

                                <a href="{{ route('bens-publicos.edit', $bem->id) }}"
                                   class="btn-edit">
                                    Editar
                                </a>

                                <form method="POST"
                                      action="{{ route('bens-publicos.destroy', $bem->id) }}"
                                      onsubmit="return confirm('Tens a certeza de que pretendes eliminar este bem público?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-delete">
                                        Eliminar
                                    </button>

                                </form>

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="empty-state">
                            Ainda não existem bens públicos registados.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="pagination-area">
        {{ $bens->links() }}
    </div>

</div>

@endsection
