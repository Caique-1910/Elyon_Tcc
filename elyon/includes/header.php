
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuarioLogado = isset($_SESSION['usuario_id']);
$nomeUsuario = $_SESSION['usuario_nome'] ?? '';

?>

<header class="header">

    <div class="logo">

        <a href="<?= BASE_URL ?>/">

            <img
                class="logoimg"
                src="<?= BASE_URL ?>/assets/imgs/logoElyon.png"
                alt="Logo Elyon"
            >

        </a>

    </div>

    <nav class="navbar">

        <a href="<?= BASE_URL ?>/">
            Home
        </a>

        <a href="<?= BASE_URL ?>/masculino">
            Perfumes Masculinos
        </a>

        <a href="<?= BASE_URL ?>/feminino">
            Perfumes Femininos
        </a>

        <a href="<?= BASE_URL ?>/skincare">
            Skin Care
        </a>

        <a href="<?= BASE_URL ?>/maquiagem">
            Maquiagem
        </a>

        <a href="<?= BASE_URL ?>/cabelos">
            Cabelos
        </a>

        <a href="<?= BASE_URL ?>/sobre">
            Sobre
        </a>

        <a href="<?= BASE_URL ?>/feedback">
            Feedback
        </a>

        <a href="<?= BASE_URL ?>/contato">
            Contato
        </a>

    </nav>

    <div class="auth-buttons">

        <?php if ($usuarioLogado): ?>

            <span class="nome-usuario">
                Olá, <?= htmlspecialchars($nomeUsuario, ENT_QUOTES, 'UTF-8') ?>
            </span>

            <a
                href="<?= BASE_URL ?>/logout"
                class="register-btn"
            >
                Sair
            </a>

        <?php else: ?>

            <a
                href="<?= BASE_URL ?>/login"
                class="login-btn"
            >
                Entrar
            </a>

            <a
                href="<?= BASE_URL ?>/cadastro"
                class="register-btn"
            >
                Cadastrar-se
            </a>

        <?php endif; ?>

    </div>

</header>
