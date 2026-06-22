document.addEventListener('DOMContentLoaded', function() {
    const pesquisaProdutos = document.getElementById('pesquisa-produtos');
    const filtroEstoque = document.getElementById('filtro-estoque');
    const filtroEncomenda = document.getElementById('filtro-encomenda');
    const btnLimpar = document.getElementById('btn-limpar-filtros'); // Captura o novo botão
    const listaProdutos = document.querySelector('.lista-produtos');
    
    let temporizador;

    function executarBusca() {
    let termo = pesquisaProdutos ? pesquisaProdutos.value : '';
    let estoque = filtroEstoque ? filtroEstoque.value : '';
    let encomenda = filtroEncomenda ? filtroEncomenda.value : '';

    // Captura o ID da loja se ele estiver presente na URL da página atual
    const urlParams = new URLSearchParams(window.location.search);
    const idLoja = urlParams.get('id');

    clearTimeout(temporizador);

    temporizador = setTimeout(() => {
        let url = '';
        
        // Se houver idLoja na URL, significa que estamos na view_loja.php (pública)
        if (idLoja) {
            url = `busca_produtos_loja_ajax.php?pesquisaProdutos=${encodeURIComponent(termo)}&id_loja=${encodeURIComponent(idLoja)}`;
        } else {
            // Caso contrário, mantém o fluxo antigo da área interna (gui_produtos)
            url = `busca_produtos_ajax.php?pesquisaProdutos=${encodeURIComponent(termo)}&filtroEstoque=${encodeURIComponent(estoque)}&filtroEncomenda=${encodeURIComponent(encomenda)}`;
        }
        
        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Erro na resposta do servidor');
                return response.text();
            })
            .then(html => {
                listaProdutos.innerHTML = html;
            })
            .catch(erro => {
                console.error('Erro na busca:', erro);
                listaProdutos.innerHTML = '<h4 class="sem-registro">Erro ao processar a busca.</h4>';
            });
    }, 250); 
}

    if (listaProdutos) {
        if (pesquisaProdutos) {
            pesquisaProdutos.addEventListener('input', executarBusca);
        }
        if (filtroEstoque) {
            filtroEstoque.addEventListener('change', executarBusca);
        }
        if (filtroEncomenda) {
            filtroEncomenda.addEventListener('change', executarBusca);
        }

        // Ação do botão de limpar filtros
        if (btnLimpar) {
            btnLimpar.addEventListener('click', function() {
                if (pesquisaProdutos) pesquisaProdutos.value = ''; // Limpa o texto
                if (filtroEstoque) filtroEstoque.value = '';       // Reseta o select de estoque
                if (filtroEncomenda) filtroEncomenda.value = '';   // Reseta o select de encomenda
                
                executarBusca(); // Recarrega a lista completa
            });
        }
    } else {
        console.error('Elementos de busca não foram encontrados no DOM.');
    }
});