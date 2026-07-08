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