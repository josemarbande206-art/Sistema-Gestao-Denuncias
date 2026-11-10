<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Início | Sistema de Gestão de Denúncias</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        :root {
            --verde: #123b2a;
            --verde-escuro: #09251a;
            --dourado: #d6a72c;
            --branco: #ffffff;
            --fundo: #f5f7f6;
            --texto: #26332c;
            --cinzento: #66736b;
        }

        body {
            background: var(--fundo);
            color: var(--texto);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
        }

    

     /* CABEÇALHO E MENU */

header {
    background: var(--verde-escuro);
    padding: 0 7%;
    min-height: 78px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 3px 12px rgba(0, 0, 0, .15);
}

.logo {
    color: var(--branco);
    font-size: 17px;
    font-weight: bold;
    letter-spacing: .5px;
    white-space: nowrap;
}

nav {
    display: flex;
    align-items: center;
    gap: 25px;
}

nav a {
    color: var(--branco);
    font-size: 14px;
    font-weight: 600;
    transition: .3s;
}

nav a:hover {
    color: var(--dourado);
}

.login-button {
    background: var(--dourado);
    color: var(--verde-escuro);
    padding: 10px 18px;
    border-radius: 5px;
    font-weight: bold;
}

.login-button:hover {
    background: #e7bd50;
    color: var(--verde-escuro);
}

.logout-button {
    background: transparent;
    border: 1px solid var(--dourado);
    color: var(--dourado);
    padding: 9px 15px;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
}

.logout-button:hover {
    background: var(--dourado);
    color: var(--verde-escuro);
}


    /* APRESENTAÇÃO PRINCIPAL - HERO */

.hero {
    background: var(--verde);
    color: var(--branco);
    padding: 105px 7%;
    min-height: 440px;
    display: flex;
    align-items: center;
}

.hero-content {
    max-width: 850px;
}

.hero-label {
    color: var(--dourado);
    font-size: 13px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 20px;
}

.hero h1 {
    font-size: 43px;
    line-height: 1.25;
    margin-bottom: 24px;
    max-width: 800px;
}

.hero p {
    color: #e1e9e4;
    font-size: 17px;
    max-width: 700px;
    margin-bottom: 32px;
}

.hero-buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.button {
    display: inline-block;
    padding: 13px 23px;
    border-radius: 4px;
    font-weight: bold;
    font-size: 14px;
    transition: .3s;
}

.button-primary {
    background: var(--dourado);
    color: var(--verde-escuro);
}

.button-primary:hover {
    background: #e7bd50;
}

.button-outline {
    border: 1px solid var(--branco);
    color: var(--branco);
}

