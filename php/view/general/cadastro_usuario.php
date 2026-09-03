<!DOCTYPE html>
<html lang="pt-br" style="background-color: #99d669;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../../../assets/img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../../assets/css/variables.css">
    <link rel="stylesheet" href="../../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../../assets/css/components.css">
    <link rel="stylesheet" href="../../../assets/css/responsive.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <title>Cadastro- Nize</title>
</head>



<body>

    <main id="main-index">

        <?php
        session_start();

        if (isset($_SESSION["msg"])) {
            echo "<div id='session-msg' class='msg-deslog'>" . $_SESSION['msg'] .  "</div>";
            unset($_SESSION["msg"]);
        }
        ?>

        <a href="../../../index.php" class="link-logo-header logo-header-mobile" title="Tela inicial">
            <img src="../../../assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-header">
        </a>

        <div class="container container-cadastro">
            <h1 id="titulo-cadastro">
                Faça o seu cadastro
            </h1>
            <div class="div-cadastro">
                <form action="../../controller/cadastroControle.php?op=cadastrar" method="post" id="form-cadastro">
                    <label for="usuNome">Nome completo*</label>

                    <input type="text" placeholder="digite seu nome" class="input-login" name="usuNome" autocomplete="off" maxlength="50" required>

                    <label for="usuLoja">Nome da loja (opcional)</label>
                    <input type="text" placeholder="nome  da loja" class="input-login" name="usuLoja" autocomplete="off" maxlength="50">


                    <label for="usuEmail">E-mail*</label>
                    <input type="email" placeholder="e-mail" class="input-login" name="usuEmail" autocomplete="off" maxlength="50" required>
                    
                    <label for="usuSenha">Senha*</label>
                    <input type="password" placeholder="senha" class="input-login" name="usuSenha" autocomplete="off" minlength="8" maxlength="26" required>
                    <p>Mín. 8 caracteres: 1 maiúscula, 1 minúscula e 1 número.</p>

                    <label for="confirmaSenha" style="margin-top: 0px;">Repita a senha*</label>
                    <input type="password" placeholder="repita a senha" class="input-login" name="confirmaSenha" autocomplete="off" minlength="8" maxlength="26" required>


                    <button type="submit" id="btn-cad-usuario">Cadastrar</button>

                    <!-- <p>Ao se cadastrar, você concorda com nossos Termos de Uso.</p> -->
                </form>
            </div>

        </div>

        <a href="login.php" id="btn-login">Já tem cadastro?</a>

        <footer class="footer-index"><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.</a></footer>
        <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
    </main>

    <script type="module" src="../../../js/main.js"></script>

    <!-- Acessibilidade -->

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