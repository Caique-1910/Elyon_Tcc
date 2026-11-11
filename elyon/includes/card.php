<a
    href="/elyon/compra?id=<?= $produto['Idproduto'] ?>"
    class="card"
>
    <img
        class="img_card"
        src="/elyon/<?= htmlspecialchars($produto['Imagem']) ?>"
        alt="<?= htmlspecialchars($produto['Nome']) ?>"
    >

    <h2>
        <?= htmlspecialchars($produto['Nome']) ?>
    </h2>

    <p class="preco">
        R$ <?= number_format($produto['Preco'], 2, ',', '.') ?>
    </p>
</a>