<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registar Denúncia | Sistema de Denúncias</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f2;
            color: #26332c;
        }

        header {
            background: #176b4d;
            color: white;
            padding: 22px 7%;
        }

        header h1 {
            margin: 0 0 8px;
            font-size: 25px;
        }

        header p {
            margin: 0;
            font-size: 14px;
        }

        nav {
            background: #10543c;
            padding: 13px 7%;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 22px;
            font-size: 14px;
        }

        .container {
            max-width: 850px;
            margin: 35px auto;
            padding: 0 18px;
        }

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
        }

        .form-card h2 {
            color: #176b4d;
            margin-top: 0;
        }

        .description {
            color: #657168;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccd5cf;
            border-radius: 6px;
            font-size: 15px;
            background: white;
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid #b4dfca;
            border-color: #176b4d;
        }

        .help-text {
            display: block;
            color: #68756d;
            font-size: 12px;
            margin-top: 6px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .checkbox-group input {
            width: auto;
        }

        .checkbox-group label {
            margin: 0;
            font-weight: normal;
        }

        .btn {
            background: #176b4d;
            color: white;
            border: none;
            padding: 13px 22px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        .btn:hover {
            background: #10543c;
        }

        footer {
            text-align: center;
            padding: 25px;
            color: #68756d;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            .form-card {
                padding: 20px;
            }

            header {
                padding: 20px;
            }

            nav {
                padding: 14px 20px;
            }

            nav a {
                display: inline-block;
                margin: 5px 12px 5px 0;
            }
        }

        .alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 6px;
}

.alert-success {
    background: #d8f3dc;
    color: #1b4332;
}

.alert-error {
    background: #ffe0e0;
    color: #8b0000;
}

    </style>
</head>

<body>

    <header>
        <h1>Sistema de Gestão de Denúncias</h1>
        <p>Proteção e preservação dos bens públicos</p>
    </header>

    <nav>
        <a href="/">Início</a>
        <a href="/denuncias/criar">Registar denúncia</a>
    </nav>

    <main class="container">
            @if (session('sucesso'))
    <div class="alert alert-success">
        {{ session('sucesso') }}
    </div>
@endif

@if (session('erro'))
    <div class="alert alert-error">
        {{ session('erro') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error">
        <strong>Corrija os seguintes problemas:</strong>

        <ul>
            @foreach ($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif
        @if (session('sucesso'))
    <div class="alert alert-success">
        {{ session('sucesso') }}
    </div>
@endif

@if (session('erro'))
    <div class="alert alert-error">
        {{ session('erro') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error">
        <strong>Corrija os seguintes problemas:</strong>

        <ul>
            @foreach ($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <section class="form-card">

            <h2>Registar uma denúncia</h2>

            <p class="description">
                Preencha os campos abaixo para comunicar uma ocorrência
                de vandalização de um bem público. Forneça informações
                claras e verdadeiras para facilitar a análise da denúncia.
            </p>
                <form
    action="{{ route('denuncias.store') }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

               <div class="form-group">
    <label for="titulo">Título da ocorrência *</label>

    <input
        type="text"
        id="titulo"
        name="titulo"
        maxlength="150"
        value="{{ old('titulo') }}"
        placeholder="Ex.: Vandalização de um banco de jardim"
        required
    >
</div>

<div class="form-group">
    <label for="categoria_id">Categoria da ocorrência *</label>

    <select id="categoria_id" name="categoria_id" required>
        <option value="">Selecione uma categoria</option>

        @foreach ($categorias as $categoria)
            <option
                value="{{ $categoria->id }}"
                @selected(old('categoria_id') == $categoria->id)
            >
                {{ $categoria->nome }}
            </option>
        @endforeach
    </select>
</div>
            <div class="form-group">
    <label for="bem_publico_id">Bem público afetado</label>

    <select id="bem_publico_id" name="bem_publico_id">
        <option value="">Não especificado</option>

        @foreach ($bensPublicos as $bem)
            <option
                value="{{ $bem->id }}"
                @selected(old('bem_publico_id') == $bem->id)
            >
                {{ $bem->nome }}
            </option>
        @endforeach
    </select>
</div>
        <div class="form-group">
    <label for="localizacao_id">Localização da ocorrência *</label>

    <select id="localizacao_id" name="localizacao_id" required>
        <option value="">Selecione uma localização</option>

        @foreach ($localizacoes as $localizacao)
            <option
                value="{{ $localizacao->id }}"
                @selected(old('localizacao_id') == $localizacao->id)
            >
                {{ $localizacao->provincia }} —
                {{ $localizacao->municipio }}
                @if ($localizacao->bairro)
                    — {{ $localizacao->bairro }}
                @endif
            </option>
        @endforeach
    </select>
</div>
        <div class="form-group">
    <label for="data_ocorrencia">Data da ocorrência *</label>

    <input
        type="date"
        id="data_ocorrencia"
        name="data_ocorrencia"
        value="{{ old('data_ocorrencia') }}"
        required
    >
</div>

        <div class="form-group">
    <label for="descricao">Descrição da ocorrência *</label>

    <textarea
        id="descricao"
        name="descricao"
        required
        placeholder="Descreva os danos observados..."
    >{{ old('descricao') }}</textarea>
</div>

        <div class="form-group">
    <label for="evidencias">Fotografias como evidência</label>

    <input
        type="file"
        id="evidencias"
        name="evidencias[]"
        accept="image/jpeg,image/png,image/webp"
        multiple
    >

    <small class="help-text">
        Pode enviar até cinco fotografias, com um máximo de 5 MB por fotografia.
    </small>
</div>
    

                <div class="checkbox-group">
                    <input
                        type="checkbox"
                        id="anonima"
                        name="anonima"
                        value="1"
                    >
                    <label for="anonima">
                        Pretendo apresentar a denúncia anonimamente.
                    </label>
                </div>

                <button type="submit" class="btn">
                    Submeter denúncia
                </button>

            </form>
        </section>
    </main>

    <footer>
        Sistema de Gestão de Denúncias de Vandalização de Bens Públicos
    </footer>

</body>
</html>