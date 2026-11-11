
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuarioLogado = isset($_SESSION['usuario_id']);
$nomeUsuario = $_SESSION['usuario_nome'] ?? '';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Elyon Perfumaria</title>

    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/global.css">
</head>

<body>

    <header class="header">

        <div class="logo">

            <a href="/elyon/">

                <img
                    class="logoimg"
                    src="/elyon/assets/imgs/logoElyon.png"
                    alt="Logo Elyon"
                >

            </a>

        </div>

        <nav class="navbar">

            <a href="/elyon/">
                Home
            </a>

            <a href="/elyon/masculino">
                Perfumes Masculinos
            </a>

            <a href="/elyon/feminino">
                Perfumes Femininos
            </a>

            <a href="/elyon/skincare">
                Skin Care
            </a>

            <a href="/elyon/maquiagem">
                Maquiagem
            </a>

            <a href="/elyon/cabelos">
                Cabelos
            </a>

            <a href="/elyon/sobre">
                Sobre
            </a>

            <a href="/elyon/feedback">
                Feedback
            </a>

            <a href="/elyon/contato">
                Contato
            </a>

        </nav>

        <div class="auth-buttons">

            <?php if ($usuarioLogado): ?>

                <span class="nome-usuario">
                    Olá, <?= htmlspecialchars($nomeUsuario, ENT_QUOTES, 'UTF-8') ?>
                </span>

                <a
                    href="/elyon/index.php?url=logout"
                    class="register-btn"
                >
                    Sair
                </a>

            <?php else: ?>

                <a
                    href="/elyon/login"
                    class="login-btn"
                >
                    Entrar
                </a>

                <a
                    href="/elyon/cadastro"
                    class="register-btn"
                >
                    Cadastrar-se
                </a>

            <?php endif; ?>

        </div>

    </header>

</body>

</html>
