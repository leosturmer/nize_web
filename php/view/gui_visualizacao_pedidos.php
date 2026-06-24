<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../dao/pedidodao.class.php';
require_once '../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

$pedidoDAO = new pedidoDAO();

$listaPedidos = $pedidoDAO->listarTodosPedidos($usuario->id_usuario);

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_SESSION['pedidoSelecionado'])){
    unset($_SESSION['pedidoSelecionado']);
    unset($_SESSION['carrinho']);
}

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

        <div class="internal-nav">
            <h1>Pedidos</h1>
            <div class="internal-nav-links">
                <form onsubmit="return false;">
                    <span>Pesquise um termo...</span>
                    <input type="text" id="pesquisa-pedidos" placeholder="Digite sua pesquisa" autocomplete="off">
                    <details>
                        <summary>Mais filtros</summary>
                        <input type="date" id="filtro-data-pedidos">
                        <select id="filtro-status-pedidos">
                            <option value="">Todos os Status</option>
                            <option value="encomendado">Encomendado</option>
                            <option value="pagamento">Pagamento</option>
                            <option value="vendido">Vendido</option>
                            <option value="cancelado">Cancelado</option>
                        </select>

                        <button type="button" id="btn-limpar-filtros">Resetar filtros</button>
                    </details>

                </form>
                <a href="gui_cadastro_pedidos.php">Cadastrar novo pedido</a>
            </div>
        </div>

        
        <div class="lista-pedidos">
            <?php if (!empty($listaPedidos)): ?>
                <?php foreach ($listaPedidos as $id_pedido => $dados_pedido): ?>
                    <div class="product-view">

                    <h2>Número do pedido: <?php echo $numero_pedido = str_pad($id_pedido, 4, '0', STR_PAD_LEFT); ?></h2>
                        <?php
                            $dataBanco = $dados_pedido['data'];
                            $formatoData = strtotime($dataBanco);
                            $data = date("d/m/Y", $formatoData);

                            $comentario = htmlspecialchars($dados_pedido['comentario']);
                            $status = $dados_pedido['status'];

                            $statusView = '';
                            if ($status == "encomendado") { $statusView = "Encomendado"; } 
                            else if ($status == "pagamento") { $statusView = "Pagamento"; } 
                            else if ($status == "vendido") { $statusView = "Vendido"; } 
                            else if ($status == "cancelado") { $statusView = "Cancelado"; }

                            foreach ($dados_pedido['produtos'] as $produto){
                                echo "<p><strong>" . htmlspecialchars($produto['nome']) . "</strong>: " . htmlspecialchars($produto['quantidade']) . " unidades</p>";
                            }
                        ?> 
                        
                        <p><strong>Data: </strong><?php echo $data ?></p>
                        <p><strong>Valor final: </strong> R$ <?php echo number_format((float)$dados_pedido['valor_final'], 2, ',', '.') ?></p>
                        <p><strong>Comentário: </strong><?php echo $comentario ?></p>
                        <p><strong>Status: </strong><?php echo $statusView ?></p>

                        <div class="product-btns">
                            <a href="../controller/pedidoControle.php?op=carregarQuantidade&id=<?php echo $id_pedido ?>">Visualizar</a>
                            <a href="../controller/pedidoControle.php?op=excluir&id=<?php echo $id_pedido ?>" onclick="return confirm('Deseja mesmo excluir?');">Excluir</a>
                        </div>
                    </div> <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum pedido cadastrado.</p>
            <?php endif; ?>
        </div>


        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>

    </div>
    
    <script src="busca_pedidos.js"></script>
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