
<?php

$produto = $produto ?? [];
$feedbacks = $feedbacks ?? [];

// Dados do produto
$nomeProduto = (string) ($produto['Nome'] ?? 'Produto');
$precoProduto = (float) ($produto['Preco'] ?? 0);
$tipoProduto = (string) ($produto['Tipo'] ?? '');
$descricaoProduto = (string) ($produto['Descricao'] ?? '');
$idProduto = (int) ($produto['Idproduto'] ?? 0);

// Imagem do produto
$imagemProduto = trim((string) ($produto['Imagem'] ?? ''));

if ($imagemProduto === '') {
    $imagemProduto = '/elyon/assets/imgs/logo%20ELYON%201.png';
} elseif (!preg_match('/^(https?:\/\/|\/)/i', $imagemProduto)) {
    $imagemProduto = '/elyon/' . ltrim($imagemProduto, '/');
}

$imagemProduto = str_replace(' ', '%20', $imagemProduto);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?> - Elyon
    </title>

    <link rel="stylesheet" href="/elyon/assets/css/global.css">
    <link rel="stylesheet" href="/elyon/assets/css/compra.css">

</head>

<body>

    <?php require_once __DIR__ . '/../../../includes/header.php'; ?>

    <main>

        <!-- PRODUTO -->
        <section class="produto">

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


            <!-- INFORMAÇÕES DO PRODUTO -->
            <div class="info_produto">

                <h2>
                    <?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>
                </h2>

                <p>
                    R$
                    <?= number_format($precoProduto, 2, ',', '.') ?>
                </p>

                <span class="categoria">
                    <?= htmlspecialchars($tipoProduto, ENT_QUOTES, 'UTF-8') ?>
                </span>

                <p>
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
                            Ir ao carrinho
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

                            <div class="feedback_info">

                                <h4>
                                    <?= htmlspecialchars(
                                        $feedback['Nome'] ?? 'Usuário',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </h4>

                                <p>
                                    Avaliação:

                                    <?= htmlspecialchars(
                                        (string) ($feedback['Avaliacao'] ?? 'N/A'),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </p>

                            </div>

                            <div class="feedback_texto">

                                <p>
                                    <?= htmlspecialchars(
                                        $feedback['Comentario'] ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </p>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="feedback_card">

                        <div class="feedback_texto">

                            <p>
                                Ainda não existem avaliações para este produto.
                            </p>

                        </div>

                    </div>

                <?php endif; ?>

                <p class="mais">
                    Mais
                </p>

            </div>

        </section>

    </main>


    <?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

</body>
</html>
