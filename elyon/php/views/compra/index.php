
<?php

$produto = $produto ?? [];
$feedbacks = $feedbacks ?? [];

$nomeProduto = (string) ($produto['Nome'] ?? 'Produto');
$imagemProduto = trim((string) ($produto['Imagem'] ?? ''));

// Tratamento do caminho da imagem
if ($imagemProduto === '') {
    $imagemProduto = '/elyon/assets/imgs/logoElyon1.png';
} elseif (!preg_match('/^(https?:\/\/|\/)/i', $imagemProduto)) {
    $imagemProduto = '/elyon/' . ltrim($imagemProduto, '/');
} elseif (strpos($imagemProduto, '/elyon/') === 0) {
    // Mantém o caminho já configurado
}

$precoProduto = (float) ($produto['Preco'] ?? 0);
$tipoProduto = (string) ($produto['Tipo'] ?? '');
$descricaoProduto = (string) ($produto['Descricao'] ?? '');
$idProduto = (int) ($produto['Idproduto'] ?? 0);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?> - Elyon Perfumaria</title>

    <link rel="stylesheet" href="../../../assets/css/global.css">
    <link rel="stylesheet" href="../../../assets/css/header.css">
    <link rel="stylesheet" href="../../../assets/css/footer.css">
    <link rel="stylesheet" href="../../../assets/css/compra.css">
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
                        src="<?= htmlspecialchars($imagemProduto, ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>"
                    >

                    <img
                        src="<?= htmlspecialchars($imagemProduto, ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>"
                    >

                    <img
                        src="<?= htmlspecialchars($imagemProduto, ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>"
                    >

                </div>

                <div class="img_principal">

                    <img
                        src="<?= htmlspecialchars($imagemProduto, ENT_QUOTES, 'UTF-8') ?>"
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
                <form action="/elyon/compra/adicionar" method="POST">

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
