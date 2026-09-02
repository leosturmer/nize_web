function atualizarIcones() {
  const ativo = document.body.classList.contains("sb-expanded");
  
  const btnDesktop = document.querySelector("[data-resize-btn] i");

  if (btnDesktop) {
    const sacolaLoja = btnDesktop.classList.contains("bi-bag");
    btnDesktop.classList.toggle("bi-x-lg", ativo);
    btnDesktop.classList.toggle(sacolaLoja ? "bi-bag" : "bi-list", !ativo);
  }

  const btnMobile = document.querySelector("[data-resize-btn-mobile] i");
  if (btnMobile) {
    btnMobile.classList.toggle("bi-x-lg", ativo);
    btnMobile.classList.toggle("bi-list", !ativo);
  }
}

export function inicializarSidebar() {
  const resizeBtn = document.querySelector("[data-resize-btn]");
  if (!resizeBtn) return;
  resizeBtn.addEventListener("click", (e) => {
    e.preventDefault();
    document.body.classList.toggle("sb-expanded");
    atualizarIcones();
  });
}

export function inicializarHeaderMobile() {
  const resizeBtn = document.querySelector("[data-resize-btn-mobile]");
  if (!resizeBtn) return;

  resizeBtn.addEventListener("click", (e) => {
    e.preventDefault();
    document.body.classList.toggle("sb-expanded");
    atualizarIcones();
  });

}

export function abrirSidebarLoja() {
  const totalCompra = document.getElementById("total-compra");

  if (totalCompra.innerHTML !== "0,00") {
    document.body.classList.add("sb-expanded");
    atualizarIcones();
  }
}
