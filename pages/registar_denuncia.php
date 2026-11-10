<?php
session_start();

require_once __DIR__ . '/../config/database.php';

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $categoria_id = filter_input(
        INPUT_POST,
        'categoria_id',
        FILTER_VALIDATE_INT
    );

    $provincia = trim($_POST['provincia'] ?? '');
    $municipio = trim($_POST['municipio'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');

    if (
        $titulo === '' ||
        $descricao === '' ||
        !$categoria_id ||
        $provincia === '' ||
        $municipio === ''
    ) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } else {
        try {
            $pdo->beginTransaction();

            // Registar a localização.
            $sqlLocalizacao = "
                INSERT INTO localizacoes
                    (provincia, municipio, bairro)
                VALUES
                    (:provincia, :municipio, :bairro)
            ";

            $stmt = $pdo->prepare($sqlLocalizacao);

            $stmt->execute([
                ':provincia' => $provincia,
                ':municipio' => $municipio,
                ':bairro' => $bairro !== '' ? $bairro : null
            ]);

            $localizacao_id = (int) $pdo->lastInsertId();

            // Gerar um código único para a denúncia.
            $codigo = 'DEN-' . date('YmdHis') . '-' .
                      random_int(100, 999);

            // Registar a ocorrência.
            $sqlOcorrencia = "
                INSERT INTO ocorrencias (
                    codigo,
                    titulo,
                    descricao,
                    data_registo,
                    estado,
                    categoria_id,
                    localizacao_id
                ) VALUES (
                    :codigo,
                    :titulo,
                    :descricao,
                    NOW(),
                    'pendente',
                    :categoria_id,
                    :localizacao_id
                )
            ";

            $stmt = $pdo->prepare($sqlOcorrencia);

            $stmt->execute([
                ':codigo' => $codigo,
                ':titulo' => $titulo,
                ':descricao' => $descricao,
                ':categoria_id' => $categoria_id,
                ':localizacao_id' => $localizacao_id
            ]);

            $pdo->commit();

            $mensagem = 'Denúncia registada com sucesso! Código: ' .
                        htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8');

        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            error_log($e->getMessage());

            $erro = 'Não foi possível registar a denúncia. ' .
                    'Verifique a estrutura da base de dados.';
        }
    }
}

// Obter as categorias disponíveis.
try {
    $stmt = $pdo->query(
        'SELECT id, nome FROM categorias ORDER BY nome'
    );

    $categorias = $stmt->fetchAll();

} catch (PDOException $e) {
    error_log($e->getMessage());
    $categorias = [];

    if ($erro === '') {
        $erro = 'Não foi possível carregar as categorias.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registar Denúncia</title>

    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

    <main class="formulario-container">

        <h1>Registar Denúncia</h1>

        <p>
            Utilize este formulário para comunicar casos de vandalização
            de bens públicos.
        </p>

        <?php if ($mensagem !== ''): ?>
            <div class="mensagem-sucesso">
                <?= $mensagem ?>
            </div>
        <?php endif; ?>

        <?php if ($erro !== ''): ?>
            <div class="mensagem-erro">
                <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">

            <label for="titulo">Título da denúncia *</label>

            <input
                type="text"
                id="titulo"
                name="titulo"
                maxlength="150"
                required
                value="<?= htmlspecialchars($_POST['titulo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
            >

            <label for="descricao">Descrição da ocorrência *</label>

            <textarea
                id="descricao"
                name="descricao"
                rows="5"
                required
            ><?= htmlspecialchars($_POST['descricao'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

            <label for="categoria_id">Categoria *</label>

            <select id="categoria_id" name="categoria_id" required>
                <option value="">Selecione uma categoria</option>

                <?php foreach ($categorias as $categoria): ?>
                    <option
                        value="<?= (int) $categoria['id'] ?>"
                        <?= (($_POST['categoria_id'] ?? '') == $categoria['id']) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($categoria['nome'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="provincia">Província *</label>

            <input
                type="text"
                id="provincia"
                name="provincia"
                maxlength="100"
                required
                value="<?= htmlspecialchars($_POST['provincia'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
            >

            <label for="municipio">Município *</label>

            <input
                type="text"
                id="municipio"
                name="municipio"
                maxlength="100"
                required
                value="<?= htmlspecialchars($_POST['municipio'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
            >

            <label for="bairro">Bairro</label>

            <input
                type="text"
                id="bairro"
                name="bairro"
                maxlength="150"
                value="<?= htmlspecialchars($_POST['bairro'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
            >

            <button type="submit">Enviar Denúncia</button>

        </form>

        <p>
            <a href="../index.php">Voltar à página inicial</a>
        </p>

    </main>

</body>
</html>