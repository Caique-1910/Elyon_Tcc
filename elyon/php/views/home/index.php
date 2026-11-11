
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Elyon Perfumaria</title>

    <link rel="stylesheet" href="../../../assets/css/global.css">
    <link rel="stylesheet" href="../../../assets/css/home.css">
    <link rel="stylesheet" href="../../../assets/css/tabelaCards.css">

    <script src="/elyon/assets/js/home.js" defer></script>
</head>

<body>

    <!-- HEADER -->
    <?php
    require_once __DIR__ . '/../../../includes/header.php';
    ?>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="conteudo_principal">

        <!-- CARROSSEL -->
        <section id="banner" class="carrossel" aria-label="Destaques da Elyon">

            <div class="carrossel-slides">

                <!-- SLIDE 1 -->
                <div class="slide ativo">
                    <img
                        src="/elyon/assets/imgs/banner1.jpg"
                        alt="Coleção de perfumes Elyon"
                    >

                    <div class="banner-texto">
                        <h1>Sinta a sua essência</h1>
                        <p>Descubra fragrâncias que combinam com você.</p>

                        <a href="/elyon/masculino" class="banner-botao">
                            Descobrir fragrâncias
                        </a>
                    </div>
                </div>

                <!-- SLIDE 2 -->
                <div class="slide">
                    <img
                        src="/elyon/assets/imgs/banner2.jpg"
                        alt="Perfumes sofisticados"
                    >

                    <div class="banner-texto">
                        <h1>Elegância em cada detalhe</h1>
                        <p>Encontre o perfume ideal para momentos especiais.</p>

                        <a href="/elyon/feminino" class="banner-botao">
                            Explorar coleção
                        </a>
                    </div>
                </div>

                <!-- SLIDE 3 -->
                <div class="slide">
                    <img
                        src="/elyon/assets/imgs/banner3.jpg"
                        alt="Produtos de beleza e cuidados pessoais"
                    >

                    <div class="banner-texto">
                        <h1>Seu momento de cuidado</h1>
                        <p>Conheça nossos produtos de beleza e skincare.</p>

                        <a href="/elyon/skincare" class="banner-botao">
                            Conhecer produtos
                        </a>
                    </div>
                </div>

            </div>

            <!-- SETA ANTERIOR -->
            <button
                type="button"
                class="seta seta-anterior"
                aria-label="Banner anterior"
            >
                &#10094;
            </button>

            <!-- PRÓXIMA SETA -->
            <button
                type="button"
                class="seta seta-proxima"
                aria-label="Próximo banner"
            >
                &#10095;
            </button>

            <!-- INDICADORES -->
            <div class="indicadores">

                <button
                    type="button"
                    class="indicador ativo"
                    aria-label="Ir para banner 1"
                    aria-current="true"
                ></button>

                <button
                    type="button"
                    class="indicador"
                    aria-label="Ir para banner 2"
                ></button>

                <button
                    type="button"
                    class="indicador"
                    aria-label="Ir para banner 3"
                ></button>

            </div>

        </section>

        <!-- CARDS / PRODUTOS -->
        <section class="cards">

            <?php
            require_once __DIR__ . '/../../../includes/tabelaCards.php';
            ?>

        </section>

    </main>

    <!-- FOOTER -->
    <?php
    require_once __DIR__ . '/../../../includes/footer.php';
    ?>

</body>

</html>
