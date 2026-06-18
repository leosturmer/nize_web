<?php
class Seguranca {
    public static function verificarAcesso(){
        if(!isset($_SESSION['usuario_logado'])) {
            header("location:../view/gui_erro.php?msg=Acesso negado. Por favor, realize o login para acessar esta área.");
            exit;
        }
    }
}
?>