<?php

use function PHPSTORM_META\type;

session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';

require_once '../persistence/conexaoBanco.class.php';
require_once '../util/seguranca.class.php';
Seguranca::verificarAcesso();

$conexao = ConexaoBanco::getInstancia();

$opcao = $_GET['op'] ?? '';

$usuario = unserialize($_SESSION['usuario_logado']);
$idUsuarioLogado = $usuario->id_usuario;

$nomeProduto = trim($_POST['nomeProduto']) ?? '';
$quantidadeProduto = $_POST['quantidadeProduto'] ?? 0;
$valorUnitario = trim($_POST['valorUnitario']) ?? '';
$valorCusto = trim($_POST['valorCusto']) ?? 0;
$imagemProduto = $_POST['imagemProduto'] ?? null;
$descricaoProduto = trim($_POST['descricaoProduto']) ?? '';

if ($_POST['aceitaEncomenda'] != "1" || $_POST['aceitaEncomenda'] === null){
    $aceitaEncomenda = "0";
} else {
    $aceitaEncomenda = $_POST['aceitaEncomenda'];
}

if ($_POST['aceitaVisualizacao'] != "1" || $_POST['aceitaVisualizacao'] === null){
    $aceitaVisualizacao = "0";
} else {
    $aceitaVisualizacao = $_POST['aceitaVisualizacao'];
}



$produtoDAO = new ProdutoDAO();

switch ($opcao){
    case "cadastrar":
        if (empty($nomeProduto)){
            $_SESSION['msg'] = "<p class='error-msg'>Insira os dados obrigatórios</p>";
            header("location:../view/cadastro_produtos.php");
            exit;
        }

        $produto = new Produto();
        $produto->id_usuario = $idUsuarioLogado;
        $produto->nome = $nomeProduto;
        $produto->quantidade = (int)$quantidadeProduto ?? 0;
        $produto->valor_unitario = $valorUnitario;
        $produto->valor_custo = $valorCusto;
        $produto->aceita_encomenda = $aceitaEncomenda;
        $produto->aceita_visualizacao = $aceitaVisualizacao;
        $produto->descricao = $descricaoProduto;
        $produto->imagem = $_POST['imagem_clonada'] ?? null;
        
        // Verifica se o arquivo foi enviado sem erros de upload
        if (isset($_FILES["imagemProduto"]) && $_FILES["imagemProduto"]['error'] === 0){
            $arquivoTmp = $_FILES['imagemProduto']['tmp_name']; 
            $nomeOriginal = $_FILES['imagemProduto']['name'];   
            
            $pastaDestino = '../view/uploads/';
            
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0755, true);
            }
            
            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
            $novoNomeImagem = md5(uniqid(rand(), true)) . '.' . $extensao;
            
            $caminhoFinal = $pastaDestino . $novoNomeImagem;
            
            if (move_uploaded_file($arquivoTmp, $caminhoFinal)) {
                $produto->imagem = $novoNomeImagem;
            } else {
                $_SESSION['msg'] = "<p class='error-msg'>Erro ao mover a imagem para o servidor.</p>";
            }
            
        } else {
            if (isset($_FILES['imagemProduto']['error']) && $_FILES['imagemProduto']['error'] !== 4) {
                $_SESSION['msg'] = "<p class='error-msg'>Erro no arquivo de imagem. Código: " . $_FILES['imagemProduto']['error'] . "</p>";
            }
        }
        
        if ($produtoDAO->cadastrarProduto($produto)){
            $_SESSION['msg'] = '<p class="success-msg">Produto cadastrado com sucesso!</p>';
            header("location:../view/visualizacao_produtos.php");
            exit;
        } else {
            $_SESSION['msg'] = '<p class="error-msg">Erro desconhecido ao salvar no banco.</p>';
            header("location:../view/cadastro_produtos.php");
            exit;
        }

        break;

    case "alterar":
        if (empty($nomeProduto)){
            $_SESSION['msg'] = "<p class='error-msg'>Ops! Insira os dados obrigatórios</p>";
            header("location:../view/visualizacao_produtos.php");
            exit;
        }
        
        $produto = new Produto();

        $produto->id_produto = $_GET['id'] ?? null;  
        $produto->id_usuario = $idUsuarioLogado;

        $produto->nome = $nomeProduto;
        $produto->quantidade = (int)$quantidadeProduto ?? 0;
        $produto->valor_unitario = $valorUnitario;
        $produto->valor_custo = $valorCusto;
        $produto->aceita_encomenda = $aceitaEncomenda;
        $produto->aceita_visualizacao = $aceitaVisualizacao;
        $produto->descricao = $descricaoProduto;
        $produto->imagem = $_POST['imagem_atual'] ?? null;

        if (isset($_FILES["imagemProduto"]) && $_FILES["imagemProduto"]['error'] === 0){
            $arquivoTmp = $_FILES['imagemProduto']['tmp_name']; 
            $nomeOriginal = $_FILES['imagemProduto']['name'];   
            
            $pastaDestino = '../view/uploads/';
            
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0755, true);
            }
            
            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
            $novoNomeImagem = md5(uniqid(rand(), true)) . '.' . $extensao;
            
            $caminhoFinal = $pastaDestino . $novoNomeImagem;
            
            if (move_uploaded_file($arquivoTmp, $caminhoFinal)) {
                $produto->imagem = $novoNomeImagem;
            } else {
                $_SESSION['msg'] = "<p class='error-msg'>Erro ao mover a imagem para o servidor.</p>";
            }
            
        } else {
            if (isset($_FILES['imagemProduto']['error']) && $_FILES['imagemProduto']['error'] !== 4) {
                $_SESSION['msg'] = "<p class='error-msg'>Erro no arquivo de imagem. Código: " . $_FILES['imagemProduto']['error'] . "</p>";
            }
        }
        
        if ($produtoDAO->alterarProduto($produto)){
            $_SESSION['msg'] = "<p class='success-msg'>Produto alterado com sucesso!</p>";
        } else {
            $_SESSION['msg'] = "<p class='error-msg'>Erro ao atualizar produto!</p>";   
        }

        header("location:../view/alteracao_produto.php");
        exit;

    case "excluir":
        $id = $_GET['id'] ?? null;

        if ($id) {
            if ($produtoDAO->excluirProduto($id)){
                $_SESSION['msg'] = "<p class='success-msg'>Produto removido com sucesso.</p>";
            } else {
                $_SESSION['msg'] = "<p class='error-msg'>Erro ao excluir produto.</p>";
            }
        }  
        
        header("location:../view/visualizacao_produtos.php");
        exit;


}
