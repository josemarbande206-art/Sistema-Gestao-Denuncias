<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de Gestão de Denúncias</title>

    <<link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <header>
        <h1>Sistema de Gestão de Denúncias</h1>
        <p>Protegendo os bens públicos, construindo uma sociedade melhor.</p>
    </header>

    <main class="container">

        <h2>Bem-vindo ao Sistema</h2>

        <p>
            Esta plataforma permite registar e acompanhar denúncias
            relacionadas com a vandalização de bens públicos.
        </p>

        <div class="botoes">
            <a href="pages/login.php" class="botao">Iniciar sessão</a>

            <a href="pages/registar_denuncia.php" class="botao">
                Registar denúncia
            </a>
        </div>

    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> — Sistema de Gestão de Denúncias</p>
    </footer>

</body>
</html>