
<div class="card-contato">

    <button
        type="button"
        class="card-cabecalho"
        aria-expanded="false">

        <h3><?= htmlspecialchars($card['titulo'], ENT_QUOTES, 'UTF-8') ?></h3>
        <span class="seta-contato">⌄</span>

    </button>

    <div class="card-info" hidden>
        <p><?= htmlspecialchars($card['descricao'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>

</div>
