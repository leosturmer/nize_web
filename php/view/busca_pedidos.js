document.addEventListener('DOMContentLoaded', function() {
    const pesquisaPedidos = document.getElementById('pesquisa-pedidos');
    const filtroData = document.getElementById('filtro-data-pedidos');
    const filtroStatus = document.getElementById('filtro-status-pedidos');
    const btnLimpar = document.getElementById('btn-limpar-filtros');
    const listaPedidos = document.querySelector('.lista-pedidos');
    
    let temporizador;

    function executarBusca() {
        let termo = pesquisaPedidos ? pesquisaPedidos.value : '';
        let data = filtroData ? filtroData.value : '';
        let status = filtroStatus ? filtroStatus.value : '';

        clearTimeout(temporizador);

        temporizador = setTimeout(() => {
            // CRÍTICO: Verifique se os nomes batem exatamente com o $_GET do PHP
            const url = `busca_pedidos_ajax.php?pesquisaPedidos=${encodeURIComponent(termo)}&dataPedido=${encodeURIComponent(data)}&statusPedido=${encodeURIComponent(status)}`;
            
            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Erro na resposta do servidor');
                    return response.text();
                })
                .then(html => {
                    listaPedidos.innerHTML = html;
                })
                .catch(erro => {
                    console.error('Erro na busca:', erro);
                    listaPedidos.innerHTML = '<h4 class="sem-registro">Erro ao processar a busca.</h4>';
                });
        }, 250);
    }

    if (listaPedidos) {
        if (pesquisaPedidos) {
            pesquisaPedidos.addEventListener('input', executarBusca);
        }
        if (filtroData) {
            filtroData.addEventListener('change', executarBusca);
        }
        if (filtroStatus) {
            filtroStatus.addEventListener('change', executarBusca);
        }
        if (btnLimpar) {
            btnLimpar.addEventListener('click', function() {
                if (pesquisaPedidos) pesquisaPedidos.value = ''; // Limpa o texto
                if (filtroData) filtroData.value = '';           // Limpa a data
                if (filtroStatus) filtroStatus.value = '';       // Volta o select para "Todos"
                
                executarBusca(); // Executa a busca vazia para trazer todos os registros de volta
            });
        }
    } else {
        console.error('O container .lista-pedidos não foi encontrado no DOM.');
    }
});