export function initLocalStorageManager() {
    const path = window.location.pathname;
    const referrer = document.referrer;

    // Função auxiliar para limpar dados se saiu do contexto da página
    function limparSeSaiu(prefixo, nomeArquivo) {
        if (!referrer.includes(nomeArquivo)) {
            // Remove todas as chaves que começam com o prefixo no localStorage
            Object.keys(localStorage).forEach(key => {
                if (key.startsWith(prefixo)) {
                    localStorage.removeItem(key);
                }
            });
        }
    }

    // 1. Página de Cadastro de Usuário
    if (path.includes("cadastro_usuario.php")) {
        limparSeSaiu("cad_", "cadastro_usuario.php");

        const campoNome = document.querySelector("input[name='usuNome']");
        const campoLoja = document.querySelector("input[name='usuLoja']");
        const campoEmail = document.querySelector("input[name='usuEmail']");
        const linkLogin = document.getElementById("btn-login");
        const btnLimpar = document.querySelector("button[type='reset'], .btn-limpar");

        if (localStorage.getItem("cad_nome") && campoNome) campoNome.value = localStorage.getItem("cad_nome");
        if (localStorage.getItem("cad_loja") && campoLoja) campoLoja.value = localStorage.getItem("cad_loja");
        if (localStorage.getItem("cad_email") && campoEmail) campoEmail.value = localStorage.getItem("cad_email");

        if (campoNome) campoNome.addEventListener("input", () => localStorage.setItem("cad_nome", campoNome.value));
        if (campoLoja) campoLoja.addEventListener("input", () => localStorage.setItem("cad_loja", campoLoja.value));
        if (campoEmail) campoEmail.addEventListener("input", () => localStorage.setItem("cad_email", campoEmail.value));

        const limparTudo = () => {
            localStorage.removeItem("cad_nome");
            localStorage.removeItem("cad_loja");
            localStorage.removeItem("cad_email");
        };

        if (linkLogin) linkLogin.addEventListener("click", limparTudo);
        if (btnLimpar) btnLimpar.addEventListener("click", limparTudo);
    }

    // 2. Página de Duplicar Pedido
    if (path.includes("duplicar_pedidos.php")) {
        limparSeSaiu("dup_", "duplicar_pedidos.php");

        const campoData = document.getElementById("prazoPedido");
        const campoStatus = document.getElementById("statusPedido");
        const campoComentario = document.getElementById("comentarioPedido");
        const formPedido = document.querySelector("form[action*='cadastrar']");
        const btnLimpar = document.querySelector("button[type='reset'], .btn-limpar");

        if (localStorage.getItem("dup_prazo") && campoData) campoData.value = localStorage.getItem("dup_prazo");
        if (localStorage.getItem("dup_status") && campoStatus) campoStatus.value = localStorage.getItem("dup_status");
        if (localStorage.getItem("dup_comentario") && campoComentario) campoComentario.value = localStorage.getItem("dup_comentario");

        if (campoData) campoData.addEventListener("input", () => localStorage.setItem("dup_prazo", campoData.value));
        if (campoStatus) campoStatus.addEventListener("change", () => localStorage.setItem("dup_status", campoStatus.value));
        if (campoComentario) campoComentario.addEventListener("input", () => localStorage.setItem("dup_comentario", campoComentario.value));

        const limparTudo = () => {
            localStorage.removeItem("dup_prazo");
            localStorage.removeItem("dup_status");
            localStorage.removeItem("dup_comentario");
        };

        if (formPedido) formPedido.addEventListener("submit", limparTudo);
        if (btnLimpar) btnLimpar.addEventListener("click", limparTudo);
    }

    // 3. Página de Alteração de Pedido
    if (path.includes("alteracao_pedidos.php")) {
        limparSeSaiu("alt_", "alteracao_pedidos.php");

        const campoData = document.getElementById("prazoPedido");
        const campoStatus = document.getElementById("statusPedido");
        const campoComentario = document.getElementById("comentarioPedido");
        const formPedido = document.querySelector("form[action*='alterar']");
        const btnLimpar = document.querySelector("button[type='reset'], .btn-limpar");

        if (localStorage.getItem("alt_prazo") && campoData) campoData.value = localStorage.getItem("alt_prazo");
        if (localStorage.getItem("alt_status") && campoStatus) campoStatus.value = localStorage.getItem("alt_status");
        if (localStorage.getItem("alt_comentario") && campoComentario) campoComentario.value = localStorage.getItem("alt_comentario");

        if (campoData) campoData.addEventListener("input", () => localStorage.setItem("alt_prazo", campoData.value));
        if (campoStatus) campoStatus.addEventListener("change", () => localStorage.setItem("alt_status", campoStatus.value));
        if (campoComentario) campoComentario.addEventListener("input", () => localStorage.setItem("alt_comentario", campoComentario.value));

        const limparTudo = () => {
            localStorage.removeItem("alt_prazo");
            localStorage.removeItem("alt_status");
            localStorage.removeItem("alt_comentario");
        };

        if (formPedido) formPedido.addEventListener("submit", limparTudo);
        if (btnLimpar) btnLimpar.addEventListener("click", limparTudo);
    }

    // 4. Página de Cadastro de Pedido
    if (path.includes("cadastro_pedidos.php")) {
        limparSeSaiu("cad_pedido_", "cadastro_pedidos.php"); // Prefixo ajustado para evitar conflito

        const campoData = document.getElementById("prazoPedido");
        const campoStatus = document.getElementById("statusPedido");
        const campoComentario = document.getElementById("comentarioPedido");
        const formPedido = document.querySelector("form[action*='cadastrar']");
        const btnLimpar = document.querySelector("button[type='reset'], .btn-limpar");

        if (localStorage.getItem("cad_pedido_prazo") && campoData) campoData.value = localStorage.getItem("cad_pedido_prazo");
        if (localStorage.getItem("cad_pedido_status") && campoStatus) campoStatus.value = localStorage.getItem("cad_pedido_status");
        if (localStorage.getItem("cad_pedido_comentario") && campoComentario) campoComentario.value = localStorage.getItem("cad_pedido_comentario");

        if (campoData) campoData.addEventListener("input", () => localStorage.setItem("cad_pedido_prazo", campoData.value));
        if (campoStatus) campoStatus.addEventListener("change", () => localStorage.setItem("cad_pedido_status", campoStatus.value));
        if (campoComentario) campoComentario.addEventListener("input", () => localStorage.setItem("cad_pedido_comentario", campoComentario.value));

        const limparTudo = () => {
            localStorage.removeItem("cad_pedido_prazo");
            localStorage.removeItem("cad_pedido_status");
            localStorage.removeItem("cad_pedido_comentario");
        };

        if (formPedido) formPedido.addEventListener("submit", limparTudo);
        if (btnLimpar) btnLimpar.addEventListener("click", limparTudo);
    }

    // 5. Página de Visualização da Loja (view_loja.php)
    if (path.includes("view_loja.php")) {
        const chaveLoja = "loja_" + window.location.search;
        if (!referrer.includes("view_loja.php")) {
            Object.keys(localStorage).forEach(key => {
                if (key.startsWith("loja_")) localStorage.removeItem(key);
            });
        }

        const campoNome = document.querySelector("input[name='nomeCliente']");
        const campoTelefone = document.querySelector("input[name='telefoneCliente']");
        const campoMensagem = document.getElementById("mensagemCliente");
        const formSolicitacao = document.querySelector("form[action*='solicitarPedido']");
        const btnLimpar = document.querySelector("button[type='reset'], .btn-limpar");

        if (localStorage.getItem(chaveLoja + "_nome") && campoNome) campoNome.value = localStorage.getItem(chaveLoja + "_nome");
        if (localStorage.getItem(chaveLoja + "_telefone") && campoTelefone) campoTelefone.value = localStorage.getItem(chaveLoja + "_telefone");
        if (localStorage.getItem(chaveLoja + "_mensagem") && campoMensagem) campoMensagem.value = localStorage.getItem(chaveLoja + "_mensagem");

        if (campoNome) campoNome.addEventListener("input", () => localStorage.setItem(chaveLoja + "_nome", campoNome.value));
        if (campoTelefone) campoTelefone.addEventListener("input", () => localStorage.setItem(chaveLoja + "_telefone", campoTelefone.value));
        if (campoMensagem) campoMensagem.addEventListener("input", () => localStorage.setItem(chaveLoja + "_mensagem", campoMensagem.value));

        const limparTudo = () => {
            localStorage.removeItem(chaveLoja + "_nome");
            localStorage.removeItem(chaveLoja + "_telefone");
            localStorage.removeItem(chaveLoja + "_mensagem");
        };

        if (formSolicitacao) formSolicitacao.addEventListener("submit", limparTudo);
        if (btnLimpar) btnLimpar.addEventListener("click", limparTudo);
    }

    // 6. Página de Alteração de Cadastro / Minha Área
    if (path.includes("alterar_usuario.php") || path.includes("minha_area.php")) {
        if (!referrer.includes("alterar_usuario.php") && !referrer.includes("minha_area.php")) {
            localStorage.removeItem("alt_usu_nome");
            localStorage.removeItem("alt_usu_loja");
            localStorage.removeItem("alt_usu_email");
            localStorage.removeItem("alt_usu_check");
            localStorage.removeItem("alt_usu_nomeview");
            localStorage.removeItem("alt_usu_telefone");
        }

        const campoNome = document.querySelector("input[name='usuNome']");
        const campoLoja = document.querySelector("input[name='usuLoja']");
        const campoEmail = document.querySelector("input[name='usuEmail']");
        const checkView = document.querySelector("input[name='aceitaVisualizacao']");
        const campoNomeView = document.querySelector("input[name='usuNomeView']");
        const campoTelefone = document.querySelector("input[name='usuTelefone']");
        const formCadastro = document.getElementById("form-cadastro");
        const btnLimpar = document.querySelector("button[type='reset'], .btn-limpar");

        if (localStorage.getItem("alt_usu_nome") && campoNome) campoNome.value = localStorage.getItem("alt_usu_nome");
        if (localStorage.getItem("alt_usu_loja") && campoLoja) campoLoja.value = localStorage.getItem("alt_usu_loja");
        if (localStorage.getItem("alt_usu_email") && campoEmail) campoEmail.value = localStorage.getItem("alt_usu_email");
        if (localStorage.getItem("alt_usu_check") !== null && checkView) checkView.checked = localStorage.getItem("alt_usu_check") === "true";
        if (localStorage.getItem("alt_usu_nomeview") && campoNomeView) campoNomeView.value = localStorage.getItem("alt_usu_nomeview");
        if (localStorage.getItem("alt_usu_telefone") && campoTelefone) campoTelefone.value = localStorage.getItem("alt_usu_telefone");

        if (campoNome) campoNome.addEventListener("input", () => localStorage.setItem("alt_usu_nome", campoNome.value));
        if (campoLoja) campoLoja.addEventListener("input", () => localStorage.setItem("alt_usu_loja", campoLoja.value));
        if (campoEmail) campoEmail.addEventListener("input", () => localStorage.setItem("alt_usu_email", campoEmail.value));
        if (checkView) checkView.addEventListener("change", () => localStorage.setItem("alt_usu_check", checkView.checked));
        if (campoNomeView) campoNomeView.addEventListener("input", () => localStorage.setItem("alt_usu_nomeview", campoNomeView.value));
        if (campoTelefone) campoTelefone.addEventListener("input", () => localStorage.setItem("alt_usu_telefone", campoTelefone.value));

        const limparTudo = () => {
            localStorage.removeItem("alt_usu_nome");
            localStorage.removeItem("alt_usu_loja");
            localStorage.removeItem("alt_usu_email");
            localStorage.removeItem("alt_usu_check");
            localStorage.removeItem("alt_usu_nomeview");
            localStorage.removeItem("alt_usu_telefone");
        };

        if (formCadastro) formCadastro.addEventListener("submit", limparTudo);
        if (btnLimpar) btnLimpar.addEventListener("click", limparTudo);
    }
}