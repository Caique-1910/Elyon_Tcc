
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// MENSAGEM DE REDIRECIONAMENTO
if (!empty($_SESSION['mensagem_login'])):
    $mensagem = $_SESSION['mensagem_login'];
    unset($_SESSION['mensagem_login']);
?>

    <script>
        alert(<?= json_encode(
            $mensagem,
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_AMP |
            JSON_HEX_QUOT
        ) ?>);
    </script>

<?php endif; ?>

<?php
// MENSAGEM DE ERRO NO LOGIN
if (!empty($_SESSION['mensagem_erro_login'])):
    $mensagem = $_SESSION['mensagem_erro_login'];
    unset($_SESSION['mensagem_erro_login']);
?>

    <script>
        alert(<?= json_encode(
            $mensagem,
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_AMP |
            JSON_HEX_QUOT
        ) ?>);
    </script>

<?php endif; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        rel="stylesheet"
        href="<?= BASE_URL ?>/assets/css/login.css"
    >

    <title>Login - Elyon</title>
</head>

<body>

<div class="cardlog">

    <div class="logo">
        <h1>ELYON</h1>
    </div>

    <h2>Entrar</h2>

    <p class="subtitulo">
        Acesse sua conta
    </p>

    <?php if (isset($erro)): ?>
        <p class="erro">
            <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/login/salvar" method="POST">

        <!-- TOKEN CSRF -->
        <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars(
                $_SESSION['csrf_token'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >

        <div class="form-group">

            <label for="email">E-mail:</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Digite seu e-mail"
                required
            >

        </div>

        <div class="form-group">

            <label for="senha">Senha:</label>

            <input
                type="password"
                id="senha"
                name="senha"
                placeholder="Digite sua senha"
                required
            >

        </div>

        <button type="submit" class="btn">
            Entrar
        </button>

    </form>

    <div class="link">

        Não possui conta?

        <a href="<?= BASE_URL ?>/cadastro">
            Cadastre-se
        </a>

    </div>

</div>

</body>
</html>
