<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Painel de Gestão')  Denúncias</title>

    <style>
       :root {
    --sidebar: #ffffff;
    --sidebar-hover: #f5f5f5;
    --primary: #176b57;
    --primary-light: #e6f4ef;
    --background: #f7f8fa;
    --surface: #ffffff;
    --text: #202124;
    --muted: #70757a;
    --border: #e8eaed;
    --sidebar-width: 235px;
  }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        a {
            text-decoration: none;
        }
	

	.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: var(--sidebar-width);
    height: 100vh;
    background: #ffffff;
    color: #202124;
    display: flex;
    flex-direction: column;
    z-index: 1000;
    transform: translateX(-100%);
    transition: transform .25s ease;
    overflow: hidden;
    border-right: 1px solid #e8eaed;
    box-shadow: 2px 0 12px rgba(0,0,0,.04);
}

.sidebar.open {
    transform: translateX(0);
}

     .brand {
    padding: 22px 18px;
    border-bottom: 1px solid #eeeeee;
    display: flex;
    align-items: center;
    gap: 12px;
}

.brand-icon {
    width: 38px;
    height: 38px;
    flex-shrink: 0;
    border-radius: 10px;
    background: #176b57;
    color: #ffffff;
    display: grid;
    place-items: center;
    font-size: 19px;
    font-weight: 800;
}

.brand h2 {
    color: #202124;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .4px;
    margin: 0 0 4px;
}

.brand p {
    color: #777777;
    margin: 0;
    font-size: 10px;
}



   .menu {
    padding: 12px 10px;
    flex: 1;
    min-height: 0;
    overflow-y: auto;
}

.menu-heading {
    color: #888888;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    padding: 18px 12px 8px;
}

.menu-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 13px;
    margin: 3px 0;
    border-radius: 7px;
    border-left: 3px solid transparent;
    color: #333333;
    font-size: 13px;
    font-weight: 500;
    transition: .2s ease;
}

.menu-link:hover {
    background: #f5f5f5;
    color: #176b57;
}

.menu-link.active {
    background: #eaf4f0;
    color: #176b57;
    border-left-color: #176b57;
    font-weight: 700;
}

.menu-icon {
    width: 20px;
    text-align: center;
    font-size: 16px;
    color: #666666;
}

.menu-link.active .menu-icon {
    color: #176b57;
}



   .sidebar-footer {
    border-top: 1px solid #eeeeee;
    padding: 14px 15px;
    color: #777777;
    font-size: 10px;
    line-height: 1.6;
    text-align: center;
    flex-shrink: 0;
}

        .main {
        margin-left: 0;
        min-height: 100vh;
        width: 100%;
        transition: margin-left .3s ease;
    }

        .topbar {
            height: 76px;
            padding: 0 30px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar h1 {
            margin: 0;
            font-size: 19px;
            font-weight: 750;
        }

        .topbar-subtitle {
            margin-top: 4px;
            font-size: 12px;
            color: var(--muted);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #176b57;
            background: #e6f4ef;
            border-radius: 20px;
            padding: 8px 12px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #19966b;
        }

        .avatar {
            width: 37px;
            height: 37px;
            border-radius: 50%;
            background: #e6eaf0;
            color: #344054;
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 13px;
        }

        .content {
            padding: 30px;
            max-width: 1600px;
            margin: 0 auto;
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 22px;
        }

        .breadcrumb span {
            margin: 0 8px;
        }

        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 24px;
        }

        .page-heading h2 {
            margin: 0 0 7px;
            font-size: 23px;
        }

        .page-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 2px 5px rgba(16,24,40,.025);
        }

        .button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            border: 0;
            border-radius: 7px;
            padding: 11px 15px;
            background: var(--primary);
            color: white;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .button:hover {
            background: var(--sidebar-hover);
            color: white;
        }
        .back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 15px;
    margin-bottom: 20px;
    border: 1px solid var(--border);
    border-radius: 7px;
    background: white;
    color: var(--text);
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: .2s;
}

.sidebar-actions {
    padding: 12px;
    border-top: 1px solid #eeeeee;
    flex-shrink: 0;
}

.sidebar-actions form {
    margin: 0;
}

.sidebar-action {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 11px 13px;
    margin-bottom: 5px;
    border-radius: 7px;
    font-family: inherit;
    font-size: 13px;
    font-weight: 600;
    text-align: left;
    cursor: pointer;
    transition: .2s ease;
}

.sidebar-action span {
    width: 20px;
    text-align: center;
    font-size: 17px;
}

.home-action {
    color: #333333;
    background: #f5f5f5;
    border: 1px solid #eeeeee;
}

