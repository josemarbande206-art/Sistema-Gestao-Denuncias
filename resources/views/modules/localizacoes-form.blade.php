@extends('layouts.app')

@section('title', isset($localizacao) ? 'Editar Localização' : 'Nova Localização')
@section('page-title', 'Gestão de Localizações')

@section('content')

<div class="page-heading">
    <div>
        <h1>{{ isset($localizacao) ? 'Editar Localização' : 'Nova Localização' }}</h1>

        <p>
            {{ isset($localizacao)
                ? 'Atualize os dados da localização.'
                : 'Preencha os dados do local que pretende registar.' }}
        </p>
    </div>

    <a href="{{ route('localizacoes.index') }}" class="button">
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
        action="{{ isset($localizacao)
            ? route('localizacoes.update', $localizacao->id)
            : route('localizacoes.store') }}"
        method="POST"
    >

        @csrf

        @if(isset($localizacao))
            @method('PUT')
        @endif

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:20px;">

            <div>
                <label for="provincia">Província *</label>

                <input
                    type="text"
                    id="provincia"
                    name="provincia"
                    value="{{ old('provincia', $localizacao->provincia ?? '') }}"
                    maxlength="100"
                    required
                    placeholder="Ex.: Luanda"
                    style="width:100%; padding:12px; margin-top:8px; border:1px solid #d1d5db; border-radius:6px;"
                >
            </div>

            <div>
                <label for="municipio">Município *</label>

                <input
                    type="text"
                    id="municipio"
                    name="municipio"
                    value="{{ old('municipio', $localizacao->municipio ?? '') }}"
                    maxlength="100"
                    required
                    placeholder="Ex.: Viana"
                    style="width:100%; padding:12px; margin-top:8px; border:1px solid #d1d5db; border-radius:6px;"
                >
            </div>

            <div>
                <label for="bairro">Bairro</label>

                <input
                    type="text"
                    id="bairro"
                    name="bairro"
                    value="{{ old('bairro', $localizacao->bairro ?? '') }}"
                    maxlength="150"
                    placeholder="Nome do bairro"
                    style="width:100%; padding:12px; margin-top:8px; border:1px solid #d1d5db; border-radius:6px;"
                >
            </div>

            <div>
                <label for="endereco">Endereço</label>

                <input
                    type="text"
                    id="endereco"
                    name="endereco"
                    value="{{ old('endereco', $localizacao->endereco ?? '') }}"
                    maxlength="255"
                    placeholder="Rua, avenida ou outro endereço"
                    style="width:100%; padding:12px; margin-top:8px; border:1px solid #d1d5db; border-radius:6px;"
                >
            </div>

            <div>
                <label for="latitude">Latitude</label>

                <input
                    type="number"
                    id="latitude"
                    name="latitude"
                    value="{{ old('latitude', $localizacao->latitude ?? '') }}"
                    step="any"
                    min="-90"
                    max="90"
                    placeholder="Ex.: -8.8390"
                    style="width:100%; padding:12px; margin-top:8px; border:1px solid #d1d5db; border-radius:6px;"
                >
            </div>

            <div>
                <label for="longitude">Longitude</label>

                <input
                    type="number"
                    id="longitude"
                    name="longitude"
                    value="{{ old('longitude', $localizacao->longitude ?? '') }}"
                    step="any"
                    min="-180"
                    max="180"
                    placeholder="Ex.: 13.2894"
                    style="width:100%; padding:12px; margin-top:8px; border:1px solid #d1d5db; border-radius:6px;"
                >
            </div>

        </div>

        <div style="margin-top:20px;">
            <label for="referencia">Ponto de referência</label>

            <textarea
                id="referencia"
                name="referencia"
                rows="4"
                placeholder="Ex.: Próximo de uma escola ou de um mercado."
                style="width:100%; padding:12px; margin-top:8px; border:1px solid #d1d5db; border-radius:6px;"
            >{{ old('referencia', $localizacao->referencia ?? '') }}</textarea>
        </div>

        <div style="margin-top:25px; display:flex; gap:10px; flex-wrap:wrap;">

            <button type="submit" class="button">
                {{ isset($localizacao) ? 'Guardar Alterações' : 'Registar Localização' }}
            </button>

            <a href="{{ route('localizacoes.index') }}" class="button">
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection

