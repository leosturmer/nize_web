<?php
session_start();
require_once '../../model/usuario.class.php';
require_once '../../util/seguranca.class.php';
require_once '../../dao/usuariodao.class.php';

// Seguranca::verificarAcesso();
Seguranca::verificarAdministrador();

$usuario = unserialize($_SESSION['usuario_logado']);

$usuarioDAO = new UsuarioDAO();

$lista_usuarios = $usuarioDAO->buscarUsuarios();

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../../../assets/img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../../assets/css/variables.css">
    <link rel="stylesheet" href="../../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../../assets/css/components.css">
    <link rel="stylesheet" href="../../../assets/css/responsive.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <title>Tela do aministrador - Nize</title>
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
                    <a href="#" class="link-logo" title="Tela inicial">
                        <img src="../../../assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-sidenav">
                    </a>
                </li>


                <li>
                    <a href="../../controller/logout.php" class="btn-sair" title="Sair">
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
            <a href="../general/tela_inicial.php" class="link-logo-header" title="Tela inicial">
                <img src="../../../assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-header">
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

        <h1 class="h1-admin">Tela administrador</h1>

        <div class="filters-admin">
            <form onsubmit="return false;" id="form-pesquisa-usuarios" class="form-pesquisa-usuarios">
                <input type="text" id="pesquisa-usuarios" placeholder="Busque pelo nome ou e-mail" autocomplete="off" maxlength="50">
            </form>

            <details class="filtros-produtos">
                <summary><span class="bi bi-filter"></span>Ordenar por</summary>

                <select id="filtro-order">
                    <option value="">Ordenar por</option>
                    <option value="nome-asc">Nome (crescente)</option>
                    <option value="nome-desc">Nome (decrescente)</option>
                    <option value="email-asc">E-mail (crescente)</option>
                    <option value="email-desc">E-mail (decrescente)</option>
                </select>
                <button type="button" id="btn-limpar-filtros"><span class="bi bi-arrow-clockwise"></span>Limpar</button>
            </details>
        </div>

        <div class="main-administrador">
            <div id="lista_usuarios_cadastrados">
                <?php
                foreach ($lista_usuarios as $usuarioCadastrado):
                    if ((int)$usuarioCadastrado['tipo_usuario'] !== 1):
                ?>
                        <div class='usuario_cadastrado'>
                            <div class="texto-users">
                                <p>
                                    Nome: <?php echo $usuarioCadastrado['nome'] ?> <br>
                                    E-mail: <?php echo $usuarioCadastrado['login'] ?> <br>
                                </p>
                            </div>
                            <div class="btns-admin-user">
                                <form action="../../controller/usuarioControle.php?op=excluirUsuario&id=<?php echo $usuarioCadastrado['id_usuario'] ?>" method="post" onclick="return confirm('Deseja mesmo excluir?\n\nESSA AÇÃO NÃO PODE SER DESFEITA.');">
                                    <input type="hidden" name="id" value="<?php echo $usuarioCadastrado['id_usuario']; ?>" autocomplete="off">
                                    <button class="btn-excluir" type="submit"><span class="bi bi-trash3"></span>Excluir</button>
                                </form>
                            </div>
                        </div>
                        <hr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

        </div>

        <footer><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.</a></footer>
        <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
    </main>

    <script type="module" src="../../../js/main.js"></script>
    <script type="module" src="../../../js/busca_usuario.js"></script>

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