@extends('layouts.app')

@section('title', $titulo)
@section('page-title', $titulo)
@section('breadcrumb', $titulo)

@section('content')

<div class="page-heading">
    <div>
        <h2>{{ $titulo }}</h2>
        <p>
            Área de gestão do Sistema de Denúncias de Vandalização
            de Bens Públicos.
        </p>
    </div>
</div>

<div class="card">
    <h3>Módulo em desenvolvimento</h3>

    <p style="color: #667085; line-height: 1.8;">
        Esta área será implementada na próxima etapa do projeto.
        A sua funcionalidade será ligada à base de dados e às
        permissões correspondentes.
    </p>

    <a href="{{ route('dashboard') }}" class="button">
        Voltar ao Dashboard
    </a>
</div>

@endsection
