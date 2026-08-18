1. cadastro_produtos.php (Adicionar a div do botão no HTML)Adicione a <div> com o botão da calculadora onde preferir na página (pode ser logo antes do <footer> ou do <script>):  HTML    <!-- Botão da Calculadora (Quando presente na página, ativa a calculadora) -->
    <div id="container-calculadora"
    style="position: fixed; bottom: 50px; right: 30px; z-index: 9999; ">
        <button type="button" class="calc-fab" id="calc-open-fab" 
        style="width: fit-content; background-color: var(--lightGreen); box-shadow: none; background-color: transparent; border: none; "
        >
            <span class="bi bi-calculator" 
            style="font-size: 30px; color: var(--darkGreen); padding: 0; margin: 0 5px; "
            ></span>
        </button>
    </div>


2. main.js (Verificação antes de inicializar)

No main.js, adicionamos a checagem com if para garantir que initCalculadora() só seja executado se o botão/div existir na página atual:  JavaScriptimport { inicializarSidebar, inicializarHeaderMobile } from "./modules/sidebar.js";
import { sessionMsg } from "./modules/session_msg.js";
import { verificarTamanhoImagem, gerenciarCheckboxesVeC, checkboxVendido, fecharFiltro } from "./modules/inputs.js";
import { initCalculadora } from "./modules/calculadora.js";

document.addEventListener("DOMContentLoaded", () => {
  // Ativa a calculadora APENAS se o botão existir na página atual
  if (document.getElementById("calc-open-fab") || document.getElementById("container-calculadora")) {
    initCalculadora();
  }

  // Sidebar
  if (document.getElementById("sidebar")) {
    inicializarSidebar();
  }
  if (document.getElementById("header-mobile")) {
    inicializarHeaderMobile();
  }

  // Mensagem da sessão
  if (document.getElementById('session-msg')){
    sessionMsg();
  }

  // Input - Tamanho da imagem
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
3. calculadora.js (Injeta apenas a Modal)Como o botão já está no HTML da página, removemos o botão da string calculadoraHTML para que a função injete apenas a janela modal overlay no final do <body>:  JavaScript/**
 * Módulo Principal da Calculadora Flutuante
 */

let modoAtual = 'artesanato';

// HTML APENAS do Modal Overlay (o botão já está no HTML da página)
const modalHTML = `
    <div class="calc-modal-overlay hidden" id="calc-modal">
        <div class="calc-container">
            <div class="calc-header">
                <h2>Calculadora de Precificação</h2>
                <button type="button" class="calc-close-btn" id="calc-close-btn">&times;</button>
            </div>

            <!-- Abas -->
            <div class="calc-tabs">
                <button type="button" class="tab-btn active" id="btn-artesanato">🎨 Artesanato</button>
                <button type="button" class="tab-btn" id="btn-revenda">🏷️ Revenda</button>
            </div>

            <!-- Formulário -->
            <form id="calcForm" onsubmit="event.preventDefault();">
                <div class="form-group">
                    <label for="calc_valor_original" id="lbl_valor_original">Valor Compra Material/Lote:</label>
                    <div class="input-wrapper">
                        <span class="prefix">R$</span>
                        <input type="number" id="calc_valor_original" class="has-prefix" step="0.01" placeholder="0,00">
                    </div>
                </div>

                <div id="campos-artesanato">
                    <div class="form-group">
                        <label for="calc_peso_original">Peso Original do Material:</label>
                        <div class="input-wrapper">
                            <input type="number" id="calc_peso_original" class="has-suffix" step="0.01" placeholder="Ex: 500">
                            <span class="suffix">g</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="calc_peso_peca">Peso Usado na Peça:</label>
                        <div class="input-wrapper">
                            <input type="number" id="calc_peso_peca" class="has-suffix" step="0.01" placeholder="Ex: 120">
                            <span class="suffix">g</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="calc_lucro">Margem de Lucro <span class="optional-tag">(Opcional)</span>:</label>
                    <div class="input-wrapper">
                        <input type="number" id="calc_lucro" class="has-suffix" step="0.1" placeholder="Ex: 100">
                        <span class="suffix">%</span>
                    </div>
                </div>
            </form>

            <!-- Painel de Resultado -->
            <div class="calc-resultado">
                <h3>Resumo da Precificação</h3>
                <div class="row-info">
                    <span>Custo da peça:</span>
                    <strong id="res-custo">R$ 0,00</strong>
                </div>
                <div class="row-info" id="row-sobra">
                    <span>Sobra de material:</span>
                    <strong id="res-sobra">0 g (R$ 0,00)</strong>
                </div>
                <div class="row-info destaque">
                    <span>Preço Final de Venda:</span>
                    <strong id="res-venda">R$ 0,00</strong>
                </div>
            </div>
        </div>
    </div>
`;

export function initCalculadora() {
    const btnOpen = document.getElementById('calc-open-fab');
    if (!btnOpen) return; // Trava de segurança extra

    // Injeta a janela modal no final do body se ainda não existir
    if (!document.getElementById('calc-modal')) {
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    const modal = document.getElementById('calc-modal');
    const btnClose = document.getElementById('calc-close-btn');
    const btnArtesanato = document.getElementById('btn-artesanato');
    const btnRevenda = document.getElementById('btn-revenda');

    // Eventos de abrir e fechar
    btnOpen.addEventListener('click', () => modal.classList.remove('hidden'));
    btnClose.addEventListener('click', () => modal.classList.add('hidden'));

    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.add('hidden');
    });

    // Eventos das abas
    btnArtesanato.addEventListener('click', () => setModo('artesanato'));
    btnRevenda.addEventListener('click', () => setModo('revenda'));

    // Reatividade dos inputs
    const inputs = ['calc_valor_original', 'calc_peso_original', 'calc_peso_peca', 'calc_lucro'];
    inputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', calcular);
    });

    calcular();
}

