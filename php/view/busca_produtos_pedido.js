// Garante que o código só rode após o HTML estar totalmente carregado
document.addEventListener('DOMContentLoaded', function() {
    const pesquisaProdutos = document.getElementById('pesquisa-produtos');
    // Seleciona pela classe .lista-produtos correspondente ao seu HTML
    const listaProdutos = document.querySelector('.lista-produtos-pedido');
    
    let temporizador;

    // Verifica se os elementos realmente existem na página antes de prosseguir
    if (pesquisaProdutos && listaProdutos) {
        pesquisaProdutos.addEventListener('input', function() {
            let termo = pesquisaProdutos.value;
            clearTimeout(temporizador);

            temporizador = setTimeout(() => {
                fetch('busca_produtos_pedidos_ajax.php?pesquisaProdutos=' + encodeURIComponent(termo))
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
        });
    } else {
        console.error('Elementos de busca não foram encontrados no DOM.');
    }
});