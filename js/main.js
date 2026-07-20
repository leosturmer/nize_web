import { inicializarSidebar } from "./modules/sidebar.js";
import { inicializarHeaderMobile } from "./modules/sidebar.js";
import { sessionMsg } from "./modules/session_msg.js";
import { verificarTamanhoImagem } from "./modules/inputs.js";
import { gerenciarCheckboxesVeC } from "./modules/inputs.js";
import { checkboxVendido } from "./modules/inputs.js";
import { fecharFiltro } from "./modules/inputs.js";

document.addEventListener("DOMContentLoaded", () => {
  // Sidebar
  if (document.getElementById("sidebar")) {
    inicializarSidebar();
  }
  if (document.getElementById("header-mobile")) {
    inicializarHeaderMobile();
  }

  // Fechar sidebar
  

  // Mensagem da sessão
  if (document.getElementById('session-msg')){
    sessionMsg();
  }

  // Input
  // Tamanho da imagem
  if (document.getElementById('imagemProduto')) {
    verificarTamanhoImagem();
  }

  // Checkbox Vendido e Checkbox Cancelado
  if (document.getElementById("containerVendido") && document.getElementById("containerCancelado")) {
    gerenciarCheckboxesVeC();
  }

  // Checkbox Vendido

  if (document.getElementById("containerVendido")) {
    checkboxVendido();
  }

  // Fechar o filtro ao clicar fora
  if (document.querySelector('details.filtros-produtos')) {
    fecharFiltro();
  }


});
