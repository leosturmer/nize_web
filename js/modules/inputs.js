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
        alert(
          "Atenção: Se você salvar este pedido como CANCELADO, ele não poderá mais ser editado!"
        );
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
    statusPedido.addEventListener("change", function () {
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

export function fecharFiltro() {
  document.addEventListener("click", function (event) {
    const details = document.querySelector("details.filtros-produtos");

    if (details && details.open && !details.contains(event.target)) {
      details.removeAttribute("open"); // Fecha o details
    }
  });
}

export function guardarPedido() {
  // Delegação de evento no document usando fase de captura (true)
  document.addEventListener(
    "submit",
    function (event) {
      // Verifica se o formulário submetido possui a classe do produto
      const form = event.target.closest(".form-add-produto");
      if (!form) return;

      const elPrazo = document.getElementById("prazoPedido");
      const elStatus = document.getElementById("statusPedido");
      const elComentario = document.getElementById("comentarioPedido");

      const hdnPrazo = form.querySelector(".hdn-prazo");
      const hdnStatus = form.querySelector(".hdn-status");
      const hdnComentario = form.querySelector(".hdn-comentario");

      if (hdnPrazo && elPrazo) hdnPrazo.value = elPrazo.value;
      if (hdnStatus && elStatus) hdnStatus.value = elStatus.value;
      if (hdnComentario && elComentario)
        hdnComentario.value = elComentario.value;
    },
    true
  ); // O 'true' ativa o modo de captura, garantindo a execução antes do envio
}

export function guardarSacola() {
  document.addEventListener(
    "submit",
    function (event) {
      const form = event.target.closest(".form-add-sacola");
      if (!form) return;

      const elNome = document.getElementById("nomeCliente");
      const elTel = document.getElementById("telefoneCliente");
      const elMsg = document.getElementById("mensagemCliente");

      const hdnNome = form.querySelector(".hdn-nome-cliente");
      const hdnTel = form.querySelector(".hdn-tel-cliente");
      const hdnMsg = form.querySelector(".hdn-msg-cliente");

      if (hdnNome && elNome) hdnNome.value = elNome.value;
      if (hdnTel && elTel) hdnTel.value = elTel.value;
      if (hdnMsg && elMsg) hdnMsg.value = elMsg.value;
    },
    true
  );
}
