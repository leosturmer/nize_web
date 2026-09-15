<?php
session_start();
require_once '../../model/usuario.class.php';
require_once '../../persistence/conexaoBanco.class.php';
require_once '../../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>assets/img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/variables.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/components.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/responsive.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <title>Alteração de cadastro- Nize</title>
</head>



<body>
    <aside id="sidebar">
        <nav>
            <ul>
                <li>
                    <a href="#" data-resize-btn class="btn-menu" title="Esconder/expandir menu">
                        <i class="bi bi-list"></i>

                    </a>
                </li>

                <li>
                    <a href="<?php echo BASE_URL; ?>admin" class="link-logo" title="Tela inicial">
                        <img src="<?php echo BASE_URL; ?>assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-sidenav">
                    </a>
                </li>

                <li>
                    <a href="<?php echo BASE_URL; ?>admin" title="Gerenciar usuários">
                        <i class="bi bi-person-gear"></i>

                        <span>Dashboard</span>

                    </a>
                </li>

                <li>
                    <a href="<?php echo BASE_URL; ?>area_admin" title="Dados do admin">
                        <i class="bi bi-person-lines-fill"></i>

                        <span>Dados do admin</span>

                    </a>
                </li>

                <li>
                    <a href="<?php echo BASE_URL; ?>php/controller/logout.php" class="btn-sair" title="Sair">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Encerrar sessão</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <header id="header-mobile">
        <div class="container-header">
            <a href="#" data-resize-btn-mobile class="btn-menu" title="Esconder/expandir menu">
                <i class="bi bi-list"></i>
            </a>
            <a href="<?php echo BASE_URL; ?>tela_inicial" class="link-logo-header" title="Tela inicial">
                <img src="<?php echo BASE_URL; ?>assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-header">
            </a>
        </div>
    </header>

    <main class='conteudo-pagina'>
        <a id="top"></a>

        <?php
        if (isset($_SESSION["msg"])) {
            echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
            unset($_SESSION["msg"]);
        }
        ?>

        <div class="internal-nav">
            <div class="internal-nav-links">
                <h1>Alteração de senha</h1>
                <a href="<?php echo BASE_URL; ?>admin" title="Tela Minha Área"><span class="bi bi-arrow-left"></span>Voltar</a>
            </div>
        </div>

        <div class="container-horizontal">
            <div id="novos-dados" class="alt-senha">
                <h3>Alterar dados</h3>
                <form action="<?php echo BASE_URL; ?>php/controller/usuarioControle.php?op=altDadosAdmin" method="post" id="form-cadastro">
                    <label for="usuNome">Nome completo*</label>
                    <input type="text" placeholder="digite seu nome" class="input-login" name="usuNome" value="<?php echo $usuario->nome ?>" autocomplete="off" maxlength="50" required>
                    <label for="usuEmail">E-mail*</label>
                    <input type="email" placeholder="e-mail" class="input-login" name="usuEmail" value=<?php echo $usuario->login ?> autocomplete="off" maxlength="50" required>
                    <div class="container-horizontal cadastro-btns">
                        <button type="submit" class="btn-salvar"><span class="bi bi-check2"></span>Alterar</button>
                    </div>
                </form>
            </div>
            <div class="alt-senha">
                <h3>Altere sua senha</h3>
                <p class="p-inicial">Mínimo de 8 caracteres: 1 maiúscula, 1 minúscula e 1 número.</p>
                <hr>
                <form action="<?php echo BASE_URL; ?>php/controller/usuarioControle.php?op=altSenhaAdmin" class="alterar-senha" method="post">
                    <div class="div-senha">
                        <div class="div-senha div-senha-eye">
                            <label for="senhaAtual">Senha atual</label>
                            <i class="bi bi-eye-fill" id="eye-senha" onclick="mostrarSenha()"></i>
                        </div>
                        <input type="password" placeholder="sua senha atual" class="input-login" id="senha" name="senhaAtual" autocomplete="off" minlength="8" maxlength="26" required>
                    </div>
                    <div class="div-senha">
                        <label for="novaSenha">Nova senha</label>
                        <input type="password" placeholder="nova senha" class="input-login" id="senha-2" name="novaSenha" autocomplete="off" minlength="8" maxlength="26" required>
                    </div>
                    <div class="div-senha">
                        <label for="repNovaSenha">Confirmar nova senha</label>
                        <input type="password" placeholder="nova senha" class="input-login" id="senha-3" name="repNovaSenha" autocomplete="off" minlength="8" maxlength="26" required>
                    </div>
                    <div class="container-horizontal cadastro-btns">
                        <button type="submit" class="btn-salvar"><span class="bi bi-check2"></span>Alterar</button>
                        <button type="reset"><span class="bi bi-arrow-clockwise"></span>Limpar</button>
                    </div>
                </form>
            </div>
        </div>

        <footer><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.</a></footer>
        <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
    </main>

    </div>

    <script type="module" src="<?php echo BASE_URL; ?>js/main.js"></script>

    <script>
        function mostrarSenha() {
            var inputPass = document.getElementById("senha")
            var inputPass2 = document.getElementById("senha-2")
            var inputPass3 = document.getElementById("senha-3")
            var btnShowPass = document.getElementById("eye-senha")

            if (inputPass.type === "password") {
                inputPass.setAttribute("type", "text")
                inputPass2.setAttribute("type", "text")
                inputPass3.setAttribute("type", "text")
                btnShowPass.classList.replace("bi-eye-fill", "bi-eye-slash-fill")
            } else {
                inputPass.setAttribute("type", "password")
                inputPass2.setAttribute("type", "password")
                inputPass3.setAttribute("type", "password")
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