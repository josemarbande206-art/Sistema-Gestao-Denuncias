<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lista de Denúncias</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #1f2937;
        }

        .botao {
            display: inline-block;
            padding: 10px 15px;
            background: #198754;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #1f2937;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .vazio {
            padding: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Gestão de Denúncias</h1>

        <p>
            Consulte as denúncias de vandalização de bens públicos
            registadas no sistema.
        </p>

        <a href="{{ route('denuncias.create') }}" class="botao">
            Registar nova denúncia
        </a>

        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Data da ocorrência</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @forelse($denuncias as $denuncia)
                    <tr>
                        <td>{{ $denuncia->codigo }}</td>
                        <td>{{ $denuncia->titulo }}</td>
                        <td>{{ $denuncia->categoria ?? 'Não definida' }}</td>
                        <td>{{ $denuncia->data_ocorrencia }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $denuncia->estado)) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="vazio">
                            Ainda não existem denúncias registadas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
