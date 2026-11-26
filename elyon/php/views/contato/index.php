
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contato - Elyon Perfumaria</title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/cardContato.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/contato.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/footer.css">

    <!-- JavaScript -->
    <script src="<?= BASE_URL ?>/assets/js/contato.js" defer></script>
</head>

<body>

    <!-- HEADER -->
    <?php
    require_once __DIR__ . '/../../../includes/header.php';
    ?>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="conteudo_principal">

        <!-- BANNER -->
        <section id="banner"></section>

        <!-- CONTATO -->
        <section class="contato">

            <div class="texto_contato">

                <h2>Contato</h2>

                <p>
                    Como podemos ajudar? Escolha uma opção abaixo para saber mais.
                </p>

            </div>

            <!-- CARDS DE CONTATO -->
            <?php
            require_once __DIR__ . '/../../../includes/tabelaCardsContato.php';
            ?>

        </section>

    </main>

    <!-- FOOTER -->
    <?php
    require_once __DIR__ . '/../../../includes/footer.php';
    ?>

</body>

</html>
