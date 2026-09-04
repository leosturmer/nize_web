<?php
session_start();

if (isset($_SESSION['usuario_logado'])){
    header("location:./php/view/general/tela_inicial.php");
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nize- Organize seus pedidos</title>

    <link rel="shortcut icon" href="./assets/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="./assets/css/variables.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">
    <link rel="stylesheet" href="./assets/css/components.css">
</head>

<body>
    <main id="main-index">

        <?php
        if (isset($_SESSION["msg"])) {
            echo "<div id='session-msg' class='msg-deslog'>" . $_SESSION['msg'] .  "</div>";
            unset($_SESSION["msg"]);
        }
        ?>

        <div id="container-index" class="container">

            <img src="./assets/img/logo/nize_new.png" alt="Nize">

            <h1 id="subtitulo-index">Orga<em>nize</em> suas vendas</h1>

            <div class="botoes-index">
                <a href="./php/view/general/login.php">Fazer login</a>
                <a href="./php/view/general/cadastro_usuario.php">Cadastre-se</a>
            </div>

        </div>

        <footer class="footer-index"><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.
            </a></footer>
        <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
    </main>


    <script type="module" src="./js/main.js"></script>

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>


</body>

</html>