<?php
require_once __DIR__ . '/../../config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br" style="background-color: var(--lightGreen);">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>assets/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/variables.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/components.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/responsive.css">
</head>

<body>
    <main id="main-index">

        <?php
        if (isset($_SESSION["msg"])) {
            echo "<div id='session-msg' class='msg-deslog'>" . $_SESSION['msg'] .  "</div>";
            unset($_SESSION["msg"]);
        }
        ?>



        <a href="<?php echo BASE_URL; ?>" class="link-logo-header logo-header-mobile" title="Tela inicial">
            <img src="<?php echo BASE_URL; ?>assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-header">
        </a>


        <div class="container container-login">
            <h1 id="titulo-login">
                Bora logar?
            </h1>

            <div class="div-login">
                <form action="<?php echo BASE_URL; ?>php/controller/loginControle.php" method="post" id="form-login">
                    <label for="email">E-mail:</label>
                    <input type="email" placeholder="e-mail" class="input-login" name="txtemail" autocomplete="off" maxlength="50" required>

                    <div class="div-senha">
                        <label for="senha"> Senha:</label>
                        <i class="bi bi-eye-fill" id="eye-senha" onclick="mostrarSenha()"></i>
                    </div>

                    <input type="password" placeholder="senha" id="senha" class="input-login" name="txtsenha" autocomplete="off" minlength="8" maxlength="26" required>
                    <button type="submit">Entrar</button>
                </form>
            </div>
        </div>

        <a href="<?php echo BASE_URL; ?>cadastro_usuario" id="btn-login">Não se cadastrou?</a>

        <footer class="footer-index"><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.</a></footer>
        <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
    </main>

    <script type="module" src="<?php echo BASE_URL; ?>js/main.js"></script>

    <script>
        function mostrarSenha() {
            var inputPass = document.getElementById("senha")
            var btnShowPass = document.getElementById("eye-senha")

            if (inputPass.type === "password") {
                inputPass.setAttribute("type", "text")
                btnShowPass.classList.replace("bi-eye-fill", "bi-eye-slash-fill")
            } else {
                inputPass.setAttribute("type", "password")
                btnShowPass.classList.replace("bi-eye-slash-fill", "bi-eye-fill")
            }
        }
    </script>


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