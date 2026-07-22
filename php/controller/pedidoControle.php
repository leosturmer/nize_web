<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../model/pedido.class.php';
require_once '../dao/produtodao.class.php';
require_once '../dao/pedidodao.class.php';
require_once '../persistence/conexaoBanco.class.php';
require_once '../util/seguranca.class.php';

// Seguranca::verificarAcesso();

$conexao = ConexaoBanco::getInstancia();
$usuario = unserialize($_SESSION['usuario_logado']);

$pedidoDAO = new PedidoDAO();
$produtoDAO = new ProdutoDAO();

$opcao = $_GET['op'] ?? '';


switch ($opcao) {
    case "adicionarQuantidade":
        $id_produto = (int)($_GET['id'] ?? 0);
        $quantidade = (int)($_GET['quantidadeVendida'] ?? 0);
        $origem = $_GET['origem'] ?? '';



        if ($id_produto > 0 && $quantidade > 0) {
            $_SESSION['carrinho'][$id_produto] = $quantidade;
            $valor_unitario = $_SESSION['carrinho'][$id_produto]['valor_unitario'] ?? null;

            if ($valor_unitario === null) {
                $prodAtual = $produtoDAO->buscarPorId($id_produto);
                $valor_unitario = $prodAtual['valor_unitario'] ?? 0;
            }

            $_SESSION['carrinho'][$id_produto] = [
                'quantidade' => $quantidade,
                'valor_unitario' => $valor_unitario
            ];

            $_SESSION['msg'] = "<p class='success-msg'>Quantidade atualizada no pedido.</p>";
        } else {
            $_SESSION['msg'] = "<p class='error-msg'>Insira uma quantidade válida!</p>";
        }

        if ($origem === 'clonar') {
            header("location:../view/clonar_pedido.php");
        } else if (isset($_SESSION['pedidoSelecionado'])) {
            header("location:../view/alteracao_pedidos.php?id=" . $_SESSION['pedidoSelecionado']['id_pedido']);
        } else {
            header("location:../view/cadastro_pedidos.php");
        }
        exit;

    case "adicionarSacola":
        $id_produto = (int)($_GET['id'] ?? 0);
        $quantidade = (int)($_GET['quantidadeVendida'] ?? 0);
        $nome_visualizacao = $_GET['loja'] ?? '';

        if ($id_produto > 0 && $quantidade > 0) {
            $prodAtual = $produtoDAO->buscarPorId($id_produto);
            $valor_unitario = $prodAtual['valor_unitario'] ?? 0;

            $_SESSION['sacola'][$id_produto] = [
                'quantidade' => $quantidade,
                'valor_unitario' => $valor_unitario
            ];

            $_SESSION['msg'] = "<p class='success-msg'>Produto adicionado à sacola.</p>";
        } else {
            $_SESSION['msg'] = "<p class='error-msg'>Insira uma quantidade válida!</p>";
        }

        header("Location: ../view/view_loja.php?loja=" . urlencode($nome_visualizacao));
        exit;

    case "removerQuantidade":
        $id_produto = (int)($_GET['id'] ?? 0);
        $valor      = (float)($_GET['valor'] ?? 0);
        $origem     = $_GET['origem'] ?? '';
        $loja       = $_GET['loja'] ?? '';

        if ($origem === 'loja') {
            // Remoção na sacola pública da loja
            if ($id_produto > 0 && isset($_SESSION['sacola'][$id_produto])) {
                unset($_SESSION['sacola'][$id_produto]);
                $_SESSION['msg'] = "<p class='success-msg'>Produto removido da sacola.</p>";
            }
            header("Location: ../view/view_loja.php?loja=" . urlencode($loja));
            exit;
        } else {
            // Remoção do carrinho interno do gestor
            Seguranca::verificarAcesso();
            if ($id_produto > 0 && isset($_SESSION['carrinho'][$id_produto])) {
                unset($_SESSION['carrinho'][$id_produto]);
                $_SESSION['msg'] = "<p class='success-msg'>Produto removido do pedido.</p>";
            }

            if ($origem === 'clonar') {
                header("location:../view/clonar_pedido.php");
            } else if (isset($_SESSION['pedidoSelecionado'])) {
                header("location:../view/alteracao_pedidos.php?id=" . $_SESSION['pedidoSelecionado']['id_pedido']);
            } else {
                header("location:../view/cadastro_pedidos.php");
            }
            exit;
        }

    case "limparCarrinho":
        $origem = $_GET['origem'] ?? '';
        $loja   = $_GET['loja'] ?? '';

        if ($origem === 'loja') {
            // Limpa apenas a sacola da loja pública
            $_SESSION['sacola'] = [];
            header("Location: ../view/view_loja.php?loja=" . urlencode($loja));
        } else {
            // Limpa o carrinho administrativo
            Seguranca::verificarAcesso();
            $_SESSION['carrinho'] = [];
            if (isset($_SESSION['pedidoSelecionado'])) {
                unset($_SESSION['pedidoSelecionado']);
                header("location:../view/visualizacao_pedidos.php");
            } else {
                header("location:../view/cadastro_pedidos.php");
            }
        }
        exit;

    case "carregarQuantidade":
        $id_pedido = (int)($_GET['id'] ?? 0);
        $clonar = isset($_GET['clonar']) && $_GET['clonar'] == 'true';
        $pedido = $pedidoDAO->buscarPedidoID($id_pedido);

        if (!empty($pedido)) {
            $_SESSION['carrinho'] = [];
            unset($_SESSION['produtos']);

            foreach ($pedido['produtos'] as $produto) {
                $_SESSION['carrinho'][$produto['id_produto']] = [
                    'quantidade' => $produto['quantidade'],
                    'valor_unitario' => $produto['valor_unitario']
                ];
            }

            if ($clonar) {
                if (isset($_SESSION['pedidoSelecionado'])) {
                    unset($_SESSION['pedidoSelecionado']);
                }
                $_SESSION['msg'] = "<p class='success-msg'>Itens clonados com sucesso! Revise e finalize o novo pedido.</p>";
                header("location:../view/clonar_pedido.php");
                exit;
            }

            $_SESSION['pedidoSelecionado'] = [
                'id_pedido' => $pedido['id_pedido'],
                'data'        => $pedido['data'],
                'comentario'   => $pedido['comentario'],
                'status'       => $pedido['status'],
                'valor_final' => $pedido['valor_final']
            ];

            if ($pedido['status'] != "cancelado" && $pedido['status'] != 'vendido') {
                header("location:../view/alteracao_pedidos.php");
            } else if ($pedido['status'] == "cancelado") {
                header("location:../view/alteracao_pedido_cancelado.php");
            } else if ($pedido['status'] == "vendido") {
                header("location:../view/alteracao_pedido_vendido.php");
            }
        } else {
            $_SESSION['msg'] = "<p class='error-msg'>Algo deu errado ao carregar o pedido!</p>";
            header("location:../view/visualizacao_pedidos.php");
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

            $pedidoDAO->cadastrarPedido($novoPedido, $darBaixaEstoque = null);

            $_SESSION['carrinho'] = [];
            $_SESSION['total_compra'] = [];
            $_SESSION['msg'] = "<p class='success-msg'>Pedido cadastrado com sucesso.</p>";
            header("Location: ../view/visualizacao_pedidos.php");
        } catch (Exception $e) {
            $_SESSION['msg'] = "<p class='error-msg'>Algo deu errado! Tente novamente</p>";
            header("Location: ../view/cadastro_pedidos.php");
        }
        exit;

    case "solicitarPedido":
        try {
            $loja = $_GET['loja'] ?? '';
            $comentarioDigitado = trim($_GET['comentarioPedido'] ?? "");

            // Monta o comentário com a Opção 2 (prefixo no início)
            if (!empty($comentarioDigitado)) {
                $comentarioFinal = "### Pedido feito online ### " . $comentarioDigitado;
            } else {
                $comentarioFinal = "### Pedido feito online ### ";
            }

            if (empty($_SESSION['sacola'])) {
                $_SESSION['msg'] = "<p class='error-msg'>Sua sacola está vazia!</p>";
                header("Location: ../view/view_loja.php?loja=" . urlencode($loja));
                exit;
            }

            require_once '../dao/usuariodao.class.php';
            $usuarioDAO = new UsuarioDAO();
            $id_dono_loja = (int)$usuarioDAO->buscarId($loja);

            $novoPedido = new Pedido();
            $novoPedido->id_usuario = $id_dono_loja;
            $novoPedido->data = date('Y-m-d');
            $novoPedido->status = 'encomenda_online';
            
            $novoPedido->comentario = $comentarioFinal;
            
            $novoPedido->produtos = $_SESSION['sacola'];
            $novoPedido->valor_final = $_SESSION['total_compra'];

            $_SESSION['carrinho'] = $_SESSION['sacola']; 

            // Cadastra o pedido e recupera o ID gerado no banco
            $id_pedido_gerado = $pedidoDAO->cadastrarPedido($novoPedido, null);
            $numero_formatado = str_pad($id_pedido_gerado, 4, '0', STR_PAD_LEFT);

            // Limpa os dados temporários da sessão
            $_SESSION['sacola'] = [];
            $_SESSION['carrinho'] = [];
            $_SESSION['total_compra'] = 0.00;

            // Define as flags e mensagens de sucesso
            $_SESSION['pedido_sucesso'] = true;
            $_SESSION['ultimo_pedido_id'] = $numero_formatado;
            $_SESSION['msg'] = "<p class='success-msg'>Pedido #{$numero_formatado} enviado com sucesso! Aguarde, você será redirecionado...</p>";
            
            header("Location: ../view/view_loja.php?loja=" . urlencode($loja));
            exit;

        } catch (Exception $e) {
            $_SESSION['msg'] = "<p class='error-msg'>Algo deu errado ao enviar seu pedido! Tente novamente.</p>";
            header("Location: ../view/view_loja.php?loja=" . urlencode($loja));
            exit;
        }


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
            header("Location: ../view/visualizacao_pedidos.php");
        } catch (Exception $e) {
            $_SESSION['msg'] = "<p class='error-msg'>Algo deu errado! Tente novamente</p>";
            header("Location: ../view/alteracao_pedidos.php?id=$id_pedido");
        }
        exit;

    case "excluir":
        $id_pedido = $_GET['id'] ?? null;

        if ($id_pedido) {
            if ($pedidoDAO->excluirPedido($id_pedido)) {
                $_SESSION['msg'] = "<p class='success-msg'>Pedido removida com sucesso.</p>";
            } else {
                $_SESSION['msg'] = "<p class='error-msg'>Erro ao excluir pedido.</p>";
            }
        }
        header("location:../view/visualizacao_pedidos.php");
        exit;
}
