document.addEventListener("DOMContentLoaded", function () {
  const pesquisaUsuario = document.getElementById("pesquisa-usuarios");
  const filtroOrder = document.getElementById("filtro-order");
  const btnLimpar = document.getElementById("btn-limpar-filtros");
  const listaUsuario = document.getElementById("lista_usuarios_cadastrados");

  let temporizador;

  function executarBusca() {
    const termo = pesquisaUsuario ? pesquisaUsuario.value.trim() : "";
    const order = filtroOrder ? filtroOrder.value : "";

    clearTimeout(temporizador);

    temporizador = setTimeout(() => {
      const url = `busca_usuario_ajax.php?pesquisaUsuario=${encodeURIComponent(
        termo
      )}&ordenarPor=${encodeURIComponent(order)}`;

      fetch(url)
        .then((response) => {
          if (!response.ok) throw new Error("Erro na resposta do servidor");
          return response.text();
        })
        .then((html) => {
          if (listaUsuario) {
            listaUsuario.innerHTML = html;
          }
        })
        .catch((erro) => {
          console.error("Erro na busca:", erro);
          if (listaUsuario) {
            listaUsuario.innerHTML =
              '<h4 class="sem-registro">Erro ao processar a busca.</h4>';
          }
        });
    }, 250);
  }

  if (listaUsuario) {
    if (pesquisaUsuario) {
      pesquisaUsuario.addEventListener("input", executarBusca);
    }
    if (filtroOrder) {
      filtroOrder.addEventListener("change", executarBusca);
    }

    if (btnLimpar) {
      btnLimpar.addEventListener("click", function () {
        if (pesquisaUsuario) pesquisaUsuario.value = "";
        if (filtroOrder) filtroOrder.value = "";

        executarBusca();
      });
    }
  } else {
    console.error("Elementos de busca não foram encontrados no DOM.");
  }
});
