@extends('layouts.app')

@section('title', isset($categoria) ? 'Editar Categoria' : 'Nova Categoria')
@section('page-title', 'Gestão de Categorias')

@section('content')

<div class="page-heading">
    <div>
        <h1>{{ isset($categoria) ? 'Editar Categoria' : 'Nova Categoria' }}</h1>
        <p>
            {{ isset($categoria)
                ? 'Atualize os dados da categoria.'
                : 'Preencha os dados para registar uma nova categoria.' }}
        </p>
    </div>

    <a href="{{ route('categorias.index') }}" class="button">
        Voltar
    </a>
</div>

@if($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">

    <form
        action="{{ isset($categoria)
            ? route('categorias.update', $categoria->id)
            : route('categorias.store') }}"
        method="POST"
    >

        @csrf

        @if(isset($categoria))
            @method('PUT')
        @endif

        <div style="margin-bottom:20px;">
            <label for="nome" style="display:block; margin-bottom:8px;">
                Nome da categoria *
            </label>

            <input
                type="text"
                id="nome"
                name="nome"
                value="{{ old('nome', $categoria->nome ?? '') }}"
                maxlength="100"
                required
                placeholder="Ex.: Vandalização de iluminação pública"
                style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:6px;"
            >
        </div>

        <div style="margin-bottom:20px;">
            <label for="descricao" style="display:block; margin-bottom:8px;">
                Descrição
            </label>

            <textarea
                id="descricao"
                name="descricao"
                rows="5"
                placeholder="Descreva esta categoria..."
                style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:6px;"
            >{{ old('descricao', $categoria->descricao ?? '') }}</textarea>
        </div>

        <button type="submit" class="button">
            {{ isset($categoria) ? 'Guardar Alterações' : 'Registar Categoria' }}
        </button>

        <a href="{{ route('categorias.index') }}" class="button">
            Cancelar
        </a>

    </form>

</div>

@endsection
