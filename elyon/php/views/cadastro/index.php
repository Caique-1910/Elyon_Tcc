<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../../assets/css/cadastro.css">

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

    <?php if (isset($erro)): ?>

        <p class="erro">
            <?= htmlspecialchars($erro) ?>
        </p>

    <?php endif; ?>

    <?php if (isset($sucesso)): ?>

        <p class="sucesso">
            <?= htmlspecialchars($sucesso) ?>
        </p>

    <?php endif; ?>

    <form action="/elyon/index.php?url=cadastro/salvar" method="POST">

        <div class="form-group">

            <label for="nome">Nome Completo:</label>

            <input
                type="text"
                id="nome"
                name="nome"
                placeholder="Digite seu nome"
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
                required
            >

        </div>

        <button type="submit" class="btn">
            Criar Conta
        </button>

    </form>

    <div class="link">

        Já possui conta?

        <a href="/elyon/index.php?url=login">
            Entrar
        </a>

    </div>

</div>

</body>
</html>