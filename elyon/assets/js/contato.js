
document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".card-contato");

    cards.forEach(function (card) {
        const botao = card.querySelector(".card-cabecalho");
        const conteudo = card.querySelector(".card-info");

        botao.addEventListener("click", function () {
            const deveAbrir = conteudo.hidden;

            cards.forEach(function (outroCard) {
                const outroBotao = outroCard.querySelector(".card-cabecalho");
                const outroConteudo = outroCard.querySelector(".card-info");

                outroConteudo.hidden = true;
                outroCard.classList.remove("aberto");
                outroBotao.setAttribute("aria-expanded", "false");
            });

            if (deveAbrir) {
                conteudo.hidden = false;
                card.classList.add("aberto");
                botao.setAttribute("aria-expanded", "true");
            }
        });
    });
});
