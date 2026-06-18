<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../dao/usuariodao.class.php';

require_once '../persistence/conexaoBanco.class.php';
require_once '../util/validacao.class.php';


$nome = $_POST['usuNome'];
$nome_loja = $_POST['usuLoja'];
$login = $_POST['usuEmail'];
$senha = $_POST['usuSenha'];

$opcao = $_GET['op']  ?? '';

switch ($opcao):
    case "cadastrar":
        $nome = trim($_POST['usuNome']) ?? "";
        $nome_loja = trim($_POST['usuLoja']) ?? "";
        $email = trim(strtolower($_POST['usuEmail'])) ?? "";
        $senha_digitada = trim($_POST['usuSenha']) ?? "";

        if (empty($nome) || empty($email) || empty($senha)) {
            $_SESSION['msg'] = '<p class="error-msg">Digite todos os campos obrigatórios!</p>';
            header("location:../view/gui_cadastro_usuario.php");
            exit;
        }

        if (!Validacao::validarEmail($email)){
            $_SESSION['msg'] = '<p class="error-msg">E-mail em formato inválido!</p>';
            header("location:../view/gui_cadastro_usuario.php");
            exit;
        }

        if (!Validacao::validarSenha($senha_digitada)){
            $_SESSION['msg'] = '<p class="error-msg">Senha precisa ter no mínimo 8 caracteres, 1 maiúscula, 1 minúscula e 1 número!</p>';
            header("location:../view/gui_cadastro_usuario.php");
            exit;
        }

        $usuarioDAO = new UsuarioDAO();

        // if ($usuarioDAO->buscarEmail($email) === false) {
            
        // }
        
        $senhaCriptografada = password_hash($senha_digitada, PASSWORD_DEFAULT);

        $novoUsuario = new Usuario();
        // $novoUsuario->id_usuario = $novoUsuario->id_usuario;
        $novoUsuario->nome = $nome;
        $novoUsuario->nome_loja = $nome_loja;
        $novoUsuario->login = $email;
        $novoUsuario->senha = $senhaCriptografada;


        if ($usuarioDAO->cadastrarUsuario($novoUsuario)) {
            $_SESSION['msg'] = '<p class="success-msg">Oba! Tudo certo com o seu cadastro!</p>';
            header("location:../view/gui_login.php");
            exit;
        } else {
            $_SESSION['msg'] = '<p class="error-msg">E-mail já cadastrado!</p>';
            header("location:../view/gui_cadastro_usuario.php");
            exit;
        }


    endswitch;