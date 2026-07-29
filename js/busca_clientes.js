document.addEventListener("DOMContentLoaded", function () {
  const pesquisaClientes = document.getElementById("pesquisa-clientes");
  // const filtroEstoque = document.getElementById('filtro-nome');
  // const filtroEncomenda = document.getElementById('filtro-encomenda');
  const filtroOrder = document.getElementById("filtro-order");
  const btnLimpar = document.getElementById("btn-limpar-filtros"); // Captura o novo botão
  const listaClientes = document.querySelector(".lista_usuarios_cadastrados");

  let temporizador;

  function executarBusca() {
    let termo = pesquisaClientes ? pesquisaClientes.value : "";
    // let estoque = filtroEstoque ? filtroEstoque.value : '';
    // let encomenda = filtroEncomenda ? filtroEncomenda.value : '';
    let order = filtroOrder ? filtroOrder.value : "";

    // Captura o ID da loja se ele estiver presente na URL da página atual
    const urlParams = new URLSearchParams(window.location.search);
    // const idLoja = urlParams.get('id');

    // const nome_loja = urlParams.get('loja');

    clearTimeout(temporizador);

    temporizador = setTimeout(() => {
      let url = "";

      // Se houver idLoja na URL, significa que estamos na view_loja.php (pública)

      // Caso contrário, mantém o fluxo antigo da área interna (produtos)
      url = `busca_clientes_ajax.php?pesquisaCliente=${encodeURIComponent(
        termo
      )}&ordenarPor=${encodeURIComponent(order)}`;

      fetch(url)
        .then((response) => {
          if (!response.ok) throw new Error("Erro na resposta do servidor");
          return response.text();
        })
        .then((html) => {
          listaProdutos.innerHTML = html;
        })
        .catch((erro) => {
          console.error("Erro na busca:", erro);
          listaProdutos.innerHTML =
            '<h4 class="sem-registro">Erro ao processar a busca.</h4>';
        });
    }, 250);
  }

  if (listaProdutos) {
    if (pesquisaClientes) {
      pesquisaProdutos.addEventListener("input", executarBusca);
    }
    if (filtroOrder) {
      filtroOrder.addEventListener("change", executarBusca);
    }

    // Ação do botão de limpar filtros
    if (btnLimpar) {
      btnLimpar.addEventListener("click", function () {
        if (pesquisaClientes) pesquisaClientes.value = ""; // Limpa o texto
        if (filtroOrder) filtroOrder.value = "";

        executarBusca(); // Recarrega a lista completa
      });
    }
  } else {
    console.error("Elementos de busca não foram encontrados no DOM.");
  }
});
