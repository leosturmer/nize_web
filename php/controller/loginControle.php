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
    header("location:../view/erro.php?msg=Por favor, preencha todos os campos.&$login&$senha_digitada");
    exit;
}

// 3 - Consulta ao Banco
$conexao = ConexaoBanco::getInstancia();

$sql = $conexao->prepare("SELECT * FROM usuario WHERE login = ?");
$sql->execute([$login]);

$dadosUsuario = $sql->fetch(PDO::FETCH_ASSOC);

if ($dadosUsuario) {
    $senhaValida = false;
    $tipoUsuario = (int) ($dadosUsuario['tipo_usuario'] ?? 0);

    if ($tipoUsuario === 1) {
        $senhaValida = ($senha_digitada === $dadosUsuario['senha']);
    } else {
        $senhaValida = password_verify($senha_digitada, $dadosUsuario['senha']);
    }

    if ($senhaValida) {
        $usuario = new Usuario();
        $usuario->id_usuario = $dadosUsuario['id_usuario'];
        $usuario->login = $dadosUsuario['login'];
        $usuario->nome  = $dadosUsuario['nome'];
        $usuario->nome_loja = $dadosUsuario['nome_loja'];
        $usuario->aceita_visualizacao = $dadosUsuario['aceita_visualizacao'];
        $usuario->nome_visualizacao = $dadosUsuario['nome_visualizacao'] ?? "";
        $usuario->tipoUsuario = $tipoUsuario;

        $_SESSION['usuario_logado'] = serialize($usuario);
        $_SESSION['msg'] = "<p class='success-msg'>Login realizado com sucesso!</p>";

        if ($tipoUsuario === 1) {
            header("Location: ../view/dashboard_administrador.php");
            exit;
        } else {
            $nomeURL = urlencode($usuario->nome);
            $lojaURL = urlencode($usuario->nome_loja);

            header("Location: ../view/tela_inicial.php?nome=$nomeURL&loja=$lojaURL");
            exit;
        }
    }
}

$_SESSION['msg'] = "<p class='error-msg'>Usuário ou senha inválidos.</p>";
header("Location: ../view/login.php");
exit;