
<?php

$carrinho = $carrinho ?? [];

$cupomAplicado = $cupomAplicado ?? ($_SESSION['cupom'] ?? null);

$mensagemCupom = $mensagemCupom ?? ($_SESSION['mensagem_cupom'] ?? '');

$mensagemCarrinho = $mensagemCarrinho ?? ($_SESSION['mensagem_carrinho'] ?? '');

$tokenCsrf = $_SESSION['csrf_token'] ?? '';

unset(
    $_SESSION['mensagem_carrinho'],
    $_SESSION['mensagem_cupom']
);

if (!is_array($carrinho)) {
    $carrinho = [];
}

if (!is_array($cupomAplicado)) {
    $cupomAplicado = null;
}

// CALCULA O TOTAL DO CARRINHO
$totalGeral = 0;

foreach ($carrinho as $item) {
    if (!is_array($item)) {
        continue;
    }

    $preco = max(0, (float) ($item['preco'] ?? 0));
    $quantidade = max(1, (int) ($item['quantidade'] ?? 1));

    $totalGeral += $preco * $quantidade;
}

$totalGeral = round($totalGeral, 2);

// CALCULA O DESCONTO
$percentualDesconto = max(
    0,
    min(100, (float) ($cupomAplicado['Valordesconto'] ?? 0))
);

$valorDesconto = round(
    $totalGeral * $percentualDesconto / 100,
    2
);

$totalComDesconto = max(
    0,
    round($totalGeral - $valorDesconto, 2)
);

// CAMINHO DAS IMAGENS
if (!function_exists('caminhoImagemCarrinho')) {
    function caminhoImagemCarrinho($imagem)
    {
        $imagem = trim((string) $imagem);

        if ($imagem === '') {
            return BASE_URL . '/assets/imgs/logoElyon1.png';
        }

        if (preg_match('/^https?:\/\//i', $imagem)) {
            return $imagem;
        }

        $imagem = preg_replace('/^(\.\.\/)+/', '', $imagem);
        $imagem = ltrim($imagem, '/');

        return BASE_URL . '/' . $imagem;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Meu Carrinho - Elyon Perfumaria</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/carrinho.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/footer.css">
</head>

<body>

    <?php require_once __DIR__ . '/../../../includes/header.php'; ?>

    <main class="conteudo_carrinho">

        <h1>Meu carrinho</h1>

        <?php if ($mensagemCarrinho !== ''): ?>

            <p class="mensagem-carrinho">
                <?= htmlspecialchars($mensagemCarrinho, ENT_QUOTES, 'UTF-8') ?>
            </p>

        <?php endif; ?>

        <?php if (empty($carrinho)): ?>

            <section class="carrinho-vazio">

                <h2>Seu carrinho está vazio</h2>

                <p>
                    Explore nossos perfumes e encontre sua próxima
                    fragrância favorita!
                </p>

                <a href="<?= BASE_URL ?>/" class="btn-voltar">
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
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($carrinho as $id => $item): ?>

                            <?php

                            if (!is_array($item)) {
                                continue;
                            }

                            $nome = (string) ($item['nome'] ?? 'Produto');

                            $preco = max(
                                0,
                                (float) ($item['preco'] ?? 0)
                            );

                            $quantidade = max(
                                1,
                                (int) ($item['quantidade'] ?? 1)
                            );

                            $subtotal = round($preco * $quantidade, 2);

                            $imagem = caminhoImagemCarrinho(
                                $item['imagem'] ?? ''
                            );

                            $idProduto = (int) $id;

                            ?>

                            <tr>

                                <td class="produto">

                                    <img
                                        src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>"
                                        loading="lazy"
                                    >

                                    <span>
                                        <?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>
                                    </span>

                                </td>

                                <td>
                                    R$ <?= number_format($preco, 2, ',', '.') ?>
                                </td>

                                <td>

                                    <form
                                        action="<?= BASE_URL ?>/carrinho/atualizar"
                                        method="POST"
                                        class="form-quantidade"
                                    >

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

                                        <input
                                            type="number"
                                            name="quantidade"
                                            value="<?= $quantidade ?>"
                                            min="1"
                                            required
                                        >

                                        <button type="submit">
                                            Atualizar
                                        </button>

                                    </form>

                                </td>

                                <td>
                                    R$ <?= number_format($subtotal, 2, ',', '.') ?>
                                </td>

                                <td>

                                    <form
                                        action="<?= BASE_URL ?>/carrinho/remover"
                                        method="POST"
                                        onsubmit="return confirm('Deseja remover este produto do carrinho?');"
                                    >

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

                                        <button type="submit" class="btn-remover">
                                            Remover
                                        </button>

                                    </form>

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
                        action="<?= BASE_URL ?>/carrinho"
                        method="POST"
                    >

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars($tokenCsrf, ENT_QUOTES, 'UTF-8') ?>"
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
                            <?= htmlspecialchars($mensagemCupom, ENT_QUOTES, 'UTF-8') ?>
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
                            <?= number_format($percentualDesconto, 2, ',', '.') ?>%
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
                            R$ <?= number_format($totalGeral, 2, ',', '.') ?>
                        </p>

                        <?php if ($valorDesconto > 0): ?>

                            <p>
                                Desconto:
                                - R$ <?= number_format($valorDesconto, 2, ',', '.') ?>
                            </p>

                        <?php endif; ?>

                        <h3>
                            Total:
                            R$ <?= number_format($totalComDesconto, 2, ',', '.') ?>
                        </h3>

                    </div>

                    <div class="botoes">

                        <a
                            href="<?= BASE_URL ?>/"
                            class="btn-voltar"
                        >
                            Continuar comprando
                        </a>

                        <a
                            href="<?= BASE_URL ?>/finalizacao"
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
