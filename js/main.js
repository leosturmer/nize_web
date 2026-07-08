import { inicializarSidebar } from "./modules/sidebar.js";
import { gerenciarCheckboxesVeC } from "./modules/checkboxes.js";
import { sessionMsg } from "./modules/session_msg.js";

document.addEventListener("DOMContentLoaded", () => {
  // Sidebar
  if (document.getElementById("sidebar")) {
    inicializarSidebar();
  }

  // Mensagem da sessão
  if (document.getElementById('session-msg')){
    sessionMsg();
  }

  // Checkboxes
  // Checbox Vendido e Checkbox Cancelado
  if (document.getElementById("containerVendido") && document.getElementById("containerCancelado")) {
    gerenciarCheckboxesVeC();
  }




});