export function setModo(modo) {
    modoAtual = modo;

    document.getElementById('btn-artesanato').classList.toggle('active', modo === 'artesanato');
    document.getElementById('btn-revenda').classList.toggle('active', modo === 'revenda');

    const camposArtesanato = document.getElementById('campos-artesanato');
    const rowSobra = document.getElementById('row-sobra');
    const lblValor = document.getElementById('lbl_valor_original');

    if (modo === 'artesanato') {
        camposArtesanato.classList.remove('hidden');
        rowSobra.classList.remove('hidden');
        lblValor.innerText = "Valor Compra Material/Lote:";
    } else {
        camposArtesanato.classList.add('hidden');
        rowSobra.classList.add('hidden');
        lblValor.innerText = "Valor de Compra do Produto:";
    }

    calcular();
}

export function calcular() {
    const valorOrig = parseFloat(document.getElementById('calc_valor_original').value) || 0;
    const pesoOrig  = parseFloat(document.getElementById('calc_peso_original').value) || 0;
    const pesoPeca  = parseFloat(document.getElementById('calc_peso_peca').value) || 0;
    const lucroPorc = parseFloat(document.getElementById('calc_lucro').value) || 0;

    let custoPeca = 0;
    let valorVenda = 0;
    let pesoSobra = 0;
    let custoSobra = 0;

    if (modoAtual === 'artesanato') {
        if (pesoOrig > 0 && pesoPeca > 0 && valorOrig > 0) {
            const custoPorGrama = valorOrig / pesoOrig;
            custoPeca = pesoPeca * custoPorGrama;
            pesoSobra = Math.max(0, pesoOrig - pesoPeca);
            custoSobra = pesoSobra * custoPorGrama;
            valorVenda = custoPeca * (1 + (lucroPorc / 100));
        }
    } else {
        if (valorOrig > 0) {
            custoPeca = valorOrig;
            valorVenda = custoPeca * (1 + (lucroPorc / 100));
        }
    }

    const fmtMoeda = (val) => val.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    const fmtNum   = (val) => val.toLocaleString('pt-BR', { minimumFractionDigits: 0, maximumFractionDigits: 2 });

    document.getElementById('res-custo').innerText = fmtMoeda(custoPeca);
    document.getElementById('res-sobra').innerText = `${fmtNum(pesoSobra)} g (${fmtMoeda(custoSobra)})`;
    document.getElementById('res-venda').innerText = fmtMoeda(valorVenda);
}