<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../dao/usuariodao.class.php';

require_once '../persistence/conexaoBanco.class.php';
require_once '../util/seguranca.class.php';
require_once '../util/validacao.class.php';

Seguranca::verificarAcesso();

$conexao = ConexaoBanco::getInstancia();

$usuario = unserialize($_SESSION['usuario_logado']);

$opcao = $_GET['op'] ?? '';

$usuarioDAO = new UsuarioDAO();

switch ($opcao){

    case "alterar":
        $novoNome = trim($_POST['usuNome']);
        $novaLoja = trim($_POST['usuLoja']) ?? "";
        $novoEmail = trim(strtolower($_POST['usuEmail']));
        $novoNomeView = trim(strtolower($_POST['usuNomeView'])) ?? "";
        $aceitaVisualizacao = $_POST['aceitaVisualizacao'] ?? 0;
        $novoTelefone = $_POST['usuTelefone'] ?? 0;

        if (empty($novoNome) || empty($novoEmail)){
            $_SESSION['msg'] = "<p class='error-msg'>Ops! Insira os dados obrigatórios</p>";
            header("location:../view/alteracao_cadastro.php");
            exit;
        }

        if (!Validacao::validarEmail($novoEmail)){
            $_SESSION['msg'] = '<p class="error-msg">E-mail em formato inválido!</p>';
            header("location:../view/alteracao_cadastro.php");
            exit;
        }

        if (!Validacao::validarTelefone($novoTelefone) && $novoTelefone !== ''){
            $_SESSION['msg'] = '<p class="error-msg">Telefone em formato inválido!</p>';
            header("location:../view/alteracao_cadastro.php");
            exit;
        }

        if ($usuario->login !== $novoEmail){
            if ($usuarioDAO->buscarEmail($novoEmail)){
            $_SESSION['msg'] = '<p class="error-msg">E-mail já cadastrado!</p>';
            header("location:../view/alteracao_cadastro.php");
            exit;
            }
        }

        if ($usuario->nome_visualizacao !== $novoNomeView){
            if ($usuarioDAO->buscarNomeView($novoNomeView)){
            // if (in_array($novoNomeView, $usuarioDAO->buscarNomeView($novoNomeView)))
            $_SESSION['msg'] = '<p class="error-msg">Nome para visualização já utilizado!</p>';
            header("location:../view/alteracao_cadastro.php");
            exit;
            }
        }

        $novoUsuario = new Usuario();

        $novoUsuario->id_usuario = $usuario->id_usuario;
        $novoUsuario->nome = $novoNome;
        $novoUsuario->nome_loja = $novaLoja;
        $novoUsuario->login = $novoEmail;
        $novoUsuario->nome_visualizacao = $novoNomeView;
        $novoUsuario->aceita_visualizacao = $aceitaVisualizacao;
        $novoUsuario->telefone = str_replace(" ", "", $novoTelefone);


        if ($usuarioDAO->alterarDados($novoUsuario)){        
            $_SESSION['usuario_logado'] = serialize($novoUsuario);    
            $_SESSION['msg'] = "<p class='success-msg'>Dados alterados com sucesso!</p>";
        } else {
            $_SESSION['msg'] = "<p class='error-msg'>Erro ao atualizar dados!</p>";   
        }

        header("location:../view/alteracao_cadastro.php");
        exit;

    case "excluir":
        $usuario = unserialize($_SESSION['usuario_logado']);

        $id = $usuario->id_usuario ?? null;

        if ($id) {
            if ($usuarioDAO->excluirUsuario($id)){
                $_SESSION['msg'] = "<p class='success-msg'>Espero que seja um até breve :(</p>";
                header("location:../../index.php");
                exit;
            } else {
                $_SESSION['msg'] = "<p class='error-msg'>Pane no sistema! Algo deu errado.</p>";
                header("location:../../index.php");
                exit;
            }
        }  
        
        header("location:../../index.php");
        exit;
    }