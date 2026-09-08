// Garante que o código só rode após o HTML estar totalmente carregado
document.addEventListener('DOMContentLoaded', function() {
    const pesquisaProdutos = document.getElementById('pesquisa-produtos');
    const listaProdutos = document.querySelector('.lista-produtos-pedido');
    const formularioPesquisa = document.getElementById('form-pesquisa-produtos');
    const endpoint = formularioPesquisa?.action;
    
    let temporizador;

    // Verifica se os elementos realmente existem na página antes de prosseguir
    if (pesquisaProdutos && listaProdutos && endpoint) {
        pesquisaProdutos.addEventListener('input', function() {
            let termo = pesquisaProdutos.value;
            clearTimeout(temporizador);

            temporizador = setTimeout(() => {
                const url = endpoint + '?pesquisaProdutos=' + encodeURIComponent(termo);

                fetch(url, { credentials: 'same-origin' })
                    .then(async response => {
                        const resposta = await response.text();
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${resposta.substring(0, 120)}`);
                        }
                        return resposta;
                    })
                    .then(html => {
                        listaProdutos.innerHTML = html;
                    })
                    .catch(erro => {
                        console.error('Erro na busca:', erro);
                        listaProdutos.innerHTML = '<h4 class="sem-registro">Erro ao processar a busca.</h4>';
                    });
            }, 250); 
        });
    } else {
        console.error('Elementos ou endpoint da busca não foram encontrados no DOM.');
    }
});