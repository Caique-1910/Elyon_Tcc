
<?php

$carrinho = $carrinho ?? [];

$cupomAplicado = $cupomAplicado ?? ($_SESSION['cupom'] ?? null);

$mensagemCupom = $mensagemCupom ?? '';

if (!is_array($cupomAplicado)) {
    $cupomAplicado = null;
}

$totalGeral = 0;

foreach ($carrinho as $item) {
    $preco = (float) ($item['preco'] ?? 0);
    $quantidade = max(1, (int) ($item['quantidade'] ?? 1));

    $totalGeral += $preco * $quantidade;
}

$percentualDesconto = max(
    0,
    min(100, (float) ($cupomAplicado['Valordesconto'] ?? 0))
);

$valorDesconto = round(
    $totalGeral * $percentualDesconto / 100,
    2
);

$totalComDesconto = max(0, $totalGeral - $valorDesconto);


if (!function_exists('caminhoImagemCarrinho')) {
    function caminhoImagemCarrinho($imagem)
    {
        $imagem = trim((string) $imagem);

        if ($imagem === '') {
            return '/elyon/assets/imgs/logoElyon1.png';
        }

        if (preg_match('/^(https?:\/\/|\/)/i', $imagem)) {
            return $imagem;
        }

        return '/elyon/' . ltrim($imagem, '/');
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Meu Carrinho - Elyon Perfumaria</title>

    <link rel="stylesheet" href="/elyon/assets/css/global.css">
    <link rel="stylesheet" href="/elyon/assets/css/carrinho.css">
</head>

<body>

    <?php require_once __DIR__ . '/../../../includes/header.php'; ?>

    <main class="conteudo_carrinho">

        <h1>Meu carrinho</h1>

        <?php if (empty($carrinho)): ?>

            <section class="carrinho-vazio">

                <h2>Seu carrinho está vazio</h2>

                <p>
                    Explore nossos perfumes e encontre sua próxima
                    fragrância favorita!
                </p>

                <a href="/elyon/" class="btn-voltar">
                    Continuar comprando
                </a>

            </section>

        <?php else: ?>

            <div class="tabela-container">

                <table class="tabela-carrinho">

                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($carrinho as $id => $item): ?>

                            <?php

                            $nome = (string) ($item['nome'] ?? 'Produto');

                            $preco = (float) ($item['preco'] ?? 0);

                            $quantidade = max(
                                1,
                                (int) ($item['quantidade'] ?? 1)
                            );

                            $subtotal = $preco * $quantidade;

                            $imagem = caminhoImagemCarrinho(
                                $item['imagem'] ?? ''
                            );

                            ?>

                            <tr>

                                <td class="produto">

                                    <img
                                        src="<?= htmlspecialchars(
                                            $imagem,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        alt="<?= htmlspecialchars(
                                            $nome,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        loading="lazy"
                                    >

                                    <span>
                                        <?= htmlspecialchars(
                                            $nome,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </span>

                                </td>

                                <td>
                                    R$ <?= number_format(
                                        $preco,
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                </td>

                                <td>
                                    <?= $quantidade ?>
                                </td>

                                <td>
                                    R$ <?= number_format(
                                        $subtotal,
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <section class="acoes-carrinho">

                <div class="cupom">

                    <h2>Cupom de desconto</h2>

                    <form
                        action="/elyon/carrinho"
                        method="post"
                    >

                        <input
                            type="text"
                            name="cupom"
                            placeholder="Digite o código do cupom"
                            maxlength="50"
                            value="<?= htmlspecialchars(
                                $cupomAplicado['Codigo'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                        >

                        <button type="submit">
                            Aplicar cupom
                        </button>

                    </form>

                    <?php if ($mensagemCupom !== ''): ?>

                        <p class="mensagem-cupom">
                            <?= htmlspecialchars(
                                $mensagemCupom,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>

                    <?php endif; ?>

                    <?php if ($percentualDesconto > 0): ?>

                        <p>
                            Cupom aplicado:

                            <strong>
                                <?= htmlspecialchars(
                                    $cupomAplicado['Codigo'] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </strong>
                        </p>

                        <p>
                            Desconto:

                            <?= number_format(
                                $percentualDesconto,
                                2,
                                ',',
                                '.'
                            ) ?>%
                        </p>

                    <?php endif; ?>

                </div>

                <div class="pedido">

                    <div class="pagamento">

                        <p>
                            Escolha a forma de pagamento e a opção
                            de frete na finalização.
                        </p>

                        <p>
                            Subtotal:

                            R$ <?= number_format(
                                $totalGeral,
                                2,
                                ',',
                                '.'
                            ) ?>
                        </p>

                        <?php if ($valorDesconto > 0): ?>

                            <p>
                                Desconto:

                                - R$ <?= number_format(
                                    $valorDesconto,
                                    2,
                                    ',',
                                    '.'
                                ) ?>
                            </p>

                        <?php endif; ?>

                        <h3>
                            Total:

                            R$ <?= number_format(
                                $totalComDesconto,
                                2,
                                ',',
                                '.'
                            ) ?>
                        </h3>

                    </div>

                    <div class="botoes">

                        <a
                            href="/elyon/"
                            class="btn-voltar"
                        >
                            Continuar comprando
                        </a>

                        <a
                            href="/elyon/finalizacao"
                            class="btn-finalizar"
                        >
                            Fechar pedido
                        </a>

                    </div>

                </div>

            </section>

        <?php endif; ?>

    </main>

    <?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

</body>

</html>
