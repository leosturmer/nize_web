<?php
session_start();
require_once '../../model/usuario.class.php';
require_once '../../util/seguranca.class.php';
Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

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

    <script src="https://cdn.jsdelivr.net/npm/@webcomponents/webcomponentsjs@2/webcomponents-loader.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/gh/zerodevx/zero-md@1/src/zero-md.min.js"></script>


    <title>Guia de utilização - Nize</title>
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
                    <a href="./tela_inicial.php" class="link-logo" title="Tela inicial">
                        <img src="../../../assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-sidenav">
                    </a>
                </li>

                <li>
                    <a href="./tela_inicial.php" class="active" title="Tela inicial">
                        <i class="bi bi-house"></i>
                        <span>Tela inicial</span>
                    </a>
                </li>

                <li>
                    <a href="../produtos/visualizacao_produtos.php" title="Tela de produtos">
                        <i class="bi bi-box-seam"></i>
                        <span>Produtos</span>
                    </a>
                </li>

                <li>
                    <a href="../pedidos/visualizacao_pedidos.php" title="Tela de pedidos">
                        <i class="bi bi-clipboard2-check"></i>
                        <span>Pedidos</span>
                    </a>
                </li>

                <li>
                    <a href="../usuario/minha_area.php" title="Minha área">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Minha área</span>
                    </a>
                </li>

                <li class="item-logout">
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

        <!-- <h1>Guia de utilização</h1> -->

        <zero-md src="../../../assets/guia_utilizacao.md" id="markdown"></zero-md>

        
        <footer><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.</a></footer>

        <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
    <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
    </main>

    </div>

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