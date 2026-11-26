
document.addEventListener("DOMContentLoaded", () => {
    const opcoesFrete = document.querySelectorAll(
        'input[name="frete"]'
    );

    const elementoFrete = document.getElementById("valor-frete");
    const elementoTotal = document.getElementById("total-final");

    if (!opcoesFrete.length || !elementoFrete || !elementoTotal) {
        return;
    }

    const subtotal = Number(elementoTotal.dataset.subtotal);
    const desconto = Number(elementoTotal.dataset.desconto);

    const valoresFrete = {
        normal: 10,
        expresso: 20
    };

    function formatarMoeda(valor) {
        return valor.toLocaleString("pt-BR", {
            style: "currency",
            currency: "BRL"
        });
    }

    function atualizarResumo() {
        const selecionado = document.querySelector(
            'input[name="frete"]:checked'
        );

        if (!selecionado) {
            elementoFrete.textContent = "Selecione uma entrega";

            elementoTotal.textContent = formatarMoeda(
                Math.max(0, subtotal - desconto)
            );

            return;
        }

        const frete = valoresFrete[selecionado.value];

        if (frete === undefined) {
            return;
        }

        const total = Math.max(0, subtotal - desconto + frete);

        elementoFrete.textContent = formatarMoeda(frete);
        elementoTotal.textContent = formatarMoeda(total);
    }

    opcoesFrete.forEach(opcao => {
        opcao.addEventListener("change", atualizarResumo);
    });

    atualizarResumo();
});
