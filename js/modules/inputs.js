export function verificarTamanhoImagem() {
  document
    .getElementById("imagemProduto")
    .addEventListener("change", function () {
      if (this.files && this.files[0]) {
        const tamanhoArquivo = this.files[0].size;
        const limiteMaximo = 2 * 1024 * 1024;
        if (tamanhoArquivo > limiteMaximo) {
          alert(
            "A imagem escolhida é muito grande! O tamanho máximo permitido é de 2 MB."
          );
          this.value = "";
        }
      }
    });
}

export function gerenciarCheckboxesVeC() {
  const containerVendido = document.getElementById("containerVendido");
  const containerCancelado = document.getElementById("containerCancelado");

  function gerenciarCheckboxes() {
    const valorSelecionado = statusPedido.value;

    if (valorSelecionado === "vendido") {
      containerVendido.style.display = "block"; // Mostra o de venda
      containerCancelado.style.display = "none"; // Esconde o de cancelamento
    } else if (valorSelecionado === "cancelado") {
      containerVendido.style.display = "none"; // Esconde o de venda
      containerCancelado.style.display = "block"; // Mostra o de cancelamento
    } else {
      containerVendido.style.display = "none";
      containerCancelado.style.display = "none";
    }
  }

  gerenciarCheckboxes();
}

export function checkboxVendido() {
  const statusPedido = document.getElementById("statusPedido");
            const containerVendido = document.getElementById("containerVendido");

            function gerenciarCheckboxes() {
                const valorSelecionado = statusPedido.value;

                if (valorSelecionado === "vendido") {
                    containerVendido.style.display = "block"; // Mostra o de venda
                } else {
                    containerVendido.style.display = "none";
                    document.getElementById("darBaixaEstoque").checked = false;

                }
            }

            statusPedido.addEventListener("change", gerenciarCheckboxes);
            gerenciarCheckboxes();
}

