<!DOCTYPE html>
<html lang="pt-br" style="background-color: #99d669;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../../img/nize_favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/query.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <main class="main">

        <?php
            session_start();
            
            if (isset($_SESSION["msg"])) {
                echo $_SESSION['msg'];
                unset($_SESSION["msg"]);
            }
        ?>

        <img src="../../img/logo/nize_border.png" alt="Nize" class="logo-inicio">


        <div class="container container-login">
            <h1>
                Bora logar?
            </h1>
            
            <div class="div-login">
                <form action="../controller/loginControle.php" method="post" id="form-login">
                    <label for="email">E-mail:</label>
                    <input type="email" placeholder="e-mail" class="input-login" name="txtemail" required>
                    <label for="senha"> Senha:</label>
                    <input type="password" placeholder="senha" class="input-login" name="txtsenha" required>
                    <button type="submit">Fazer login</button>
                </form>
            </div>
        </div>

        <a href="gui_cadastro_usuario.php" id="btn-login">Não se cadastrou?</a>
        
        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>

    
</body>
</html>