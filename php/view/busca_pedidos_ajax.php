<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/pedido.class.php';
require_once '../dao/pedidodao.class.php';
require_once '../util/seguranca.class.php';

Seguranca::verificarAcesso();
header('Content-Type: text/html; charset=utf-8');

$pesquisa = trim($_GET['pesquisaPedidos'] ?? '');
$dataPedido = trim($_GET['dataPedido'] ?? '');
$statusPedido = trim($_GET['statusPedido'] ?? '');
$ordenarPor = trim($_GET['ordenarPor'] ?? '');

$pedidoDAO = new PedidoDAO();

$usuario = unserialize($_SESSION['usuario_logado']);
$idUsuarioLogado = $usuario->id_usuario;

if (!empty($pesquisa) || !empty($dataPedido) || !empty($statusPedido) || !empty($ordenarPor)) {
    $listaPedidos = $pedidoDAO->buscarPedidoFiltro($pesquisa, $dataPedido, $statusPedido, $ordenarPor, $idUsuarioLogado);
} else {
    $listaPedidos = $pedidoDAO->listarTodosPedidos($idUsuarioLogado);
}

if (empty($listaPedidos)) {
    
    echo '<h4>Nenhum pedido correspondente foi encontrado!</h4>';
    exit;
}

if (!empty($listaPedidos)){ 
    foreach ($listaPedidos as $id_pedido => $dados_pedido) {
    $data = date("d/m/Y", strtotime($dados_pedido['data']));

    $comentario = htmlspecialchars($dados_pedido['comentario']);

    
    $statusView = '';
    if ($dados_pedido['status'] == "encomendado") { $statusView = "Encomendado"; }
    if ($dados_pedido['status'] == "encomenda_online") { $statusView = "Encomenda online"; }
    else if ($dados_pedido['status'] == "pagamento") { $statusView = "Pagamento"; }
    else if ($dados_pedido['status'] == "vendido") { $statusView = "Vendido"; }
    else if ($dados_pedido['status'] == "cancelado") { $statusView = "Cancelado"; }

        echo '<div class="product-view">';

        ?>
        <div class="texto-pedido">
            <h2>Número do pedido: <?php echo $numero_pedido = str_pad($id_pedido, 4, '0', STR_PAD_LEFT); ?></h2>
            <?php
                foreach ($dados_pedido['produtos'] as $produto) {
                    echo '<p><strong>' . htmlspecialchars($produto['nome']) . '</strong>: ' . htmlspecialchars($produto['quantidade']) . ' unidades</p>';
                }
            ?>
            <p><strong>Data: </strong><?php echo $data ?></p>
            <p><strong>Valor final: </strong> R$ <?php echo number_format((float)$dados_pedido['valor_final'], 2, ',', '.') ?></p>
            <p><strong>Status: </strong><?php echo $statusView ?></p>
            <p class="p-descricao"><strong>Comentário: </strong><?php if ($comentario) {echo $comentario; } else { echo "Nenhum comentário adicionado"; } ?></p>
        </div>

        <div class="product-btns pedido-btns">
            <a href="../controller/pedidoControle.php?op=carregarQuantidade&id=<?php echo $id_pedido ?>"><span class="bi bi-pencil"></span>Editar</a>
            <a href="../controller/pedidoControle.php?op=excluir&id=<?php echo $id_pedido ?>" onclick="return confirm('Deseja mesmo excluir?');"><span class="bi bi-trash3"></span>Excluir</a>
        </div>
    </div>
    <?php }
}