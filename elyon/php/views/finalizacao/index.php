
<?php

$carrinho = $carrinho ?? ($_SESSION['carrinho'] ?? []);
$totalGeral = 0;

foreach ($carrinho as $item) {
    $preco = max(0, (float) ($item['preco'] ?? 0));
    $quantidade = max(1, (int) ($item['quantidade'] ?? 1));

    $totalGeral += $preco * $quantidade;
}

if (!function_exists('imagemFinalizacao')) {
    function imagemFinalizacao($imagem)
    {
        $imagem = trim((string) $imagem);

        if ($imagem === '') {
            return '/Projeto_Elyon/assets/imgs/logoElyon1.png';
        }

        if (preg_match('/^(https?:\/\/|\/)/i', $imagem)) {
            return $imagem;
        }

        return '/Projeto_Elyon/' . ltrim($imagem, '/');
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Finalização - Elyon Perfumaria</title>

    <link rel="stylesheet" href="../../../assets/css/global.css">
    <link rel="stylesheet" href="../../../assets/css/finalizacao.css">
</head>

<body>

    <?php require_once __DIR__ . '/../../../includes/header.php'; ?>

    <main class="conteudo-finalizacao">

        <h1>Finalização</h1>

        <?php if (empty($carrinho)): ?>

            <section class="finalizacao-vazia">
                <h2>Seu carrinho está vazio</h2>

                <p>
                    Adicione produtos ao carrinho antes de finalizar o pedido.
                </p>

                <a href="/elyon/" class="btn-finalizacao">
                    Continuar comprando
                </a>
            </section>

        <?php else: ?>

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

            <form
                action="/elyon/finalizacao/confirmar"
                method="POST"
                class="form-finalizacao"
            >

                <section class="cupom-finalizacao">

                    <h2>Cupom</h2>

                    <input
                        type="text"
                        name="cupom"
                        placeholder="Digite o código do cupom"
                        maxlength="50"
                    >

                    <button type="button" class="btn-finalizacao" disabled>
                        Aplicar cupom
                    </button>

                </section>

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
                            Entrega normal
                        </label>

                        <label>
                            <input
                                type="radio"
                                name="frete"
                                value="expresso"
                            >
                            Entrega expressa
                        </label>

                    </div>

                </section>

                <section class="resumo-finalizacao">

                    <p>
                        Confira os produtos e escolha o pagamento e o frete.
                    </p>

                    <h2>
                        Total dos produtos:
                        R$ <?= number_format($totalGeral, 2, ',', '.') ?>
                    </h2>

                    <p>
                        O valor do frete será calculado conforme a opção escolhida.
                    </p>

                </section>

                <div class="botoes-finalizacao">

                    <a href="/elyon/carrinho" class="btn-finalizacao">
                        Voltar ao carrinho
                    </a>

                    <button type="submit" class="btn-finalizar-pedido">
                        Confirmar pedido
                    </button>

                </div>

            </form>

        <?php endif; ?>

    </main>

    <?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

</body>
</html>
