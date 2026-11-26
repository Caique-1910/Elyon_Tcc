
<?php

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

<a
    href="<?= BASE_URL ?>/compra?id=<?= (int) $produto['Idproduto'] ?>"
    class="card"
>
    <img
        class="img_card"
        src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>"
        alt="<?= htmlspecialchars($produto['Nome'], ENT_QUOTES, 'UTF-8') ?>"
    >

    <h2>
        <?= htmlspecialchars($produto['Nome'], ENT_QUOTES, 'UTF-8') ?>
    </h2>

    <p class="preco">
        R$ <?= number_format((float) $produto['Preco'], 2, ',', '.') ?>
    </p>
</a>
