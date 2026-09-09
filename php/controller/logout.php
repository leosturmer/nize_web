<?php
session_start();
$_SESSION = array();

if (ini_get("session.use_cookies")){
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
);
}

session_destroy();

// 5. Descobrir a URL base do site automaticamente pelo servidor (funciona igual em qualquer hospedagem)
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$servidor = $_SERVER['HTTP_HOST'];

$raizProjeto = ($servidor === 'localhost') ? $protocolo . $servidor . '/nize_web/' : $protocolo . $servidor . '/';

// 6. Redirecionar direto para a página de login física ou limpa
header("Location: " . $raizProjeto . "php/view/general/login.php"); 
// Nota: Se você preferir usar a rota limpa de login, basta trocar para:
// header("Location: " . $raizProjeto . "login");
exit;