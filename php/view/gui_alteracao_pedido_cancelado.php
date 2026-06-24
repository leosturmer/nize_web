<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../dao/pedidodao.class.php';
require_once '../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

$produtoDAO = new ProdutoDAO();

if (empty($_SESSION['pedidoSelecionado'])) {
    $_SESSION['msg'] = "<p class='error-msg'>Nenhum pedido selecionado!</p>";
    echo $_SESSION['msg'];
    header("location:gui_visualizacao_pedidos.php");
    exit;
}
$id_pedido = $_SESSION['pedidoSelecionado']["id_pedido"];
$infoPedido = $_SESSION['pedidoSelecionado'];


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../../img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/query.css">
    <link rel="stylesheet" href="../../css/style.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=dehaze" />


    <title>Pedidos</title>
</head>
<body>
    
    <details class="coll-sidenav" open>
        <summary><span class="material-symbols-outlined">dehaze</span></summary>
        <div class="sidenav">
            <img src="../../img/logo/nize_new.png" alt="Nize" id="logo-sidenav">
            <a href="tela_inicial.php">Tela inicial</a>
            <a href="gui_visualizacao_produtos.php">Produtos</a>
            <a href="gui_visualizacao_pedidos.php">Pedidos</a>
            <a href="gui_minha_area.php">Minha área</a>
            <a href="../controller/logout.php" id="btn-sair">Encerrar sessão</a>
        </div>
    </details>
    <div class="conteudo-pagina">
    
    <main>
        <?php
            if (isset($_SESSION["msg"])) {
                echo "<div id='session-msg'>" . $_SESSION['msg'].  "</div>";
            unset($_SESSION["msg"]);
            }
        ?>

        <h1>Visualização de pedido</h1>

        <div class="internal-nav">
            <div class="internal-nav-links">
                <a href="gui_visualizacao_pedidos.php">Visualizar pedidos</a>
            </div>
        </div>

        <h2>Número do pedido: <?php echo $numero_pedido = str_pad($id_pedido, 4, '0', STR_PAD_LEFT); ?></h2>

        
        <div class="produtos-na-pedido">
            <h3>Pedido cancelado</h3>
            <p>Não é possível fazer alterações em pedidos cancelados</p>
            <?php

                if (!empty($_SESSION['carrinho'])) {

                    foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {

                        $produtoVendido = $produtoDAO->buscarPorId($id_produto);
                        if ($produtoVendido) {
                            echo "<h4>Produto</b>: " . htmlspecialchars($produtoVendido['nome']) . "</h4><br>";
                            echo "<p>";
                            echo "<b>Quantidade</b>: " . $quantidade . "<br>";
                            echo "<b>Valor do produto</b>: R$ " . number_format((float)$produtoVendido['valor_unitario'], 2, ',', '.') . "<br>";

                            $valor_total = (float)$produtoVendido['valor_unitario'];
                            $valor_total = $valor_total * $quantidade;
        
                            echo "<b>Valor total</b>: R$ " . (number_format((float)$valor_total, 2, ',', '.')) . "<br>";
                            } else {
                                echo "<p><b>Produto ID $id_produto</b> não foi encontrado no estoque.</p>";
                            }
                    }
                } else {
                    echo "<p>Nenhum produto encontrado nesta pedido.</p>";
                }
                    echo "<b>Valor final do pedido</b>: R$ " . number_format((float)$infoPedido['valor_final'], 2, ',', '.') . "<br>"; // Aqui tem que mudar

                $dataBanco = $infoPedido['data'] ;
                $formatoData = strtotime($dataBanco);
                $data = date("d/m/Y", $formatoData);


                echo "<b>Data/prazo</b>:  " . $data . "<br>";
                echo "<b>Comentários</b>:  " . $infoPedido['comentario'] . "<br>";
                echo "</p>";

                                    ?>
            </div>
            <div class="product-btns">
                <a href="../controller/pedidoControle.php?op=carregarQuantidade&id=<?php echo $id_pedido; ?>&clonar=true" class="btn-add">Clonar</a>
                <a href="../controller/pedidoControle.php?op=limparCarrinho" class="btn-add">Voltar</a>
            </div>
        </form>
        

        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>

    </div>

    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusPedido = document.getElementById("statusPedido");
            const containerVendido = document.getElementById("containerVendido");
            const containerCancelado = document.getElementById("containerCancelado");

            // Função que gerencia o que deve aparecer baseado no valor selecionado
            function gerenciarCheckboxes() {
                const valorSelecionado = statusPedido.value;

                if (valorSelecionado === "vendido") {
                    containerVendido.style.display = "block";   // Mostra o de venda
                    containerCancelado.style.display = "none";  // Esconde o de cancelamento
                } else if (valorSelecionado === "cancelado") {
                    containerVendido.style.display = "none";  // Esconde o de venda
                    containerCancelado.style.display = "block"; // Mostra o de cancelamento
                } else {
                    // Se for "encomendado" ou "pagamento", esconde ambos
                    containerVendido.style.display = "none";
                    containerCancelado.style.display = "none";
                }
            }

            // 1. Escuta a mudança de opções no select pelo usuário
            statusPedido.addEventListener("change", gerenciarCheckboxes);

            // 2. Executa uma vez ao carregar a página (importante para telas de ALTERAÇÃO)
            gerenciarCheckboxes();
        });
    </script>

    <script>
    const msgElement = document.getElementById('session-msg');

        if (msgElement) {
            setTimeout(() => {
                msgElement.style.display = 'none'; 
            }, 6000);
        }
    </script>
</body>
</html>