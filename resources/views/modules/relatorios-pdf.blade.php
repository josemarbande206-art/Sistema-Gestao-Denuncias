<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Denúncias</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .cabecalho {
            text-align: center;
            border-bottom: 3px solid #176b57;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        h1 {
            color: #176b57;
            font-size: 20px;
            margin-bottom: 5px;
        }

        h2 {
            color: #176b57;
            font-size: 14px;
            margin-top: 22px;
        }

        .informacao {
            margin-bottom: 15px;
            line-height: 1.7;
        }

        .total {
            background: #176b57;
            color: white;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #176b57;
            color: white;
        }

        .rodape {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="cabecalho">
        <h1>SISTEMA DE DENÚNCIAS DE VANDALIZAÇÃO</h1>
        <p>Relatório Estatístico de Denúncias</p>
        <p>Estudo de Caso: Cidade de Luanda</p>
    </div>

    <div class="informacao">
        <strong>Data de geração:</strong>
        {{ $dataGeracao->format('d/m/Y H:i') }}
        <br>

        <strong>Período:</strong>
        {{ $filtros['data_inicio'] ?? 'Não definido' }}
        até
        {{ $filtros['data_fim'] ?? 'Não definido' }}
        <br>

        <strong>Município:</strong>
        {{ $filtros['municipio'] ?? 'Todos os municípios' }}
    </div>

    <div class="total">
        Total de denúncias: {{ $total }}
    </div>

    <h2>1. Estatísticas por estado</h2>

    <table>
        <thead>
            <tr>
                <th>Estado</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
            @php
                $nomesEstados = [
                    'pendente' => 'Pendente',
                    'em_analise' => 'Em análise',
                    'confirmada' => 'Confirmada',
                    'resolvida' => 'Resolvida',
                    'rejeitada' => 'Rejeitada',
                ];
            @endphp

            @foreach($estatisticas as $estado => $quantidade)
                <tr>
                    <td>{{ $nomesEstados[$estado] ?? $estado }}</td>
                    <td>{{ $quantidade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>2. Denúncias por categoria</h2>

    <table>
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
            @forelse($porCategoria as $categoria)
                <tr>
                    <td>{{ $categoria->nome }}</td>
                    <td>{{ $categoria->total }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">Não existem dados disponíveis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>3. Denúncias por município</h2>

    <table>
        <thead>
            <tr>
                <th>Município</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
            @forelse($porMunicipio as $municipio)
                <tr>
                    <td>{{ $municipio->municipio }}</td>
                    <td>{{ $municipio->total }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">Não existem dados disponíveis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="rodape">
        Documento gerado automaticamente pelo Sistema de Denúncias de
        Vandalização de Bens Públicos.
    </div>

</body>
</html>
