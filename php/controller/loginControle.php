<?php
// 1 - Preparação do ambiente
session_start();
require_once '../model/usuario.class.php';
require_once '../dao/usuariodao.class.php';
require_once '../persistence/conexaoBanco.class.php';

// 2 - Captura de dados
$login = trim(strtolower($_POST['txtemail'])) ?? '';
$senha_digitada = trim($_POST['txtsenha']) ?? '';

if (empty($login) || empty($senha_digitada)) {
    header("location:../view/gui_erro.php?msg=Por favor, preencha todos os campos.&$login&$senha_digitada");
    exit;
}

// 3 - Consulta ao Banco
$conexao = ConexaoBanco::getInstancia();
// $sql = $conexao->prepare("SELECT * FROM usuario WHERE login = ? AND senha = ?");
// $sql->execute([$login, $senha_digitada]);
// $dados = $sql->fetch();

$sql = $conexao->prepare("SELECT * FROM usuario WHERE login = ?");
$sql->execute([$login]);

$dados = $sql->fetch();

if (password_verify($senha_digitada, $dados['senha'])) {
    $usuario = new Usuario();
    $usuario->id_usuario = $dados['id_usuario'];
    $usuario->login = $dados['login'];
    $usuario->nome  = $dados['nome'];
    $usuario->nome_loja = $dados['nome_loja']; 
    $usuario->aceita_visualizacao = $dados['aceita_visualizacao']; 
    $usuario->nome_visualizacao = $dados['nome_visualizacao'] ?? "";

    $_SESSION['usuario_logado'] = serialize($usuario);
    $_SESSION['msg'] = "<p class='success-msg'>Login realizado com sucesso!</p>";

    $nomeURL = $usuario->nome;
    $lojaURL = $usuario->nome_loja;


    header("location:../view/tela_inicial.php?nome=$nomeURL&loja=$lojaURL");
    exit;
} else {
    $_SESSION['msg'] = "<p class='error-msg'>Usuário ou senha inválidos.</p>";
    header("location:../view/gui_login.php");
}

// 4 - Instância e Sessão
// if($dados){
//     $usuario = new Usuario();
//     $usuario->id_usuario = $dados['id_usuario'];
//     $usuario->login = $dados['login'];
//     $usuario->nome  = $dados['nome'];
//     $usuario->loja = $dados['nome_loja']; 

//     $_SESSION['usuario_logado'] = serialize($usuario);
//     $_SESSION['msg'] = "<p class='success-msg'>Login realizado com sucesso!</p>";

//     $nomeURL = $usuario->nome;
//     $lojaURL = $usuario->loja;


//     header("location:../view/tela_inicial.php?nome=$nomeURL&loja=$lojaURL");
//     exit;

// } else {
//     $usuario = new Usuario();

//     $usuarioDAO = new UsuarioDAO();

//     $usuario = $usuarioDAO->buscarEmail($dados['login']);

//     if ($usuario != null) {
//         $senhaHash = $usuario->senha;


//         if (password_verify($senha_digitada, $senhaHash)){
//             $_SESSION['usuario_logado'] = serialize($usuario);
//             $_SESSION['msg'] = "<p class='success-msg'>Login realizado com sucesso!</p>";
        
//             $nomeURL = $usuario->nome;
//             $lojaURL = $usuario->loja;

//             header("location:../view/tela_inicial.php?nome=$nomeURL&loja=$lojaURL");
//             exit;

//         }

//     }



//     $_SESSION['msg'] = "<p class='error-msg'>Usuário ou senha inválidos.</p>";
//     header("location:../view/gui_login.php");
// }
// ?>