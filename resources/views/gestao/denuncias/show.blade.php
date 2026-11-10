@extends('layouts.app')

@section('content')

<style>
    .det-page {
        max-width: 1100px;
        color: #172033;
    }

    .det-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .det-header h1 {
        margin: 0 0 8px;
        font-size: 27px;
        font-weight: 750;
    }

    .det-muted {
        color: #64748b;
        font-size: 14px;
    }

    .det-card {
        margin-bottom: 22px;
        padding: 24px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
    }

    .det-card h2 {
        margin: 0 0 20px;
        font-size: 17px;
        font-weight: 750;
    }

    .det-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .det-field small {
        display: block;
        margin-bottom: 7px;
        color: #64748b;
        font-size: 12px;
    }

    .det-field p {
        margin: 0;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .det-description {
        white-space: pre-line;
        line-height: 1.8;
    }

    .det-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 16px;
        border: 0;
        border-radius: 8px;
        background: #1e3a8a;
        color: #fff;
        font-size: 13px;
        font-weight: 650;
        text-decoration: none;
        cursor: pointer;
    }

    .det-btn:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .det-btn-secondary {
        background: #e2e8f0;
        color: #334155;
    }

    .det-btn-secondary:hover {
        background: #cbd5e1;
        color: #172033;
    }

    .det-form {
        display: flex;
        align-items: end;
        gap: 14px;
        flex-wrap: wrap;
    }

    .det-form label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 650;
    }

    .det-form select {
        min-width: 220px;
        min-height: 43px;
        padding: 9px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background: #fff;
    }

    .det-alert {
        margin-bottom: 20px;
        padding: 14px 16px;
        border-radius: 9px;
        background: #dcfce7;
        color: #166534;
    }

    .det-error {
        margin-bottom: 20px;
        padding: 14px 16px;
        border-radius: 9px;
        background: #fee2e2;
        color: #991b1b;
    }

    .det-evidencias {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .det-evidencia {
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow-wrap: anywhere;
    }

    .det-evidencia img {
        display: block;
        width: 100%;
        height: 180px;
        margin-bottom: 12px;
        border-radius: 7px;
        object-fit: cover;
        background: #f1f5f9;
    }

    .det-evidencia a {
        color: #1d4ed8;
        font-size: 13px;
        font-weight: 650;
    }

    @media (max-width: 650px) {
        .det-grid,
        .det-evidencias {
            grid-template-columns: 1fr;
        }

        .det-card {
            padding: 18px;
        }
    }
</style>

<div class="det-page">

    <div class="det-header">
        <div>
            <h1>Detalhes da denúncia</h1>

            <div class="det-muted">
                Código: <strong>{{ $denuncia->codigo }}</strong>
            </div>
        </div>

        <a
            href="{{ route('gestao.denuncias.index') }}"
            class="det-btn det-btn-secondary"
        >
            Voltar à listagem
        </a>
    </div>

    @if (session('sucesso'))
        <div class="det-alert">
            {{ session('sucesso') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="det-error">
            @foreach ($errors->all() as $erro)
                <div>{{ $erro }}</div>
            @endforeach
        </div>
    @endif

    <section class="det-card">
        <h2>Informações da ocorrência</h2>

        <div class="det-grid">

            <div class="det-field">
                <small>Título</small>
                <p><strong>{{ $denuncia->titulo }}</strong></p>
            </div>

            <div class="det-field">
                <small>Categoria</small>
                <p>{{ $denuncia->categoria ?? 'Não definida' }}</p>
            </div>

            <div class="det-field">
                <small>Data da ocorrência</small>
                <p>
                    {{ $denuncia->data_ocorrencia
                        ? \Illuminate\Support\Carbon::parse(
                            $denuncia->data_ocorrencia
                        )->format('d/m/Y H:i')
                        : 'Não indicada' }}
                </p>
            </div>

            <div class="det-field">
                <small>Data de registo</small>
                <p>
                    {{ $denuncia->data_registo
                        ? \Illuminate\Support\Carbon::parse(
                            $denuncia->data_registo
                        )->format('d/m/Y H:i')
                        : 'Não indicada' }}
                </p>
            </div>

            <div class="det-field">
                <small>Província</small>
                <p>{{ $denuncia->provincia ?? 'Não disponível' }}</p>
            </div>

            <div class="det-field">
                <small>Município</small>
                <p>{{ $denuncia->municipio ?? 'Não disponível' }}</p>
            </div>

        </div>

        <hr style="border:0;border-top:1px solid #e2e8f0;margin:24px 0;">

        <div class="det-field">
            <small>Descrição da ocorrência</small>

            <p class="det-description">{{ $denuncia->descricao }}</p>
        </div>
    </section>

    <section class="det-card">
        <h2>Atualização do estado</h2>

        <div class="det-muted" style="margin-bottom:18px;">
            Estado atual:
            <strong>{{ str_replace('_', ' ', ucfirst($denuncia->estado)) }}</strong>
        </div>

        <form
            method="POST"
            action="{{ route('gestao.denuncias.estado', $denuncia->id) }}"
            class="det-form"
        >
            @csrf
            @method('PATCH')

            <div>
                <label for="estado">Novo estado</label>

                <select name="estado" id="estado" required>
                    <option value="pendente"
                        @selected($denuncia->estado === 'pendente')>
                        Pendente
                    </option>
                    <div style="min-width:220px;flex:1;">
    <label for="observacao">Observação (opcional)</label>

    <textarea
        name="observacao"
        id="observacao"
        rows="2"
        maxlength="2000"
        placeholder="Explique o motivo da alteração..."
        style="width:100%;padding:11px;border:1px solid #cbd5e1;border-radius:8px;"
    >{{ old('observacao') }}</textarea>
</div>
        <div style="margin-top: 15px; margin-bottom: 15px;">
    <label for="observacao" style="display:block; margin-bottom:8px; font-weight:600;">
        Observação (opcional)
    </label>

    <textarea
        name="observacao"
        id="observacao"
        rows="3"
        maxlength="2000"
        placeholder="Explique o motivo da alteração do estado..."
        style="width:100%; box-sizing:border-box; padding:12px; border:1px solid #cbd5e1; border-radius:8px;"
    >{{ old('observacao') }}</textarea>
</div>
                    <option value="em_analise"
                        @selected($denuncia->estado === 'em_analise')>
                        Em análise
                    </option>

                    <option value="confirmada"
                        @selected($denuncia->estado === 'confirmada')>
                        Confirmada
                    </option>

                    <option value="resolvida"
                        @selected($denuncia->estado === 'resolvida')>
                        Resolvida
                    </option>

                    <option value="rejeitada"
                        @selected($denuncia->estado === 'rejeitada')>
                        Rejeitada
                    </option>
                </select>
            </div>

            <button type="submit" class="det-btn">
                Guardar alteração
            </button>
        </form>
    </section>

    <section class="det-card">
        <h2>Evidências fotográficas</h2>

        @if ($evidencias->isEmpty())
            <p class="det-muted">
                Esta denúncia não possui fotografias anexadas.
            </p>
        @else
            <div class="det-evidencias">
                @foreach ($evidencias as $evidencia)
                    <div class="det-evidencia">

                        @if (
                            $evidencia->tipo_arquivo &&
                            str_starts_with($evidencia->tipo_arquivo, 'image/')
                        )
                            <a
                                href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($evidencia->caminho_arquivo) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($evidencia->caminho_arquivo) }}"
                                    alt="Evidência da denúncia"
                                    loading="lazy"
                                >
                            </a>
                        @endif

                        <div style="font-size:13px;font-weight:650;margin-bottom:8px;">
                            {{ $evidencia->nome_arquivo }}
                        </div>

                        <a
                            href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($evidencia->caminho_arquivo) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            Abrir ficheiro
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

</div>

<section class="detail-card">
    <h2>Histórico de alterações</h2>

    <p style="color:#64748b;margin-bottom:20px;">
        Consulte as alterações de estado registadas para esta denúncia.
    </p>

    @if ($historico->isEmpty())
        <p style="color:#64748b;">
            Ainda não existem alterações de estado registadas.
        </p>
    @else
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;text-align:left;">
                <thead>
                    <tr style="background:#f1f5f9;">
                        <th style="padding:12px;">Data e hora</th>
                        <th style="padding:12px;">Estado anterior</th>
                        <th style="padding:12px;">Novo estado</th>
                        <th style="padding:12px;">Operador</th>
                        <th style="padding:12px;">Observação</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($historico as $registo)
                        <tr style="border-top:1px solid #e2e8f0;">
                            <td style="padding:12px;white-space:nowrap;">
                                {{ \Illuminate\Support\Carbon::parse($registo->created_at)->format('d/m/Y H:i:s') }}
                            </td>

                            <td style="padding:12px;">
                                {{ $registo->estado_anterior
                                    ? str_replace('_', ' ', $registo->estado_anterior)
                                    : 'Estado inicial' }}
                            </td>

                            <td style="padding:12px;">
                                <strong>
                                    {{ str_replace('_', ' ', $registo->estado_novo) }}
                                </strong>
                            </td>

                            <td style="padding:12px;">
                                {{ $registo->operador_nome ?? 'Não identificado' }}
                            </td>

                            <td style="padding:12px;">
                                {{ $registo->observacao ?? '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>

@endsection