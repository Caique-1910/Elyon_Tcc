
<?php

$produto = $produto ?? [];
$feedbacks = $feedbacks ?? [];

// INFORMAÇÕES DO PRODUTO
$nomeProduto = (string) ($produto['Nome'] ?? 'Produto');
$precoProduto = (float) ($produto['Preco'] ?? 0);
$tipoProduto = (string) ($produto['Tipo'] ?? '');
$descricaoProduto = (string) ($produto['Descricao'] ?? '');
$idProduto = (int) ($produto['Idproduto'] ?? 0);

// TOKEN CSRF
$tokenCsrf = $_SESSION['csrf_token'] ?? '';

// IMAGEM DO PRODUTO
$imagem = trim((string) ($produto['Imagem'] ?? ''));

if ($imagem === '') {

    $imagem = BASE_URL . '/assets/imgs/logoElyon1.png';

} elseif (!preg_match('/^https?:\/\//i', $imagem)) {

    // Remove caminhos relativos e barras iniciais
    $imagem = preg_replace('/^(\.\.\/)+/', '', $imagem);
    $imagem = ltrim($imagem, '/');

    $imagem = BASE_URL . '/' . $imagem;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>
        - Elyon Perfumaria
    </title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/footer.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/compra.css">
</head>

<body>

    <?php require_once __DIR__ . '/../../../includes/header.php'; ?>

    <main>

        <!-- PRODUTO -->
        <section class="produto">

            <!-- GALERIA -->
            <div class="galeria">

                <div class="miniaturas">

                    <img
                        src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>"
                    >

                    <img
                        src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>"
                    >

                    <img
                        src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>"
                    >

                </div>

                <div class="img_principal">

                    <img
                        src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>"
                    >

                </div>

            </div>

            <!-- INFORMAÇÕES -->
            <div class="info_produto">

                <h1>
                    <?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>
                </h1>

                <p class="preco_produto">
                    R$ <?= number_format($precoProduto, 2, ',', '.') ?>
                </p>

                <span class="categoria">
                    <?= htmlspecialchars($tipoProduto, ENT_QUOTES, 'UTF-8') ?>
                </span>

                <p class="descricao">
                    <?= htmlspecialchars($descricaoProduto, ENT_QUOTES, 'UTF-8') ?>
                </p>

                <!-- FORMULÁRIO DE COMPRA -->
                <form action="<?= BASE_URL ?>/compra/adicionar" method="POST">

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars($tokenCsrf, ENT_QUOTES, 'UTF-8') ?>"
                    >

                    <input
                        type="hidden"
                        name="idproduto"
                        value="<?= $idProduto ?>"
                    >

                    <label for="quantidade">
                        Quantidade
                    </label>

                    <input
                        type="number"
                        id="quantidade"
                        name="quantidade"
                        value="1"
                        min="1"
                        step="1"
                        required
                    >

                    <div class="botoes_compra">

                        <button
                            type="submit"
                            name="acao"
                            value="comprar"
                            class="comprar"
                        >
                            Comprar
                        </button>

                        <button
                            type="submit"
                            name="acao"
                            value="carrinho"
                            class="carrinho"
                        >
                            Adicionar ao carrinho
                        </button>

                    </div>

                </form>

            </div>

        </section>

        <!-- FEEDBACK -->
        <section class="feedback">

            <div class="feedback_container">

                <h2>Feedback</h2>

                <?php if (!empty($feedbacks)): ?>

                    <?php foreach ($feedbacks as $feedback): ?>

                        <div class="feedback_card">

                            <div class="feedback_usuario">

                                <strong>
                                    <?= htmlspecialchars(
                                        $feedback['NomeUsuario'] ?? 'Usuário',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </strong>

                            </div>

                            <div class="feedback_estrelas">

                                <?php

                                $estrelas = max(
                                    0,
                                    min(5, (int) ($feedback['Estrela'] ?? 0))
                                );

                                for ($i = 1; $i <= 5; $i++):

                                ?>

                                    <?php if ($i <= $estrelas): ?>
                                        <span>★</span>
                                    <?php else: ?>
                                        <span>☆</span>
                                    <?php endif; ?>

                                <?php endfor; ?>

                            </div>

                            <p class="feedback_comentario">
                                <?= htmlspecialchars(
                                    $feedback['Comentario'] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </p>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="feedback_card">

                        <p>
                            Ainda não existem avaliações para este produto.
                        </p>

                    </div>

                <?php endif; ?>

            </div>

        </section>

    </main>

    <?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

</body>
</html>
