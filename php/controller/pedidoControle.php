<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../model/pedido.class.php';
require_once '../dao/produtodao.class.php';
require_once '../dao/pedidodao.class.php';
require_once '../persistence/conexaoBanco.class.php';
require_once '../util/seguranca.class.php';

Seguranca::verificarAcesso();

$conexao = ConexaoBanco::getInstancia();
$usuario = unserialize($_SESSION['usuario_logado']);

$pedidoDAO = new PedidoDAO();

$opcao = $_GET['op'] ?? '';


switch ($opcao) {
    case "adicionarQuantidade":
        $id_produto = (int)($_GET['id'] ?? 0);
        $quantidade = (int)($_GET['quantidadeVendida'] ?? 0);
        $origem = $_GET['origem'] ?? '';



        if ($id_produto > 0 && $quantidade > 0) {
            $_SESSION['carrinho'][$id_produto] = $quantidade;
            $_SESSION['msg'] = "<p class='success-msg'>Quantidade atualizada no pedido.</p>";
        } else {
            $_SESSION['msg'] = "<p class='error-msg'>Insira uma quantidade válida!</p>";
        }

        if ($origem === 'clonar') {
            header("location:../view/gui_clonar_pedido.php");
        } else if (isset($_SESSION['pedidoSelecionado'])) {
            header("location:../view/gui_alteracao_pedidos.php?id=" . $_SESSION['pedidoSelecionado']['id_pedido']);
        } else {
            header("location:../view/gui_cadastro_pedidos.php");
        }
        exit;

    case "removerQuantidade":
        $id_produto = (int)($_GET['id'] ?? 0);
        $id_pedido = (int)($_GET['id_pedido'] ?? 0);
        $valor = (float)($_GET['valor'] ?? 0);
        $origem = $_GET['origem'] ?? '';

        if ($id_produto > 0 && isset($_SESSION['carrinho'][$id_produto])) {
            unset($_SESSION['carrinho'][$id_produto]);
            $_SESSION['total_compra'] -= $valor;

            // if (isset($_SESSION['pedidoSelecionado']) && $id_pedido > 0) {
            //     $pedidoDAO->removerQuantidade($id_produto, $id_pedido);
            // }

            $_SESSION['msg'] = "<p class='success-msg'>Produto removido do pedido.</p>";
        } else {
            $_SESSION['msg'] = "<p class='error-msg'>Produto não encontrado ou já removido.</p>";
        }

        if ($origem === 'clonar') {
            header("location:../view/gui_clonar_pedido.php");
        } else if (isset($_SESSION['pedidoSelecionado'])) {
            header("location:../view/gui_alteracao_pedidos.php?id=" . $_SESSION['pedidoSelecionado']['id_pedido']);
        } else {
            header("location:../view/gui_cadastro_pedidos.php");
        }
        exit;

    case "limparCarrinho":
        $_SESSION['carrinho'] = [];
 
        if (isset($_SESSION['pedidoSelecionado'])) {
            unset($_SESSION['pedidoSelecionado']);
            header("location:../view/gui_visualizacao_pedidos.php");
        } else {
            header("location:../view/gui_cadastro_pedidos.php");
        }
        exit;

    case "carregarQuantidade":
        $id_pedido = (int)($_GET['id'] ?? 0);
        $clonar = isset($_GET['clonar']) && $_GET['clonar'] == 'true';
        $pedido = $pedidoDAO->buscarPedidoID($id_pedido);

        if (!empty($pedido)) {
            $_SESSION['carrinho'] = [];

            foreach ($pedido['produtos'] as $produto) {
                $_SESSION['carrinho'][$produto['id_produto']] = $produto['quantidade'];
            }

            if ($clonar) {
                if (isset($_SESSION['pedidoSelecionado'])) {
                    unset($_SESSION['pedidoSelecionado']);
                }
                $_SESSION['msg'] = "<p class='success-msg'>Itens clonados com sucesso! Revise e finalize o novo pedido.</p>";
                header("location:../view/gui_clonar_pedido.php");
                exit;
            }

            $_SESSION['pedidoSelecionado'] = [
                'id_pedido' => $pedido['id_pedido'], 
                'data'        => $pedido['data'],
                'comentario'   => $pedido['comentario'],
                'status'       => $pedido['status'],
                'valor_final' => $pedido['valor_final']
            ];

            if ($pedido['status'] != "cancelado") {
                header("location:../view/gui_alteracao_pedidos.php");
                
            } else {
                header("location:../view/gui_alteracao_pedido_cancelado.php");

            }

        } else {
            $_SESSION['msg'] = "<p class='error-msg'>Algo deu errado ao carregar o pedido!</p>";
            header("location:../view/gui_visualizacao_pedidos.php");
        }
        exit;


    case "cadastrar":
        try {
            $prazoPedido = $_GET['prazoPedido'] ?? "";
            $statusPedido = $_GET['statusPedido'] ?? 'encomendado';
            $comentarioPedido = trim($_GET['comentarioPedido'] ?? "");

            $novoPedido = new Pedido();
            $novoPedido->id_usuario = $usuario->id_usuario;
            $novoPedido->data = $prazoPedido;
            $novoPedido->status = $statusPedido;
            $novoPedido->comentario = $comentarioPedido;
            $novoPedido->produtos = $_SESSION['carrinho'];
            $novoPedido->valor_final = $_SESSION['total_compra'];

            // if ($statusPedido !== "vendido"){
            //     $darBaixaEstoque = 0;              
            // } else {
            //     $darBaixaEstoque = isset($_GET['darBaixaEstoque']) ? 1 : 0;
            // }
            
            $pedidoDAO->cadastrarPedido($novoPedido, $darBaixaEstoque);

            $_SESSION['carrinho'] = [];
            $_SESSION['total_compra'] = [];
            $_SESSION['msg'] = "<p class='success-msg'>Pedido cadastrado com sucesso.</p>";
            header("Location: ../view/gui_visualizacao_pedidos.php");
        } catch (Exception $e) {
            $_SESSION['msg'] = "<p class='error-msg'>Algo deu errado! Tente novamente</p>";
            header("Location: ../view/gui_cadastro_pedidos.php");
        }
        exit;

    case "alterar":
        try {
            $id_pedido = $_SESSION['pedidoSelecionado']["id_pedido"];

            $prazoPedido = $_GET['prazoPedido'] ?? "";
            $statusPedido = $_GET['statusPedido'] ?? '';
            $comentarioPedido = trim($_GET['comentarioPedido'] ?? "");

            $darBaixaEstoque = isset($_GET['darBaixaEstoque']) ? 1 : 0;
            $estornarEstoque = isset($_GET['estornarEstoque']) ? 1 : 0;

            $novoPedido = new Pedido();
            $novoPedido->id_pedido = $id_pedido;
            $novoPedido->id_usuario = $usuario->id_usuario;
            $novoPedido->data = $prazoPedido;
            $novoPedido->status = $statusPedido;
            $novoPedido->comentario = $comentarioPedido;
            $novoPedido->valor_final = $_SESSION['total_compra'];

            // if ($statusPedido !== "vendido"){
            //     $darBaixaEstoque = 0;              
            // } else if ($statusPedido !== "cancelado") {
            //     $estornarEstoque = 0;
            // } else {
            //     $darBaixaEstoque = isset($_GET['darBaixaEstoque']) ? 1 : 0;
            // }
            
            
            $pedidoDAO->alterarPedido($novoPedido, $darBaixaEstoque, $estornarEstoque);

            $_SESSION['carrinho'] = [];
            $_SESSION['total_compra'] = [];

            unset($_SESSION['pedidoSelecionado']);
            $_SESSION['msg'] = "<p class='success-msg'>Pedido alterado com sucesso.</p>";
            header("Location: ../view/gui_visualizacao_pedidos.php");
        } catch (Exception $e) {
            $_SESSION['msg'] = "<p class='error-msg'>Algo deu errado! Tente novamente</p>";
            header("Location: ../view/gui_alteracao_pedidos.php?id=$id_pedido");
        }
        exit;

    case "excluir":
        $id_pedido = $_GET['id'] ?? null;

        if ($id_pedido) {
            if ($pedidoDAO->excluirPedido($id_pedido)){
                $_SESSION['msg'] = "<p class='success-msg'>Pedido removida com sucesso.</p>";
            } else {
                $_SESSION['msg'] = "<p class='error-msg'>Erro ao excluir pedido.</p>";
            }
        }  
        header("location:../view/gui_visualizacao_pedidos.php");
        exit;
}

