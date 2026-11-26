
<?php

$produtos = $produtos ?? [];
$erro = $erro ?? '';
$sucesso = $sucesso ?? '';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Feedback - Elyon Perfumaria</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/feedback.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/footer.css">

</head>

<body>

    <!-- HEADER -->

    <?php
    require_once __DIR__ . '/../../../includes/header.php';
    ?>

    <!-- CONTEÚDO -->

    <main class="container">

        <div class="feedback-card">

            <h1>Conte sua experiência</h1>

            <p class="subtitle">
                Seu feedback nos ajuda a oferecer fragrâncias ainda mais especiais.
            </p>

            <?php if ($erro !== ''): ?>

                <p class="erro">
                    <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
                </p>

            <?php endif; ?>

            <?php if ($sucesso !== ''): ?>

                <p class="sucesso">
                    <?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?>
                </p>

            <?php endif; ?>

            <form
                method="POST"
                action="<?= BASE_URL ?>/feedback/salvar"
            >

                <!-- PRODUTO -->

                <label for="idproduto">
                    Qual produto você comprou?
                </label>

                <select
                    id="idproduto"
                    name="idproduto"
                    required
                >

                    <option value="">
                        Selecione um produto
                    </option>

                    <?php if (!empty($produtos)): ?>

                        <?php foreach ($produtos as $produto): ?>

                            <option
                                value="<?= (int) ($produto['Idproduto'] ?? 0) ?>"
                            >
                                <?= htmlspecialchars(
                                    $produto['Nome'] ?? 'Produto',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </option>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </select>

                <!-- ESTRELAS -->

                <label id="label-avaliacao">
                    Como você avalia o produto?
                </label>

                <div
                    class="rating"
                    role="radiogroup"
                    aria-labelledby="label-avaliacao"
                >

                    <input
                        type="radio"
                        name="estrela"
                        id="star5"
                        value="5"
                        required
                    >

                    <label for="star5" aria-label="5 estrelas">★</label>

                    <input
                        type="radio"
                        name="estrela"
                        id="star4"
                        value="4"
                    >

                    <label for="star4" aria-label="4 estrelas">★</label>

                    <input
                        type="radio"
                        name="estrela"
                        id="star3"
                        value="3"
                    >

                    <label for="star3" aria-label="3 estrelas">★</label>

                    <input
                        type="radio"
                        name="estrela"
                        id="star2"
                        value="2"
                    >

                    <label for="star2" aria-label="2 estrelas">★</label>

                    <input
                        type="radio"
                        name="estrela"
                        id="star1"
                        value="1"
                    >

                    <label for="star1" aria-label="1 estrela">★</label>

                </div>

                <!-- COMENTÁRIO -->

                <label for="comentario">
                    Conte-nos sua opinião!
                </label>

                <textarea
                    id="comentario"
                    name="comentario"
                    rows="5"
                    minlength="3"
                    maxlength="300"
                    placeholder="Conte sua experiência com o produto..."
                    required
                ></textarea>

                <!-- ENVIO -->

                <button
                    type="submit"
                    class="submit-btn"
                >
                    Enviar Feedback
                </button>

            </form>

        </div>

    </main>

    <!-- FOOTER -->

    <?php
    require_once __DIR__ . '/../../../includes/footer.php';
    ?>

</body>

</html>
