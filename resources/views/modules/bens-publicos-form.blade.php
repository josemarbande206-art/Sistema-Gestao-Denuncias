@extends('layouts.app')

@section('title', isset($bem) ? 'Editar Bem Público' : 'Cadastrar Bem Público')

@section('page-title', isset($bem) ? 'Editar Bem Público' : 'Cadastrar Bem Público')

@section('breadcrumb', 'Recursos públicos / Bens públicos / Formulário')

@section('content')

<style>
    .form-card {
        max-width: 850px;
        margin: auto;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 700;
        color: #344054;
    }

    .form-control {
        width: 100%;
        padding: 12px;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 25px;
    }

    .btn-cancel {
        padding: 11px 15px;
        border-radius: 7px;
        background: #eaecf0;
        color: #344054;
        font-size: 13px;
        font-weight: 700;
    }

    @media(max-width: 600px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-heading">
    <div>
        <h2>
            {{ isset($bem) ? 'Atualizar dados do bem' : 'Novo bem público' }}
        </h2>

        <p>
            Preenche os campos abaixo com as informações do bem público.
        </p>
    </div>
</div>

<div class="card form-card">

    <form
        method="POST"
        action="{{ isset($bem)
            ? route('bens-publicos.update', $bem->id)
            : route('bens-publicos.store') }}"
    >

        @csrf

        @if(isset($bem))
            @method('PUT')
        @endif

        <div class="form-grid">

            <div class="form-group full">

                <label for="nome">Nome do bem público *</label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    class="form-control"
                    placeholder="Ex.: Escola, hospital, estrada, ponte..."
                    value="{{ old('nome', $bem->nome ?? '') }}"
                    required
                >

            </div>

            <div class="form-group">

                <label for="tipo">Tipo de bem</label>

                <input
                    type="text"
                    id="tipo"
                    name="tipo"
                    class="form-control"
                    placeholder="Ex.: Infraestrutura, edifício..."
                    value="{{ old('tipo', $bem->tipo ?? '') }}"
                >

            </div>

            <div class="form-group">

                <label for="estado_conservacao">Estado de conservação *</label>

                <select
                    id="estado_conservacao"
                    name="estado_conservacao"
                    class="form-control"
                    required
                >

                    <option value="">Seleciona o estado</option>

                    <option value="bom"
                        {{ old('estado_conservacao', $bem->estado_conservacao ?? '') == 'bom' ? 'selected' : '' }}>
                        Bom
                    </option>

                    <option value="danificado"
                        {{ old('estado_conservacao', $bem->estado_conservacao ?? '') == 'danificado' ? 'selected' : '' }}>
                        Danificado
                    </option>

                    <option value="destruido"
                        {{ old('estado_conservacao', $bem->estado_conservacao ?? '') == 'destruido' ? 'selected' : '' }}>
                        Destruído
                    </option>

                </select>

            </div>

            <div class="form-group full">

                <label for="localizacao_id">Localização</label>

                <select
                    id="localizacao_id"
                    name="localizacao_id"
                    class="form-control"
                >

                    <option value="">Selecionar localização</option>

                    @foreach($localizacoes as $localizacao)

                        <option
                            value="{{ $localizacao->id }}"
                            {{ (string) old('localizacao_id', $bem->localizacao_id ?? '') === (string) $localizacao->id ? 'selected' : '' }}
                        >
                            {{ $localizacao->provincia }}
                            - {{ $localizacao->municipio }}
                            @if($localizacao->bairro)
                                - {{ $localizacao->bairro }}
                            @endif
                        </option>

                    @endforeach

                </select>

                @if($localizacoes->isEmpty())
                    <small style="color:#b54708;">
                        Ainda não existem localizações cadastradas.
                    </small>
                @endif

            </div>

            <div class="form-group full">

                <label for="descricao">Descrição</label>

                <textarea
                    id="descricao"
                    name="descricao"
                    class="form-control"
                    placeholder="Descreve o bem público e as suas características..."
                >{{ old('descricao', $bem->descricao ?? '') }}</textarea>

            </div>

        </div>

        <div class="form-actions">

            <a href="{{ route('bens-publicos.index') }}"
               class="btn-cancel">
                Cancelar
            </a>

            <button type="submit" class="button">
                {{ isset($bem) ? 'Guardar alterações' : 'Cadastrar bem público' }}
            </button>

        </div>

    </form>

</div>

@endsection
