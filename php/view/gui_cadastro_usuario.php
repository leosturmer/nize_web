<!DOCTYPE html>
<html lang="pt-br" style="background-color: #99d669;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../../../img/nize_favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/query.css">
    <link rel="stylesheet" href="../../css/style.css">

    <title>Cadastro</title>
</head>
<body >
    <!-- <header>
        Nize - Organize suas pedidos
    </header> -->

    <main class="main">

    <?php
    session_start();
    
            if (isset($_SESSION["msg"])) {
                echo $_SESSION['msg'];
                unset($_SESSION["msg"]);
            }
        ?>
        
        <div class="container container-cadastro">
            <h1 id="titulo-cadastro">
                Faça o seu cadastro
            </h1>
            <div class="div-cadastro">
                <form action="../controller/cadastroControle.php?op=cadastrar" method="post" id="form-cadastro">
                    <label for="usuNome">Nome completo*</label>
                        
                        <input type="text" placeholder="digite seu nome" class="input-login" name="usuNome" required>

                    <label for="usuLoja">Nome da loja (opcional)</label>
                        <input type="text" placeholder="nome  da loja" class="input-login" name="usuLoja">
                    

                    <label for="usuEmail">E-mail*</label>
                        <input type="email" placeholder="e-mail" class="input-login" name="usuEmail" required>
                    
                    <label for="usuSenha">Senha*</label>
                    <input type="password" placeholder="senha" class="input-login" name="usuSenha" required>
                    <p>8 caracteres (no mínimo 1 maiúscula, 1 minúscula e 1 número)</p>
                    
                    
                    <button type="submit" id="btn-cad-usuario">Cadastre-se</button>
                </form>
            </div>
            
        </div>
        
        <a href="gui_login.php" id="btn-login">Já tem cadastro?</a>

        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>

    
</body>
</html>