document.addEventListener("DOMContentLoaded", function () {
  const pesquisaUsuario = document.getElementById("pesquisa-usuarios");
  const filtroOrder = document.getElementById("filtro-order");
  const btnLimpar = document.getElementById("btn-limpar-filtros"); // Captura o novo botão
  const listaUsuario = document.querySelector(".lista_usuarios_cadastrados");

  let temporizador;

  function executarBusca() {
    let termo = pesquisaUsuario ? pesquisaUsuario.value : "";
    let order = filtroOrder ? filtroOrder.value : "";

    const urlParams = new URLSearchParams(window.location.search);

    clearTimeout(temporizador);

    temporizador = setTimeout(() => {
      let url = "";
      url = `busca_usuario_ajax.php?pesquisaUsuario=${encodeURIComponent(
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
    if (pesquisaUsuario) {
      pesquisaProdutos.addEventListener("input", executarBusca);
    }
    if (filtroOrder) {
      filtroOrder.addEventListener("change", executarBusca);
    }

    // Ação do botão de limpar filtros
    if (btnLimpar) {
      btnLimpar.addEventListener("click", function () {
        if (pesquisaUsuario) pesquisaUsuario.value = ""; // Limpa o texto
        if (filtroOrder) filtroOrder.value = "";

        executarBusca(); // Recarrega a lista completa
      });
    }
  } else {
    console.error("Elementos de busca não foram encontrados no DOM.");
  }
});