.home-action:hover {
    background: #eaf4f0;
    color: #176b57;
}

.logout-action {
    color: #d93025;
    background: #ffffff;
    border: 1px solid #eeeeee;
}

.logout-action:hover {
    background: #fff1f0;
}


.back-button:hover {
    background: var(--primary-light);
    color: var(--primary);
    border-color: var(--primary);
}
        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-success {
            color: #166534;
            background: #dcfce7;
        }

        .alert-error {
            color: #991b1b;
            background: #fee2e2;
        }

        .mobile-toggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border: 1px solid var(--border);
    background: white;
    color: var(--primary);
    border-radius: 8px;
    cursor: pointer;
    font-size: 21px;
    transition: .2s;
}

.mobile-toggle:hover {
    background: var(--primary-light);
}
        .sidebar-overlay {
    display: none;
}

.sidebar-overlay.open {
    display: block;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .40);
    z-index: 900;
}
        @media (max-width: 900px) {
    .topbar {
        padding: 0 16px;
    }

    .content {
        padding: 20px 16px;
    }

    .topbar h1 {
        font-size: 16px;
    }
}

@media (max-width: 520px) {
    .status-indicator {
        display: none;
    }

    .page-heading {
        align-items: flex-start;
        flex-direction: column;
    }
}

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.open {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.35);
                z-index: 900;
            }

            .main {
                margin-left: 0;
            }

            .mobile-toggle {
                display: inline-block;
            }

            .topbar {
                padding: 0 16px;
            }

            .content {
                padding: 20px 16px;
            }

            .topbar h1 {
                font-size: 16px;
            }
        }

        @media (max-width: 520px) {
            .status-indicator {
                display: none;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<aside class="sidebar" id="sidebar">

    <div class="brand">
        <div class="brand-icon">D</div>
        <div>
            <h2>GESTÃO DE DENÚNCIAS</h2>
            <p>Proteção dos bens públicos</p>
        </div>
       
    </div>
     <button type="button" class="back-button" onclick="voltarPagina()">
    ← Voltar
</button>
    <nav class="menu">

        @auth

            @if(Auth::user()->perfil === 'administrador')

                <div class="menu-heading">PAINEL PRINCIPAL</div>

                <a href="{{ route('dashboard') }}"
                   class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="menu-icon">▦</span>
                    Dashboard
                </a>

                <div class="menu-heading">GESTÃO DE DENÚNCIAS</div>

                <a href="{{ route('denuncias.index') }}"
                   class="menu-link {{ request()->routeIs('denuncias.index') ? 'active' : '' }}">
                    <span class="menu-icon">▤</span>
                    Todas as denúncias
                </a>

                <a href="{{ route('gestao.denuncias.index') }}"
                   class="menu-link {{ request()->routeIs('gestao.denuncias.*') ? 'active' : '' }}">
                    <span class="menu-icon">✓</span>
                    Gestão de denúncias
                </a>

                <a href="{{ route('denuncias.create') }}"
                   class="menu-link {{ request()->routeIs('denuncias.create') ? 'active' : '' }}">
                    <span class="menu-icon">＋</span>
                    Registar denúncia
                </a>

                <a href="{{ route('acompanhamento.index') }}"
                   class="menu-link {{ request()->routeIs('acompanhamento.*') ? 'active' : '' }}">
                    <span class="menu-icon">◷</span>
                    Acompanhamento
                </a>

                <div class="menu-heading">RECURSOS PÚBLICOS</div>

                <a href="{{ route('bens-publicos.index') }}"
                   class="menu-link {{ request()->routeIs('bens-publicos.*') ? 'active' : '' }}">
                    <span class="menu-icon">▣</span>
                    Bens públicos
                </a>

                <a href="{{ route('categorias.index') }}"
                   class="menu-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                    <span class="menu-icon">☷</span>
                    Categorias
                </a>

                <a href="{{ route('localizacoes.index') }}"
                   class="menu-link {{ request()->routeIs('localizacoes.*') ? 'active' : '' }}">
                    <span class="menu-icon">⌖</span>
                    Localizações
                </a>

                <a href="{{ route('evidencias.index') }}"
                   class="menu-link {{ request()->routeIs('evidencias.*') ? 'active' : '' }}">
                    <span class="menu-icon">▧</span>
                    Evidências
                </a>

                <div class="menu-heading">GESTÃO E CONTROLO</div>

                <a href="{{ route('relatorios.index') }}"
                   class="menu-link {{ request()->routeIs('relatorios.*') ? 'active' : '' }}">
                    <span class="menu-icon">▥</span>
                    Relatórios
                </a>

                <a href="{{ route('utilizadores.index') }}"
                   class="menu-link {{ request()->routeIs('utilizadores.*') ? 'active' : '' }}">
                    <span class="menu-icon">♙</span>
                    Utilizadores
                </a>

                <a href="{{ route('operadores.index') }}"
                   class="menu-link {{ request()->routeIs('operadores.*') ? 'active' : '' }}">
                    <span class="menu-icon">♧</span>
                    Operadores
                </a>

                <a href="{{ route('auditoria.index') }}"
                   class="menu-link {{ request()->routeIs('auditoria.*') ? 'active' : '' }}">
                    <span class="menu-icon">◉</span>
                    Auditoria
                </a>

                <a href="{{ route('configuracoes.index') }}"
                   class="menu-link {{ request()->routeIs('configuracoes.*') ? 'active' : '' }}">
                    <span class="menu-icon">⚙</span>
                    Configurações
                </a>

            @elseif(Auth::user()->perfil === 'operador')

                <div class="menu-heading">GESTÃO DE DENÚNCIAS</div>

                <a href="{{ route('denuncias.index') }}"
                   class="menu-link {{ request()->routeIs('denuncias.index') ? 'active' : '' }}">
                    <span class="menu-icon">▤</span>
                    Todas as denúncias
                </a>

                <a href="{{ route('gestao.denuncias.index') }}"
                   class="menu-link {{ request()->routeIs('gestao.denuncias.*') ? 'active' : '' }}">
                    <span class="menu-icon">✓</span>
                    Gestão de denúncias
                </a>

                <a href="{{ route('denuncias.create') }}"
                   class="menu-link {{ request()->routeIs('denuncias.create') ? 'active' : '' }}">
                    <span class="menu-icon">＋</span>
                    Registar denúncia
                </a>

                <a href="{{ route('acompanhamento.index') }}"
                   class="menu-link {{ request()->routeIs('acompanhamento.*') ? 'active' : '' }}">
                    <span class="menu-icon">◷</span>
                    Acompanhamento
                </a>

            @else

                <div class="menu-heading">ÁREA DO CIDADÃO</div>
		<a href="{{ route('denuncias.index') }}"
   class="menu-link {{ request()->routeIs('denuncias.index') ? 'active' : '' }}">
    <span class="menu-icon">▤</span>
    Minhas Denúncias
</a>
                <a href="{{ route('denuncias.create') }}"
                   class="menu-link {{ request()->routeIs('denuncias.create') ? 'active' : '' }}">
                    <span class="menu-icon">＋</span>
                    Registar denúncia
                </a>

                <a href="{{ route('acompanhamento.index') }}"
                   class="menu-link {{ request()->routeIs('acompanhamento.*') ? 'active' : '' }}">
                    <span class="menu-icon">◷</span>
                    Acompanhamento
                </a>

            @endif

        @endauth

    </nav>

       </nav>

    <div class="sidebar-actions">

        <a href="{{ url('/') }}" class="sidebar-action home-action">
            <span>⌂</span>
            Página inicial
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="sidebar-action logout-action">
                <span>↪</span>
                Terminar sessão
            </button>
        </form>

    </div>

    <div class="sidebar-footer">
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="main">

    <header class="topbar">

        <div class="topbar-left">

            <button class="mobile-toggle" id="mobileToggle"
                    aria-label="Abrir menu">☰</button>

            <div>
                <h1>@yield('page-title', 'Painel de gestão')</h1>

                <div class="topbar-subtitle">
                    Sistema de Gestão de Denúncias de Vandalização
                </div>
            </div>

        </div>

        <div class="topbar-right">

            <div class="status-indicator">
                <span class="status-dot"></span>
                Sistema operacional
            </div>

            <div class="avatar" title="Área do utilizador">
                {{ strtoupper(substr(Auth::user()->nome ?? 'U', 0, 1)) }}
            </div>

        </div>

    </header>

    <main class="content">

        <div class="breadcrumb">
            Início <span>›</span> @yield('breadcrumb', 'Painel')
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <strong>Verifica os seguintes campos:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>

</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle = document.getElementById('mobileToggle');

    function abrirSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('open');
        toggle.setAttribute('aria-expanded', 'true');
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
    }

    toggle.addEventListener('click', function () {
        if (sidebar.classList.contains('open')) {
            closeSidebar();
        } else {
            abrirSidebar();
        }
    });

    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

    function voltarPagina() {
        if (document.referrer &&
            new URL(document.referrer).origin === window.location.origin) {
            window.history.back();
        } else {
            window.location.href = "{{ url('/') }}";
        }
    }
</script>
@stack('scripts')

</body>
</html>
