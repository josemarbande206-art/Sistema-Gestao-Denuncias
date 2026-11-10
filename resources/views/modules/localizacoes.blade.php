@extends('layouts.app')

@section('title', 'Gestão de Localizações')
@section('page-title', 'Gestão de Localizações')

@section('content')

<div class="page-heading">
    <div>
        <h1>Gestão de Localizações</h1>
        <p>Administre os locais dos bens públicos e das ocorrências.</p>
    </div>

    <a href="{{ route('localizacoes.create') }}" class="button">
        + Nova Localização
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

@if($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card" style="margin-bottom: 20px;">
    <h3>Total de localizações registadas</h3>
    <h2>{{ $total }}</h2>
</div>

<div class="card">

    <form
        action="{{ route('localizacoes.index') }}"
        method="GET"
        style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;"
    >
        <input
            type="text"
            name="pesquisa"
            value="{{ $pesquisa }}"
            placeholder="Pesquisar província, município ou bairro..."
            style="flex:1; min-width:220px; padding:12px; border:1px solid #d1d5db; border-radius:6px;"
        >

        <button type="submit" class="button">
            Pesquisar
        </button>

        <a href="{{ route('localizacoes.index') }}" class="button">
            Limpar
        </a>
    </form>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse;">

            <thead>
                <tr>
                    <th style="padding:12px; text-align:left;">ID</th>
                    <th style="padding:12px; text-align:left;">Província</th>
                    <th style="padding:12px; text-align:left;">Município</th>
                    <th style="padding:12px; text-align:left;">Bairro</th>
                    <th style="padding:12px; text-align:left;">Endereço</th>
                    <th style="padding:12px; text-align:left;">Coordenadas</th>
                    <th style="padding:12px; text-align:left;">Ações</th>
                </tr>
            </thead>

            <tbody>
                @forelse($localizacoes as $localizacao)
                    <tr style="border-top:1px solid #e5e7eb;">

                        <td style="padding:12px;">
                            {{ $localizacao->id }}
                        </td>

                        <td style="padding:12px;">
                            {{ $localizacao->provincia }}
                        </td>

                        <td style="padding:12px;">
                            {{ $localizacao->municipio }}
                        </td>

                        <td style="padding:12px;">
                            {{ $localizacao->bairro ?: '—' }}
                        </td>

                        <td style="padding:12px;">
                            {{ $localizacao->endereco ?: '—' }}
                        </td>

                        <td style="padding:12px;">
                            @if($localizacao->latitude !== null && $localizacao->longitude !== null)
                                {{ $localizacao->latitude }},
                                {{ $localizacao->longitude }}
                            @else
                                —
                            @endif
                        </td>

                        <td style="padding:12px; white-space:nowrap;">

                            <a
                                href="{{ route('localizacoes.edit', $localizacao->id) }}"
                                class="button"
                            >
                                Editar
                            </a>

                            <form
                                action="{{ route('localizacoes.destroy', $localizacao->id) }}"
                                method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Tens a certeza de que pretendes eliminar esta localização?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="button"
                                    style="background:#dc2626; color:white; border:none;"
                                >
                                    Eliminar
                                </button>
                            </form>

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" style="padding:25px; text-align:center;">
                            Nenhuma localização encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $localizacoes->links() }}
    </div>

</div>

@endsection
