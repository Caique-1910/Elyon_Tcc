<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../../assets/css/login.css">

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
            <?= htmlspecialchars($erro) ?>
        </p>
    <?php endif; ?>

    <form action="/elyon/index.php?url=login/salvar" method="POST">

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

        <a href="/elyon/index.php?url=cadastro">
            Cadastre-se
        </a>

    </div>

</div>

</body>
</html>