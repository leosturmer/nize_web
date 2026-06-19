<?php
session_start();
require_once '../model/usuario.class.php';

require_once '../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../../img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/query.css">
    <link rel="stylesheet" href="../../css/style.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=dehaze" />


    <title>Nize - Minha área</title>
</head>
<body>
    <details class="coll-sidenav" open>
        <summary><span class="material-symbols-outlined">dehaze</span></summary>
        <div class="sidenav">
            <img src="../../img/logo/nize_new.png" alt="Nize" id="logo-sidenav">
            <a href="tela_inicial.php">Tela inicial</a>
            <a href="gui_visualizacao_produtos.php">Produtos</a>
            <a href="gui_visualizacao_pedidos.php">Pedidos</a>
            <a href="gui_minha_area.php">Minha área</a>
            <a href="../controller/logout.php" id="btn-sair">Encerrar sessão</a>
        </div>
    </details>
    
    <div class="conteudo-pagina">
    
    <main>
        <?php
        if (isset($_SESSION["msg"])) {
        echo "<div id='session-msg'>" . $_SESSION['msg'].  "</div>";
        unset($_SESSION["msg"]);
        }
        ?>

        <h1>Minha área</h1>

        <div id="minha-area">
            <p>
            Nome: <?php echo $usuario->nome ?>

            <?php if ($usuario->nome_loja) {
                echo "Nome da loja: $usuario->nome_loja";
                } ?>

            E-mail: <?php echo $usuario->login ?>
            </p>

        </div>
        
        <a href="./gui_alteracao_cadastro.php" class="btn-alterar">Alterar cadastro</a>

        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>


    </div>

    <script>
    const msgElement = document.getElementById('session-msg');

        if (msgElement) {
            setTimeout(() => {
                msgElement.style.display = 'none'; 
            }, 6000);
        }
    </script>
</body>
</html>