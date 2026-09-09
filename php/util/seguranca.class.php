<?php
require_once __DIR__ . '/../config.php';

class Seguranca
{
    public static function verificarAcesso()
    {
        if (!isset($_SESSION['usuario_logado'])) {
            header("location:" . BASE_URL . "erro?msg=Acesso negado. Por favor, realize o login para acessar esta área.");
            exit;
        }
    }

    public static function verificarAdministrador()
    {
        $usuario = unserialize($_SESSION['usuario_logado']);

        $tipoUsuario = (int) ($usuario->tipoUsuario ?? 0);

        if ($tipoUsuario != 1) {
            header("location:" . BASE_URL . "erro?msg=Acesso negado. Por favor, realize o login para acessar esta área.");
            exit;
        }
    }
}
