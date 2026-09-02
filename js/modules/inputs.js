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
  const statusPedido = document.getElementById("statusPedido");
  const containerVendido = document.getElementById("containerVendido");
  const containerCancelado = document.getElementById("containerCancelado");

  if (!containerVendido || !containerCancelado) return;

  function gerenciar(origemDoClique = false) {
    const valorSelecionado = statusPedido ? statusPedido.value : "cancelado";

    if (valorSelecionado === "vendido") {
      containerVendido.style.display = "block";
      containerCancelado.style.display = "none";
    } else if (valorSelecionado === "cancelado") {
      containerVendido.style.display = "none";
      containerCancelado.style.display = "block";

      if (origemDoClique === true) {
        alert("Atenção: Se você salvar este pedido como CANCELADO, ele não poderá mais ser editado!");
      }
    } else {
      containerVendido.style.display = "none";
      containerCancelado.style.display = "none";
      
      const chkBaixa = document.getElementById("darBaixaEstoque");
      const chkEstorno = document.getElementById("estornarEstoque");
      if (chkBaixa) chkBaixa.checked = false;
      if (chkEstorno) chkEstorno.checked = false;
    }
  }

  if (statusPedido) {
    statusPedido.addEventListener("change", function() {
      gerenciar(true);
    });
  }

  gerenciar(false);
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

export function fecharFiltro () {
  document.addEventListener('click', function (event) {
  const details = document.querySelector('details.filtros-produtos');
  
  if (details && details.open && !details.contains(event.target)) {
    details.removeAttribute('open'); // Fecha o details
  }
});

}
