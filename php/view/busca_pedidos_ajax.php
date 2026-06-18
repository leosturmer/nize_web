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

$pedidoDAO = new PedidoDAO();

$usuario = unserialize($_SESSION['usuario_logado']);
$idUsuarioLogado = $usuario->id_usuario;

if (!empty($pesquisa) || !empty($dataPedido) || !empty($statusPedido)) {
    $listaPedidos = $pedidoDAO->buscarPedidoFiltro($pesquisa, $dataPedido, $statusPedido, $idUsuarioLogado);
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
    
    $statusView = '';
    if ($dados_pedido['status'] == "encomendado") { $statusView = "Encomendado"; }
    else if ($dados_pedido['status'] == "pagamento") { $statusView = "Pagamento"; }
    else if ($dados_pedido['status'] == "vendido") { $statusView = "Vendido"; }
    else if ($dados_pedido['status'] == "cancelado") { $statusView = "Cancelado"; }

        echo '<div class="product-view">';
            
            foreach ($dados_pedido['produtos'] as $produto) {
                echo '<p><strong>' . htmlspecialchars($produto['nome']) . '</strong>: ' . htmlspecialchars($produto['quantidade']) . ' unidades</p>';
            }

            echo '<p><strong>Data: </strong>' . $data . '</p>';
            echo '<p><strong>Valor final: </strong> R$ ' . number_format((float)$dados_pedido['valor_final'], 2, ',', '.') . '</p>';
            echo '<p><strong>Comentário: </strong>' . htmlspecialchars($dados_pedido['comentario']) . '</p>';
            echo '<p><strong>Status: </strong>' . $statusView . '</p>';
            
            echo '<div class="product-btns">';
                echo '<a href="../controller/pedidoControle.php?op=carregarQuantidade&id=' . $id_pedido . '">Visualizar</a>';
                echo '<a href="../controller/pedidoControle.php?op=excluir&id=' . $id_pedido . '" onclick="return confirm(\'Deseja mesmo excluir?\');">Excluir</a>';
            echo '</div>';

        echo '</div>';
    }
    } else {
    echo "Nenhum pedido encontrado";
    }