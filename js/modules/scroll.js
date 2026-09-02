export function scrollTop() {
  const scrollBtn = document.getElementById("scrollTop");
  const container = document.querySelector(".conteudo-pagina");
  const btnWpp = document.querySelector(".div-btn-wpp");

  if (!container || !scrollBtn) return;

  container.addEventListener("scroll", function () {
    if (container.scrollTop > 100) {
      scrollBtn.style.visibility = "visible";
      btnWpp.style.bottom = "80px";
    } else {
      scrollBtn.style.visibility = "hidden";
      btnWpp.style.bottom = "20px";
    }
  });
}

export function navbarScroll() {
  const conteudoPagina = document.querySelector(".conteudo-pagina");
  const headerMobile = document.querySelector("#header-mobile");
  const summaryPedidos = document.querySelector(".summary-pedido");

  let scrollAnterior = 0;

  conteudoPagina.addEventListener("scroll", function () {
    let scrollAtual = conteudoPagina.scrollTop;

    if (scrollAtual > scrollAnterior && scrollAtual > 50) {
      headerMobile.classList.add("header-hidden");
      conteudoPagina.style.marginTop = "0px";
      summaryPedidos.style.top = "10px";
    } else {
      headerMobile.classList.remove("header-hidden");
      if (window.innerWidth > 1280) {
        conteudoPagina.style.marginTop = "0";
        summaryPedidos.style.top = "5.5em";
      } else {
        conteudoPagina.style.marginTop = "4em";
        summaryPedidos.style.top = "5.5em";

      }
    }

    scrollAnterior = scrollAtual;
  });
}
