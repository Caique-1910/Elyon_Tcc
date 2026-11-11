
document.addEventListener("DOMContentLoaded", function () {
    const carrossel = document.querySelector("#banner.carrossel");

    if (!carrossel) return;

    const slides = carrossel.querySelectorAll(".slide");
    const indicadores = carrossel.querySelectorAll(".indicador");
    const anterior = carrossel.querySelector(".seta-anterior");
    const proxima = carrossel.querySelector(".seta-proxima");

    if (!slides.length) return;

    let indiceAtual = 0;
    let temporizador;


    function mostrarSlide(indice) {
        slides.forEach(slide => slide.classList.remove("ativo"));
        indicadores.forEach(botao => botao.classList.remove("ativo"));

        indiceAtual = (indice + slides.length) % slides.length;

        slides[indiceAtual].classList.add("ativo");
        indicadores[indiceAtual]?.classList.add("ativo");
    }


    function iniciarTemporizador() {
        clearInterval(temporizador);

        temporizador = setInterval(function () {
            mostrarSlide(indiceAtual + 1);
        }, 5000);
    }

    if (proxima) {
        proxima.addEventListener("click", function () {
            mostrarSlide(indiceAtual + 1);
            iniciarTemporizador();
        });
    }

    if (anterior) {
        anterior.addEventListener("click", function () {
            mostrarSlide(indiceAtual - 1);
            iniciarTemporizador();
        });
    }

    indicadores.forEach(function (botao, indice) {
        botao.addEventListener("click", function () {
            mostrarSlide(indice);
            iniciarTemporizador();
        });
    });

    mostrarSlide(0);
    iniciarTemporizador();
});
