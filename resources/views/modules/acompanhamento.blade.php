@extends('layouts.app')

@section('title', 'Acompanhamento de Denúncias')

@section('content')

<div class="acompanhamento-container">

    <div class="pagina-cabecalho">
        <div>
            <span class="etiqueta">ÁREA DO CIDADÃO</span>
            <h1>Acompanhamento de denúncias</h1>
            <p>
                Consulte o estado de uma denúncia através do código
                disponibilizado no momento do registo.
            </p>
        </div>
    </div>

    <div class="pesquisa-card">
        <h2>Consultar denúncia</h2>

        <form action="{{ route('acompanhamento.index') }}" method="GET">

            <label for="codigo">Código da denúncia</label>

            <div class="pesquisa-campo">
                <input
                    type="text"
                    id="codigo"
                    name="codigo"
                    value="{{ $codigo }}"
                    placeholder="Ex.: DEN-RIM2CCY80C"
                    maxlength="50"
                    required
                >

                <button type="submit">
                    Pesquisar
                </button>
            </div>

            <small>
                Introduza o código exato da denúncia.
            </small>

        </form>
    </div>

    @if ($pesquisou && $codigo === '')
        <div class="mensagem mensagem-aviso">
            Introduza o código da denúncia para continuar.
        </div>
    @elseif ($pesquisou && !$denuncia)
        <div class="mensagem mensagem-erro">
            <strong>Denúncia não encontrada.</strong>
            <p>
                Confirme o código introduzido e tente novamente.
            </p>
        </div>
    @endif

    @if ($denuncia)

        @php
            $estados = [
                'pendente' => 'Pendente',
                'em_analise' => 'Em análise',
                'confirmada' => 'Confirmada',
                'resolvida' => 'Resolvida',
                'rejeitada' => 'Rejeitada',
            ];

            $estadoTexto = $estados[$denuncia->estado]
                ?? ucfirst(str_replace('_', ' ', $denuncia->estado));
        @endphp

        <div class="resultado-card">

            <div class="resultado-cabecalho">
                <div>
                    <span class="texto-secundario">Código da ocorrência</span>
                    <h2>{{ $denuncia->codigo }}</h2>
                </div>

                <span class="estado estado-{{ $denuncia->estado }}">
                    {{ $estadoTexto }}
                </span>
            </div>

            <div class="detalhes-grid">

                <div class="detalhe">
                    <span>Título</span>
                    <strong>{{ $denuncia->titulo }}</strong>
                </div>

                <div class="detalhe">
                    <span>Categoria</span>
                    <strong>{{ $denuncia->categoria ?? 'Não definida' }}</strong>
                </div>

                <div class="detalhe">
                    <span>Data da ocorrência</span>
                    <strong>
                        {{ $denuncia->data_ocorrencia ?: 'Não informada' }}
                    </strong>
                </div>

                <div class="detalhe">
                    <span>Data de registo</span>
                    <strong>
                        {{ $denuncia->data_registo ?: 'Não informada' }}
                    </strong>
                </div>

            </div>

            <div class="descricao">
                <h3>Descrição da ocorrência</h3>
                <p>{{ $denuncia->descricao }}</p>
            </div>

            <div class="nota-estado">
                <strong>Estado atual:</strong>
                {{ $estadoTexto }}.

                @if ($denuncia->estado === 'pendente')
                    A denúncia aguarda análise.
                @elseif ($denuncia->estado === 'em_analise')
                    A denúncia está a ser analisada.
                @elseif ($denuncia->estado === 'confirmada')
                    A ocorrência foi confirmada.
                @elseif ($denuncia->estado === 'resolvida')
                    A ocorrência está marcada como resolvida.
                @elseif ($denuncia->estado === 'rejeitada')
                    A denúncia foi rejeitada.
                @endif
            </div>

        </div>

    @endif

</div>

@endsection

@push('styles')
<style>
.acompanhamento-container {
    max-width: 1050px;
    margin: 0 auto;
}

.pagina-cabecalho {
    margin-bottom: 28px;
}

.etiqueta {
    color: #16845b;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.5px;
}

.pagina-cabecalho h1 {
    margin: 8px 0;
    color: #172b4d;
    font-size: 28px;
}

.pagina-cabecalho p {
    color: #64748b;
    line-height: 1.7;
}

.pesquisa-card,
.resultado-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 26px;
    margin-bottom: 24px;
    box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
}

.pesquisa-card h2 {
    margin-top: 0;
    color: #172b4d;
    font-size: 19px;
}

.pesquisa-card label {
    display: block;
    margin-bottom: 9px;
    font-weight: 700;
    color: #334155;
}

.pesquisa-campo {
    display: flex;
    gap: 12px;
}

.pesquisa-campo input {
    flex: 1;
    min-width: 0;
    padding: 13px 15px;
    border: 1px solid #cbd5e1;
    border-radius: 9px;
    font-size: 15px;
}

.pesquisa-campo input:focus {
    outline: 2px solid #bbf7d0;
    border-color: #16845b;
}

.pesquisa-campo button {
    border: none;
    border-radius: 9px;
    background: #16845b;
    color: #fff;
    padding: 0 24px;
    font-weight: 700;
    cursor: pointer;
}

.pesquisa-campo button:hover {
    background: #116b49;
}

.pesquisa-card small {
    display: block;
    margin-top: 10px;
    color: #64748b;
}

.resultado-cabecalho {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    padding-bottom: 22px;
    border-bottom: 1px solid #e2e8f0;
}

.texto-secundario {
    font-size: 12px;
    color: #64748b;
}

.resultado-cabecalho h2 {
    margin: 7px 0 0;
    color: #172b4d;
}

.estado {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 800;
}

.estado-pendente {
    background: #fef3c7;
    color: #92400e;
}

.estado-em_analise {
    background: #dbeafe;
    color: #1d4ed8;
}

.estado-confirmada {
    background: #ede9fe;
    color: #6d28d9;
}

.estado-resolvida {
    background: #dcfce7;
    color: #166534;
}

.estado-rejeitada {
    background: #fee2e2;
    color: #991b1b;
}

.detalhes-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
    padding: 24px 0;
}

.detalhe span {
    display: block;
    margin-bottom: 8px;
    color: #64748b;
    font-size: 13px;
}

.detalhe strong {
    color: #334155;
    overflow-wrap: anywhere;
}

.descricao {
    border-top: 1px solid #e2e8f0;
    padding-top: 20px;
}

.descricao h3 {
    color: #172b4d;
    font-size: 16px;
}

.descricao p {
    color: #475569;
    line-height: 1.8;
    white-space: pre-line;
}

.nota-estado {
    margin-top: 22px;
    padding: 16px;
    border-radius: 10px;
    background: #f0fdf4;
    color: #166534;
    line-height: 1.7;
}

.mensagem {
    padding: 18px;
    border-radius: 10px;
    margin-bottom: 24px;
}

.mensagem p {
    margin-bottom: 0;
}

.mensagem-erro {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

.mensagem-aviso {
    background: #fffbeb;
    color: #92400e;
}

@media (max-width: 600px) {
    .pesquisa-card,
    .resultado-card {
        padding: 18px;
    }

    .pesquisa-campo {
        flex-direction: column;
    }

    .pesquisa-campo button {
        padding: 13px;
    }

    .detalhes-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .pagina-cabecalho h1 {
        font-size: 23px;
    }
}
</style>
@endpush
