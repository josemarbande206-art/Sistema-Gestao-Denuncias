<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sessão | Gestão de Denúncias</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f2f5f3;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 430px;
            background: #fff;
            border-top: 5px solid #123b2a;
            padding: 38px;
            box-shadow: 0 8px 30px rgba(0,0,0,.08);
        }

        .institution {
            text-align: center;
            margin-bottom: 30px;
        }

        .institution h1 {
            color: #123b2a;
            font-size: 21px;
            margin-bottom: 9px;
        }

        .institution p {
            color: #777;
            font-size: 13px;
            line-height: 1.5;
        }

        h2 {
            color: #123b2a;
            font-size: 22px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #777;
            font-size: 14px;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #d5dcd7;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #123b2a;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #123b2a;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1b553d;
        }

        .error {
            color: #b42318;
            font-size: 13px;
            margin-top: -13px;
            margin-bottom: 15px;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 23px;
            color: #123b2a;
            text-decoration: none;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            color: #888;
            font-size: 12px;
            margin-top: 30px;
            line-height: 1.5;
        }
    </style>
</head>

<body>

<div class="login-container">

    <div class="institution">
        <h1>GESTÃO DE DENÚNCIAS</h1>
        <p>
            Sistema de Gestão de Denúncias de
            Vandalização de Bens Públicos
        </p>
    </div>

    <h2>Iniciar Sessão</h2>
    <p class="subtitle">
        Introduza os seus dados de acesso ao sistema.
    </p>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <label for="email">Endereço de e-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="Introduza o seu e-mail"
            required
            autofocus
        >

        <label for="password">Palavra-passe</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Introduza a sua palavra-passe"
            required
        >

        <button type="submit">Entrar no Sistema</button>
    </form>

    <a href="{{ url('/') }}" class="back">
        Voltar à página inicial
    </a>

    <div class="footer">
        Sistema de Gestão de Denúncias<br>
        Plataforma de protecção dos bens públicos
    </div>

</div>

</body>
</html>
