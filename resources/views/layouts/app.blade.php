<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Painel de Gestão') | Denúncias</title>

    <style>
        :root {
            --sidebar: #176b57;
            --sidebar-hover: #105442;
            --primary: #176b57;
            --primary-light: #e6f4ef;
            --background: #f4f6fa;
            --surface: #ffffff;
            --text: #1d2939;
            --muted: #667085;
            --border: #e4e7ec;
            --sidebar-width: 260px;
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
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;
            background: var(--sidebar);
            color: white;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            z-index: 1000;
            transition: transform .25s ease;
        }

        .brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,.10);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #d8f3e9;
            color: #176b57;
            display: grid;
            place-items: center;
            font-size: 23px;
            font-weight: 800;
        }

        .brand h2 {
            font-size: 14px;
            margin: 0 0 5px;
            line-height: 1.4;
        }

        .brand p {
            margin: 0;
            color: #d0e4dc;
            font-size: 11px;
        }

        .menu {
            padding: 15px 12px;
            flex: 1;
        }

        .menu-heading {
            color: #c1d9d0;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.3px;
            padding: 18px 12px 8px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            margin: 3px 0;
            border-radius: 7px;
            color: #e4eee9;
            font-size: 13px;
            transition: .2s;
        }

        .menu-link:hover {
            background: var(--sidebar-hover);
            color: white;
        }

        .menu-link.active {
            background: #ffffff;
            color: var(--primary);
            font-weight: 700;
        }

        .menu-icon {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-footer {
            border-top: 1px solid rgba(255,255,255,.10);
            padding: 16px;
            color: #d0e4dc;
            font-size: 11px;
            line-height: 1.7;
        }

        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
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
            display: none;
            border: 1px solid var(--border);
            background: white;
            border-radius: 7px;
            padding: 8px 11px;
            cursor: pointer;
            font-size: 18px;
        }

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
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

    <div class="sidebar-footer">
        Sistema de Gestão de Denúncias<br>
        Proteção e conservação dos bens públicos
    </div>

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

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
    }

    toggle?.addEventListener('click', function () {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('open');
    });

    overlay.addEventListener('click', closeSidebar);
</script>

@stack('scripts')

</body>
</html>