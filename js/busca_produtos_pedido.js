document.addEventListener('DOMContentLoaded', function() {
    const pesquisaProdutos = document.getElementById('pesquisa-produtos');
    const listaProdutos = document.querySelector('.lista-produtos-pedido');

    if (pesquisaProdutos && listaProdutos) {
        const produtos = Array.from(listaProdutos.querySelectorAll('.product-view'));

        pesquisaProdutos.addEventListener('input', function() {
            const termo = pesquisaProdutos.value.trim().toLocaleLowerCase();
            let encontrados = 0;

            produtos.forEach(function(produto) {
                const textoProduto = produto.textContent.toLocaleLowerCase();
                const corresponde = textoProduto.includes(termo);
                produto.style.display = corresponde ? '' : 'none';
                encontrados += corresponde ? 1 : 0;
            });

            let mensagem = listaProdutos.querySelector('.sem-registro');
            if (encontrados === 0) {
                if (!mensagem) {
                    mensagem = document.createElement('h4');
                    mensagem.className = 'sem-registro';
                    mensagem.textContent = 'Nenhum produto correspondente foi encontrado!';
                    listaProdutos.appendChild(mensagem);
                }
                mensagem.style.display = '';
            } else if (mensagem) {
                mensagem.style.display = 'none';
            }
        });
    } else {
        console.error('Elementos de busca não foram encontrados no DOM.');
    }
});