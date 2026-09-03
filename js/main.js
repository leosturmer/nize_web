import {
  inicializarSidebar,
  inicializarHeaderMobile,
  abrirSidebarLoja,
} from "./modules/sidebar.js";
import { sessionMsg } from "./modules/session_msg.js";
import {
  verificarTamanhoImagem,
  gerenciarCheckboxesVeC,
  checkboxVendido,
  fecharFiltro,
} from "./modules/inputs.js";
import { scrollTop, navbarScroll } from "./modules/scroll.js";
import { initLocalStorageManager } from "./modules/localStorageManager.js";

document.addEventListener("DOMContentLoaded", () => {
  // Sidebar
  if (document.getElementById("sidebar")) {
    inicializarSidebar();
  }
  if (document.getElementById("header-mobile")) {
    inicializarHeaderMobile();
  }

  if (document.getElementById("total-compra")) {
    abrirSidebarLoja();
  }

  // Fechar sidebar

  // Mensagem da sessão
  if (document.getElementById("session-msg")) {
    sessionMsg();
  }

  // Input
  // Tamanho da imagem
  if (document.getElementById("imagemProduto")) {
    verificarTamanhoImagem();
  }

  // Checkbox Vendido e Checkbox Cancelado
  if (
    document.getElementById("containerVendido") &&
    document.getElementById("containerCancelado")
  ) {
    gerenciarCheckboxesVeC();
  }

  // Checkbox Vendido

  if (document.getElementById("containerVendido")) {
    checkboxVendido();
  }

  // Fechar o filtro ao clicar fora
  if (document.querySelector("details.filtros-produtos")) {
    fecharFiltro();
  }

  if (document.getElementById("scrollTop")) {
    scrollTop();
  }

  if (document.querySelector("#header-mobile")) {
    navbarScroll();
  }

  initLocalStorageManager();
});
