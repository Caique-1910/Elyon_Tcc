
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/cadastro.css">

    <title>Cadastro - Elyon</title>
</head>

<body>

<div class="card">

    <div class="logo">
        <h1>ELYON</h1>
    </div>

    <h2 class="titulo">Criar Conta</h2>

    <p class="subtitulo">
        Cadastre-se para acessar nossa perfumaria
    </p>

    <?php if (isset($erro) && $erro !== ''): ?>
        <p class="erro">
            <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <?php if (isset($sucesso) && $sucesso !== ''): ?>
        <p class="sucesso">
            <?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/cadastro/salvar" method="POST">

        <!-- TOKEN DE SEGURANÇA CSRF -->
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

            <label for="nome">Nome Completo:</label>

            <input
                type="text"
                id="nome"
                name="nome"
                placeholder="Digite seu nome"
                maxlength="70"
                autocomplete="name"
                required
            >

        </div>

        <div class="form-group">

            <label for="email">E-mail:</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Digite seu e-mail"
                maxlength="100"
                autocomplete="email"
                required
            >

        </div>

        <div class="form-group">

            <label for="senha">Senha:</label>

            <input
                type="password"
                id="senha"
                name="senha"
                placeholder="Crie uma senha"
                autocomplete="new-password"
                required
            >

        </div>

        <div class="form-group">

            <label for="confirmar_senha">Confirmar Senha:</label>

            <input
                type="password"
                id="confirmar_senha"
                name="confirmar_senha"
                placeholder="Repita sua senha"
                autocomplete="new-password"
                required
            >

        </div>

        <button type="submit" class="btn">
            Criar Conta
        </button>

    </form>

    <div class="link">

        Já possui conta?

        <a href="<?= BASE_URL ?>/login">
            Entrar
        </a>

    </div>

</div>

</body>
</html>
