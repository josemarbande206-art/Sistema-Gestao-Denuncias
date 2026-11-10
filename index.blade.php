<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lista de Denúncias</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            color: #17365d;
            margin-top: 0;
        }

        .botao {
            display: inline-block;
            padding: 10px 16px;
            background: #17365d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .tabela {
            width: 100%;
            border-collapse: collapse;
        }

        .tabela th,
        .tabela td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabela th {
            background: #17365d;
            color: white;
        }

        .tabela tr:hover {
            background: #f5f7fa;
        }

        .estado {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 5px;
            background: #fff3cd;
            color: #856404;
        }

        .vazio {
            text-align: center;
            padding: 25px;
        }

        @media (max-width: 700px) {
            body {
                padding: 10px;
            }

            .container {
                overflow-x: auto;
                padding: 15px;
            }

            .tabela {
                min-width: 650px;
            }
        }
    </style>
</head>

<body>
    <main class="container">

        <h1>Denúncias Registadas</h1>

        <p>
            Consulta as ocorrências registadas no sistema.
        </p>

        <a href="{{ route('denuncias.create') }}" class="botao">
            Registar Nova Denúncia
        </a>

        <table class="tabela">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Data da Ocorrência</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($denuncias as $denuncia)
                    <tr>
                        <td>{{ $denuncia->codigo }}</td>

                        <td>{{ $denuncia->titulo }}</td>

                        <td>
                            {{ $denuncia->categoria ?? 'Sem categoria' }}
                        </td>

                        <td>
                            {{ $denuncia->data_ocorrencia ?? 'Não indicada' }}
                        </td>

                        <td>
                            <span class="estado">
                                {{ ucfirst(str_replace('_', ' ', $denuncia->estado)) }}
                            </span>
                        </td>
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

    </main>
</body>
</html>