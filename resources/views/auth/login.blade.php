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

        .login-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 22px 0;
    color: #999;
    font-size: 12px;
}

.login-divider::before,
.login-divider::after {
    content: "";
    flex: 1;
    height: 1px;
    background: #e2e7e3;
}

.google-button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    width: 100%;
    padding: 13px;
    border: 1px solid #d5dcd7;
    border-radius: 4px;
    background: #fff;
    color: #333;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
    transition: .2s;
}

.google-button:hover {
    background: #f7f9f7;
    border-color: #123b2a;
}

.google-button svg {
    width: 19px;
    height: 19px;
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

        <div class="login-divider">
    <span>OU</span>
</div>

    <a href="{{ route('google.redirect') }}" class="google-button">
    <svg viewBox="0 0 48 48" aria-hidden="true">
        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.91c-.58 2.96-2.26 5.48-4.73 7.18l7.27 5.64c4.25-3.92 6.7-9.69 6.7-17.29z"/>
        <path fill="#FBBC05" d="M10.53 28.59A14.4 14.4 0 0 1 9.75 24c0-1.59.27-3.13.76-4.59l-7.98-6.19A23.9 23.9 0 0 0 0 24c0 3.88.93 7.55 2.56 10.78l7.97-6.19z"/>
        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.9-5.8l-7.27-5.64c-2.02 1.35-4.6 2.15-8.63 2.15-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
    </svg>

    <span>Entrar com o Google</span>
</a>

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
