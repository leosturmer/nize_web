<?php
// 1. Iniciar a sessão
session_start();

// 2. Limpar as variáveis
$_SESSION = array();

// 3. Matar a sessão e limpar os cookie da sessão
if (ini_get("session.use_cookies")){
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
);
}

// 4. Destruir a sessão no servidor
session_destroy();

// 5. Redirecionar para raiz
header("location:../../index.html");
exit;
?>