.button-outline:hover {
    background: var(--branco);
    color: var(--verde);
}
        /* SECÇÕES */

        section {
            padding: 75px 7%;
        }

        .section-heading {
            max-width: 750px;
            margin: 0 auto 45px;
            text-align: center;
        }

        .section-heading h2 {
            color: var(--verde);
            font-size: 29px;
            margin-bottom: 12px;
        }

        .section-heading p {
            color: var(--cinzento);
        }

        /* APRESENTAÇÃO */

        .presentation {
            background: var(--branco);
        }

        .presentation-content {
            max-width: 1000px;
            margin: auto;
            text-align: center;
        }

        .presentation-content h2 {
            color: var(--verde);
            font-size: 29px;
            margin-bottom: 20px;
        }

        .presentation-content p {
            color: var(--cinzento);
            font-size: 16px;
            margin-bottom: 15px;
        }

        /* FUNCIONAMENTO */

        .steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .step-card {
            background: var(--branco);
            padding: 28px 22px;
            border-radius: 5px;
            border-top: 3px solid var(--dourado);
            box-shadow: 0 3px 14px rgba(0, 0, 0, .05);
        }

        .step-number {
            color: var(--dourado);
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .step-card h3 {
            color: var(--verde);
            font-size: 17px;
            margin-bottom: 12px;
        }

        .step-card p {
            color: var(--cinzento);
            font-size: 14px;
        }

        /* BENS PÚBLICOS */

        .goods {
            background: #eaf0ec;
        }

        .goods-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .good-card {
            background: var(--branco);
            padding: 23px;
            border-left: 4px solid var(--verde);
            border-radius: 3px;
            color: var(--texto);
            font-weight: bold;
        }

        /* CHAMADA FINAL */

        .call-to-action {
            background: var(--verde);
            color: var(--branco);
            text-align: center;
        }

        .call-to-action h2 {
            font-size: 29px;
            margin-bottom: 15px;
        }

        .call-to-action p {
            color: #e1e9e4;
            margin-bottom: 27px;
        }

        /* RODAPÉ */

        footer {
            background: var(--verde-escuro);
            color: var(--branco);
            padding: 30px 7%;
            text-align: center;
        }

        footer p {
            font-size: 13px;
            color: #d5ded8;
            margin-bottom: 5px;
        }

        /* RESPONSIVIDADE */

        @media (max-width: 900px) {
            .steps {
                grid-template-columns: repeat(2, 1fr);
            }

            .goods-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            header {
                flex-direction: column;
            }
        }

        @media (max-width: 600px) {
            nav {
                justify-content: center;
                gap: 15px;
            }

            .hero {
                padding: 75px 7%;
            }

            .hero h1 {
                font-size: 31px;
            }

            .hero p {
                font-size: 15px;
            }

            .steps,
            .goods-grid {
                grid-template-columns: 1fr;
            }

            section {
                padding: 55px 7%;
            }
        }
    </style>
</head>

<body>

    <!-- CABEÇALHO -->

    <header>
        <div class="logo">
            GESTÃO DE DENÚNCIAS
        </div>

        <nav>
            <a href="/">Início</a>

            <a href="{{ route('denuncias.create') }}">
                Registar Denúncia
            </a>

            <a href="{{ url('/acompanhamento') }}">
                Acompanhar Denúncia
            </a>

            @auth
    <a href="{{ url('/dashboard') }}">Aceder ao Painel</a>

    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit">Terminar Sessão</button>
    </form>
@else
    <a href="{{ route('login') }}">Iniciar Sessão</a>
@endauth
        </nav>
    </header>

    <!-- APRESENTAÇÃO PRINCIPAL -->

    <main>

        <div class="hero">
            <div class="hero-content">

                <div class="hero-label">
                    Preservação do Património Público
                </div>

                <h1>
                    Sistema de Gestão de Denúncias de
                    Vandalização de Bens Públicos
                </h1>

                <p>
                    Uma plataforma destinada ao registo, acompanhamento
                    e gestão de denúncias relacionadas com actos de
                    vandalização de bens públicos, promovendo a
                    participação dos cidadãos e a preservação
                    do património público.
                </p>

                <div class="hero-buttons">

                    <a href="{{ route('denuncias.create') }}"
                       class="button button-primary">
                        Registar Denúncia
                    </a>

                    <a href="{{ url('/acompanhamento') }}"
                       class="button button-outline">
                        Acompanhar Denúncia
                    </a>

                </div>

            </div>
        </div>

        <!-- APRESENTAÇÃO DO SISTEMA -->

        <section class="presentation">

            <div class="presentation-content">

                <h2>Sobre o Sistema</h2>

                <p>
                    O Sistema de Gestão de Denúncias de Vandalização
                    de Bens Públicos tem como finalidade facilitar
                    a comunicação de ocorrências que afectem o
                    património público.
                </p>

                <p>
                    A plataforma permite registar denúncias,
                    apresentar evidências, identificar os locais
                    das ocorrências e acompanhar o processo de
                    análise e tratamento das participações.
                </p>

                <p>
                    Pretende-se, desta forma, contribuir para uma
                    gestão mais organizada da informação e reforçar
                    a participação dos cidadãos na protecção
                    dos bens públicos.
                </p>

            </div>

        </section>

        <!-- FUNCIONAMENTO -->

        <section>

            <div class="section-heading">
                <h2>Como Funciona o Sistema?</h2>

                <p>
                    O processo de participação e acompanhamento
                    de uma ocorrência é realizado através das
                    seguintes etapas.
                </p>
            </div>

            <div class="steps">

                <div class="step-card">
                    <div class="step-number">01</div>
                    <h3>Identificação da Ocorrência</h3>
                    <p>
                        O cidadão identifica um bem público
                        que tenha sido vandalizado ou danificado.
                    </p>
                </div>

                <div class="step-card">
                    <div class="step-number">02</div>
                    <h3>Registo da Denúncia</h3>
                    <p>
                        São introduzidas as informações sobre
                        a ocorrência e a respectiva localização.
                    </p>
                </div>

                <div class="step-card">
                    <div class="step-number">03</div>
                    <h3>Apresentação de Evidências</h3>
                    <p>
                        Podem ser anexadas fotografias e
                        documentos relacionados com a ocorrência.
                    </p>
                </div>

                <div class="step-card">
                    <div class="step-number">04</div>
                    <h3>Análise e Acompanhamento</h3>
                    <p>
                        A denúncia é encaminhada para análise
                        e o cidadão pode acompanhar o seu estado.
                    </p>
                </div>

            </div>

        </section>

        <!-- BENS PÚBLICOS -->

        <section class="goods">

            <div class="section-heading">
                <h2>Âmbito de Actuação</h2>

                <p>
                    O sistema contempla denúncias relacionadas
                    com diferentes categorias de bens públicos.
                </p>
            </div>

            <div class="goods-grid">

                <div class="good-card">
                    Infra-estruturas escolares
                </div>

                <div class="good-card">
                    Hospitais e unidades sanitárias
                </div>

                <div class="good-card">
                    Estradas e pontes
                </div>

                <div class="good-card">
                    Edifícios públicos
                </div>

                <div class="good-card">
                    Jardins e espaços públicos
                </div>

                <div class="good-card">
                    Equipamentos e mobiliário urbano
                </div>

            </div>

        </section>

        <!-- CHAMADA FINAL -->

        <section class="call-to-action">

            <h2>Contribua para a Preservação dos Bens Públicos</h2>

            <p>
                A participação dos cidadãos é importante
                para a identificação e comunicação de actos
                de vandalização do património público.
            </p>

            <a href="{{ route('denuncias.create') }}"
               class="button button-primary">
                Registar uma Denúncia
            </a>

        </section>

    </main>

    <!-- RODAPÉ -->

    <footer>

        <p>
            Sistema de Gestão de Denúncias de Vandalização de Bens Públicos
        </p>

        <p>
            © {{ date('Y') }} — Todos os direitos reservados.
        </p>

    </footer>

</body>
</html>
