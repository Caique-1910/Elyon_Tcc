
<?php

$carrinho = $carrinho ?? ($_SESSION['carrinho'] ?? []);
$compraConcluida = $compraConcluida ?? false;

$cupomAplicado = $cupomAplicado ?? ($_SESSION['cupom'] ?? null);

// Prioriza a mensagem enviada pelo controller.
$mensagemFinalizacao = $mensagemFinalizacao ?? ($_SESSION['mensagem_finalizacao'] ?? '');

unset($_SESSION['mensagem_finalizacao']);

$totalGeral = 0;

foreach ($carrinho as $item) {
    $preco = max(0, (float) ($item['preco'] ?? 0));
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

$totalFinal = max(0, $totalGeral - $valorDesconto);

$valorFrete = 0;

if ($compraConcluida) {
    $totalGeral = (float) ($_SESSION['pedido_subtotal'] ?? 0);
    $valorDesconto = (float) ($_SESSION['pedido_desconto'] ?? 0);
    $totalFinal = (float) ($_SESSION['pedido_total'] ?? 0);
    $valorFrete = (float) ($_SESSION['pedido_frete'] ?? 0);
}

if (!function_exists('imagemFinalizacao')) {
    function imagemFinalizacao($imagem)
    {
        $imagem = trim((string) $imagem);

        if ($imagem === '') {
            return BASE_URL . '/assets/imgs/logoElyon1.png';
        }

        if (preg_match('/^https?:\/\//i', $imagem)) {
            return $imagem;
        }

        $imagem = preg_replace('/^(\.\.\/)+/', '', $imagem);

        return BASE_URL . '/' . ltrim($imagem, '/');
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Finalização - Elyon Perfumaria</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/finalizacao.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/footer.css">

    <script src="<?= BASE_URL ?>/assets/js/finalizacao.js" defer></script>
</head>

<body>

    <?php require_once __DIR__ . '/../../../includes/header.php'; ?>

    <main class="conteudo-finalizacao">

        <h1>Finalização</h1>

        <?php if ($compraConcluida): ?>

            <section class="finalizacao-vazia">

                <h2>Pedido realizado com sucesso!</h2>

                <p>
                    Obrigado por comprar na Elyon Perfumaria.
                    Seu pedido foi registrado.
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

                <p>
                    Frete:
                    R$ <?= number_format($valorFrete, 2, ',', '.') ?>
                </p>

                <h2>
                    Total:
                    R$ <?= number_format($totalFinal, 2, ',', '.') ?>
                </h2>

                <a href="<?= BASE_URL ?>/" class="btn-finalizacao">
                    Voltar para a página inicial
                </a>

            </section>

        <?php elseif (empty($carrinho)): ?>

            <section class="finalizacao-vazia">

                <h2>Seu carrinho está vazio</h2>

                <p>
                    Adicione produtos ao carrinho antes de finalizar o pedido.
                </p>

                <a href="<?= BASE_URL ?>/" class="btn-finalizacao">
                    Continuar comprando
                </a>

            </section>

        <?php else: ?>

            <?php if ($mensagemFinalizacao !== ''): ?>
                <p class="mensagem-finalizacao">
                    <?= htmlspecialchars(
                        $mensagemFinalizacao,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </p>
            <?php endif; ?>

            <div class="tabela-finalizacao-container">

                <table class="tabela-finalizacao">

                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Entrega</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($carrinho as $item): ?>

                            <?php
                            $nome = (string) ($item['nome'] ?? 'Produto');
                            $preco = max(0, (float) ($item['preco'] ?? 0));
                            $quantidade = max(1, (int) ($item['quantidade'] ?? 1));
                            $subtotal = $preco * $quantidade;
                            $imagem = imagemFinalizacao($item['imagem'] ?? '');
                            ?>

                            <tr>

                                <td class="produto-finalizacao">

                                    <img
                                        src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>"
                                    >

                                    <span>
                                        <?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>
                                    </span>

                                </td>

                                <td class="data-entrega">
                                    A definir
                                </td>

                                <td>
                                    R$ <?= number_format($preco, 2, ',', '.') ?>
                                </td>

                                <td>
                                    <?= $quantidade ?>
                                </td>

                                <td>
                                    R$ <?= number_format($subtotal, 2, ',', '.') ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <section class="cupom-finalizacao">

                <h2>Cupom aplicado</h2>

                <?php if (!empty($cupomAplicado['Codigo'])): ?>

                    <p>
                        Código:
                        <strong>
                            <?= htmlspecialchars(
                                $cupomAplicado['Codigo'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </strong>
                    </p>

                    <p>
                        Desconto:
                        <?= number_format($percentualDesconto, 2, ',', '.') ?>%
                    </p>

                <?php else: ?>

                    <p>Nenhum cupom aplicado.</p>

                    <a href="<?= BASE_URL ?>/carrinho">
                        Voltar ao carrinho para aplicar um cupom.
                    </a>

                <?php endif; ?>

            </section>

            <form
                action="<?= BASE_URL ?>/finalizacao/confirmar"
                method="POST"
                class="form-finalizacao"
            >

                <input
                    type="hidden"
                    name="token_confirmacao"
                    value="<?= htmlspecialchars(
                        $_SESSION['token_confirmacao'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >

                <section class="opcoes-finalizacao">

                    <div class="opcao-card">

                        <h2>Forma de pagamento</h2>

                        <label>
                            <input
                                type="radio"
                                name="pagamento"
                                value="pix"
                                required
                            >
                            Pix
                        </label>

                        <label>
                            <input
                                type="radio"
                                name="pagamento"
                                value="cartao"
                            >
                            Cartão
                        </label>

                        <label>
                            <input
                                type="radio"
                                name="pagamento"
                                value="boleto"
                            >
                            Boleto
                        </label>

                    </div>

                    <div class="opcao-card">

                        <h2>Opção de frete</h2>

                        <label>
                            <input
                                type="radio"
                                name="frete"
                                value="normal"
                                required
                            >
                            Entrega normal — R$ 10,00
                        </label>

                        <label>
                            <input
                                type="radio"
                                name="frete"
                                value="expresso"
                            >
                            Entrega expressa — R$ 20,00
                        </label>

                    </div>

                </section>

                <section class="resumo-finalizacao">

                    <h2>Resumo do pedido</h2>

                    <p>
                        <span>Subtotal:</span>
                        <strong>
                            R$ <?= number_format($totalGeral, 2, ',', '.') ?>
                        </strong>
                    </p>

                    <p>
                        <span>Desconto:</span>
                        <strong id="valor-desconto">
                            - R$ <?= number_format($valorDesconto, 2, ',', '.') ?>
                        </strong>
                    </p>

                    <p>
                        <span>Frete:</span>
                        <strong id="valor-frete">
                            Selecione uma entrega
                        </strong>
                    </p>

                    <h2>
                        Total:
                        <strong
                            id="total-final"
                            data-subtotal="<?= number_format($totalGeral, 2, '.', '') ?>"
                            data-desconto="<?= number_format($valorDesconto, 2, '.', '') ?>"
                        >
                            R$ <?= number_format($totalFinal, 2, ',', '.') ?>
                        </strong>
                    </h2>

                </section>

                <div class="botoes-finalizacao">

                    <a
                        href="<?= BASE_URL ?>/carrinho"
                        class="btn-finalizacao"
                    >
                        Voltar ao carrinho
                    </a>

                    <button
                        type="submit"
                        class="btn-finalizar-pedido"
                    >
                        Confirmar pedido
                    </button>

                </div>

            </form>

        <?php endif; ?>

    </main>

    <?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

</body>
</html>
