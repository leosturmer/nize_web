<!DOCTYPE html>
<html lang="pt-br" style="background-color: #99d669;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nize</title>

    <link rel="shortcut icon" href="../img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/query.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <main id="main-index" class="main">

            <?php
            session_start();
            
            if (isset($_SESSION["msg"])) {
                echo "<div id='session-msg'>" . $_SESSION['msg'].  "</div>";
                unset($_SESSION["msg"]);
            }
        ?>

        <div id="container-index" class="container">

            <img src="../../img/logo/nize_new.png" alt="Nize">
            
            <h1 id="subtitulo-index">Orga<em>nize</em> suas vendas</h1>
            
            <div class="botoes-index">
                <a href="./php/view/gui_login.php">Fazer login</a>
                <a href="./php/view/gui_cadastro_usuario.php">Criar cadastro</a>
            </div>
            
        </div>

        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>

    
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