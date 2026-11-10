@extends('layouts.app')

@section('title', 'Gestão de Categorias')
@section('page-title', 'Gestão de Categorias')

@section('content')

<div class="page-heading">
    <div>
        <h1>Gestão de Categorias</h1>
        <p>Administre as categorias de vandalização de bens públicos.</p>
    </div>

    <a href="{{ route('categorias.create') }}" class="button">
        + Nova Categoria
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
    <h3>Total de categorias</h3>
    <h2>{{ $total }}</h2>
</div>

<div class="card">

    <form action="{{ route('categorias.index') }}" method="GET"
          style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">

        <input
            type="text"
            name="pesquisa"
            value="{{ $pesquisa }}"
            placeholder="Pesquisar categoria..."
            class="form-control"
            style="flex:1; min-width:200px;"
        >

        <button type="submit" class="button">
            Pesquisar
        </button>

        <a href="{{ route('categorias.index') }}" class="button">
            Limpar
        </a>
    </form>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse;">

            <thead>
                <tr>
                    <th style="padding:12px; text-align:left;">ID</th>
                    <th style="padding:12px; text-align:left;">Nome</th>
                    <th style="padding:12px; text-align:left;">Descrição</th>
                    <th style="padding:12px; text-align:left;">Data de registo</th>
                    <th style="padding:12px; text-align:left;">Ações</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categorias as $categoria)
                    <tr style="border-top:1px solid #e5e7eb;">

                        <td style="padding:12px;">
                            {{ $categoria->id }}
                        </td>

                        <td style="padding:12px;">
                            {{ $categoria->nome }}
                        </td>

                        <td style="padding:12px;">
                            {{ $categoria->descricao ?: 'Sem descrição' }}
                        </td>

                        <td style="padding:12px;">
                            {{ $categoria->criado_em
                                ? \Carbon\Carbon::parse($categoria->criado_em)->format('d/m/Y')
                                : '—' }}
                        </td>

                        <td style="padding:12px; white-space:nowrap;">

                            <a
                                href="{{ route('categorias.edit', $categoria->id) }}"
                                class="button"
                            >
                                Editar
                            </a>

                            <form
                                action="{{ route('categorias.destroy', $categoria->id) }}"
                                method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Tens a certeza de que pretendes eliminar esta categoria?');"
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
                        <td colspan="5" style="padding:25px; text-align:center;">
                            Nenhuma categoria encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $categorias->links() }}
    </div>

</div>

@endsection
