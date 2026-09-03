export function initLocalStorageManager() {
    const path = window.location.pathname;

    // 1. Página de Cadastro de Usuário
    if (path.includes("cadastro_usuario.php")) {
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

        if (linkLogin) {
            linkLogin.addEventListener("click", () => {
                localStorage.removeItem("cad_nome");
                localStorage.removeItem("cad_loja");
                localStorage.removeItem("cad_email");
            });
        }

        if (btnLimpar) {
            btnLimpar.addEventListener("click", () => {
                localStorage.removeItem("cad_nome");
                localStorage.removeItem("cad_loja");
                localStorage.removeItem("cad_email");
            });
        }
    }

    // 2. Página de Duplicar Pedido
    if (path.includes("duplicar_pedidos.php")) {
        const campoData = document.getElementById("prazoPedido");
        const campoStatus = document.getElementById("statusPedido");
        const campoComentario = document.getElementById("comentarioPedido");
        const formPedido = document.querySelector("form[action*='cadastrar']");
        const btnLimpar = document.querySelector("button[type='reset'], .btn-limpar");

        const veioDeOutraPagina = !document.referrer.includes("duplicar_pedidos.php");
        if (veioDeOutraPagina) {
            localStorage.removeItem("dup_prazo");
            localStorage.removeItem("dup_status");
            localStorage.removeItem("dup_comentario");
        } else {
            if (localStorage.getItem("dup_prazo") && campoData) campoData.value = localStorage.getItem("dup_prazo");
            if (localStorage.getItem("dup_status") && campoStatus) campoStatus.value = localStorage.getItem("dup_status");
            if (localStorage.getItem("dup_comentario") && campoComentario) campoComentario.value = localStorage.getItem("dup_comentario");
        }

        if (campoData) campoData.addEventListener("input", () => localStorage.setItem("dup_prazo", campoData.value));
        if (campoStatus) campoStatus.addEventListener("change", () => localStorage.setItem("dup_status", campoStatus.value));
        if (campoComentario) campoComentario.addEventListener("input", () => localStorage.setItem("dup_comentario", campoComentario.value));

        if (formPedido) {
            formPedido.addEventListener("submit", () => {
                localStorage.removeItem("dup_prazo");
                localStorage.removeItem("dup_status");
                localStorage.removeItem("dup_comentario");
            });
        }

        if (btnLimpar) {
            btnLimpar.addEventListener("click", () => {
                localStorage.removeItem("dup_prazo");
                localStorage.removeItem("dup_status");
                localStorage.removeItem("dup_comentario");
            });
        }
    }

    // 3. Página de Alteração de Pedido
    if (path.includes("alteracao_pedidos.php")) {
        const campoData = document.getElementById("prazoPedido");
        const campoStatus = document.getElementById("statusPedido");
        const campoComentario = document.getElementById("comentarioPedido");
        const formPedido = document.querySelector("form[action*='alterar']");
        const btnLimpar = document.querySelector("button[type='reset'], .btn-limpar");

        const veioDeOutraPagina = !document.referrer.includes("alteracao_pedidos.php");
        if (veioDeOutraPagina) {
            localStorage.removeItem("alt_prazo");
            localStorage.removeItem("alt_status");
            localStorage.removeItem("alt_comentario");
        } else {
            if (localStorage.getItem("alt_prazo") && campoData) campoData.value = localStorage.getItem("alt_prazo");
            if (localStorage.getItem("alt_status") && campoStatus) campoStatus.value = localStorage.getItem("alt_status");
            if (localStorage.getItem("alt_comentario") && campoComentario) campoComentario.value = localStorage.getItem("alt_comentario");
        }

        if (campoData) campoData.addEventListener("input", () => localStorage.setItem("alt_prazo", campoData.value));
        if (campoStatus) campoStatus.addEventListener("change", () => localStorage.setItem("alt_status", campoStatus.value));
        if (campoComentario) campoComentario.addEventListener("input", () => localStorage.setItem("alt_comentario", campoComentario.value));

        if (formPedido) {
            formPedido.addEventListener("submit", () => {
                localStorage.removeItem("alt_prazo");
                localStorage.removeItem("alt_status");
                localStorage.removeItem("alt_comentario");
            });
        }

        if (btnLimpar) {
            btnLimpar.addEventListener("click", () => {
                localStorage.removeItem("alt_prazo");
                localStorage.removeItem("alt_status");
                localStorage.removeItem("alt_comentario");
            });
        }
    }

    // 4. Página de Cadastro de Pedido
    if (path.includes("cadastro_pedidos.php")) {
        const campoData = document.getElementById("prazoPedido");
        const campoStatus = document.getElementById("statusPedido");
        const campoComentario = document.getElementById("comentarioPedido");
        const formPedido = document.querySelector("form[action*='cadastrar']");
        const btnLimpar = document.querySelector("button[type='reset'], .btn-limpar");

        const veioDeOutraPagina = !document.referrer.includes("cadastro_pedidos.php");
        if (veioDeOutraPagina) {
            localStorage.removeItem("cad_prazo");
            localStorage.removeItem("cad_status");
            localStorage.removeItem("cad_comentario");
        } else {
            if (localStorage.getItem("cad_prazo") && campoData) campoData.value = localStorage.getItem("cad_prazo");
            if (localStorage.getItem("cad_status") && campoStatus) campoStatus.value = localStorage.getItem("cad_status");
            if (localStorage.getItem("cad_comentario") && campoComentario) campoComentario.value = localStorage.getItem("cad_comentario");
        }

        if (campoData) campoData.addEventListener("input", () => localStorage.setItem("cad_prazo", campoData.value));
        if (campoStatus) campoStatus.addEventListener("change", () => localStorage.setItem("cad_status", campoStatus.value));
        if (campoComentario) campoComentario.addEventListener("input", () => localStorage.setItem("cad_comentario", campoComentario.value));

        if (formPedido) {
            formPedido.addEventListener("submit", () => {
                localStorage.removeItem("cad_prazo");
                localStorage.removeItem("cad_status");
                localStorage.removeItem("cad_comentario");
            });
        }

        if (btnLimpar) {
            btnLimpar.addEventListener("click", () => {
                localStorage.removeItem("cad_prazo");
                localStorage.removeItem("cad_status");
                localStorage.removeItem("cad_comentario");
            });
        }
    }

    // 5. Página de Visualização da Loja (view_loja.php)
    if (path.includes("view_loja.php")) {
        const campoNome = document.querySelector("input[name='nomeCliente']");
        const campoTelefone = document.querySelector("input[name='telefoneCliente']");
        const campoMensagem = document.getElementById("mensagemCliente");
        const formSolicitacao = document.querySelector("form[action*='solicitarPedido']");
        const btnLimpar = document.querySelector("button[type='reset'], .btn-limpar");
        const chaveLoja = "loja_" + window.location.search;

        const veioDeOutraPagina = !document.referrer.includes("view_loja.php");
        if (veioDeOutraPagina) {
            localStorage.removeItem(chaveLoja + "_nome");
            localStorage.removeItem(chaveLoja + "_telefone");
            localStorage.removeItem(chaveLoja + "_mensagem");
        } else {
            if (localStorage.getItem(chaveLoja + "_nome") && campoNome) campoNome.value = localStorage.getItem(chaveLoja + "_nome");
            if (localStorage.getItem(chaveLoja + "_telefone") && campoTelefone) campoTelefone.value = localStorage.getItem(chaveLoja + "_telefone");
            if (localStorage.getItem(chaveLoja + "_mensagem") && campoMensagem) campoMensagem.value = localStorage.getItem(chaveLoja + "_mensagem");
        }

        if (campoNome) campoNome.addEventListener("input", () => localStorage.setItem(chaveLoja + "_nome", campoNome.value));
        if (campoTelefone) campoTelefone.addEventListener("input", () => localStorage.setItem(chaveLoja + "_telefone", campoTelefone.value));
        if (campoMensagem) campoMensagem.addEventListener("input", () => localStorage.setItem(chaveLoja + "_mensagem", campoMensagem.value));

        if (formSolicitacao) {
            formSolicitacao.addEventListener("submit", () => {
                localStorage.removeItem(chaveLoja + "_nome");
                localStorage.removeItem(chaveLoja + "_telefone");
                localStorage.removeItem(chaveLoja + "_mensagem");
            });
        }

        if (btnLimpar) {
            btnLimpar.addEventListener("click", () => {
                localStorage.removeItem(chaveLoja + "_nome");
                localStorage.removeItem(chaveLoja + "_telefone");
                localStorage.removeItem(chaveLoja + "_mensagem");
            });
        }
    }

    // 6. Página de Alteração de Cadastro
    if (path.includes("alterar_usuario.php") || path.includes("minha_area.php")) {
        const campoNome = document.querySelector("input[name='usuNome']");
        const campoLoja = document.querySelector("input[name='usuLoja']");
        const campoEmail = document.querySelector("input[name='usuEmail']");
        const checkView = document.querySelector("input[name='aceitaVisualizacao']");
        const campoNomeView = document.querySelector("input[name='usuNomeView']");
        const campoTelefone = document.querySelector("input[name='usuTelefone']");
        const formCadastro = document.getElementById("form-cadastro");
        const btnLimpar = document.querySelector("button[type='reset'], .btn-limpar");

        const veioDeOutraPagina = !document.referrer.includes("alterar_usuario.php") && !document.referrer.includes("minha_area.php");
        if (veioDeOutraPagina) {
            localStorage.removeItem("alt_usu_nome");
            localStorage.removeItem("alt_usu_loja");
            localStorage.removeItem("alt_usu_email");
            localStorage.removeItem("alt_usu_check");
            localStorage.removeItem("alt_usu_nomeview");
            localStorage.removeItem("alt_usu_telefone");
        } else {
            if (localStorage.getItem("alt_usu_nome") && campoNome) campoNome.value = localStorage.getItem("alt_usu_nome");
            if (localStorage.getItem("alt_usu_loja") && campoLoja) campoLoja.value = localStorage.getItem("alt_usu_loja");
            if (localStorage.getItem("alt_usu_email") && campoEmail) campoEmail.value = localStorage.getItem("alt_usu_email");
            if (localStorage.getItem("alt_usu_check") !== null && checkView) checkView.checked = localStorage.getItem("alt_usu_check") === "true";
            if (localStorage.getItem("alt_usu_nomeview") && campoNomeView) campoNomeView.value = localStorage.getItem("alt_usu_nomeview");
            if (localStorage.getItem("alt_usu_telefone") && campoTelefone) campoTelefone.value = localStorage.getItem("alt_usu_telefone");
        }

        if (campoNome) campoNome.addEventListener("input", () => localStorage.setItem("alt_usu_nome", campoNome.value));
        if (campoLoja) campoLoja.addEventListener("input", () => localStorage.setItem("alt_usu_loja", campoLoja.value));
        if (campoEmail) campoEmail.addEventListener("input", () => localStorage.setItem("alt_usu_email", campoEmail.value));
        if (checkView) checkView.addEventListener("change", () => localStorage.setItem("alt_usu_check", checkView.checked));
        if (campoNomeView) campoNomeView.addEventListener("input", () => localStorage.setItem("alt_usu_nomeview", campoNomeView.value));
        if (campoTelefone) campoTelefone.addEventListener("input", () => localStorage.setItem("alt_usu_telefone", campoTelefone.value));

        if (formCadastro) {
            formCadastro.addEventListener("submit", () => {
                localStorage.removeItem("alt_usu_nome");
                localStorage.removeItem("alt_usu_loja");
                localStorage.removeItem("alt_usu_email");
                localStorage.removeItem("alt_usu_check");
                localStorage.removeItem("alt_usu_nomeview");
                localStorage.removeItem("alt_usu_telefone");
            });
        }

        if (btnLimpar) {
            btnLimpar.addEventListener("click", () => {
                localStorage.removeItem("alt_usu_nome");
                localStorage.removeItem("alt_usu_loja");
                localStorage.removeItem("alt_usu_email");
                localStorage.removeItem("alt_usu_check");
                localStorage.removeItem("alt_usu_nomeview");
                localStorage.removeItem("alt_usu_telefone");
            });
        }
    }
}