<?php
session_start();

if (!empty($_SESSION['usuario_logado'])) {
    $estaLogado = true;
    $logo_link = "tela_inicial.php";
} else {
    $estaLogado = false;
    $logo_link = "../../index.php";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajuda - Nize</title>

    <link rel="shortcut icon" href="../../img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../../css/normalize.css">
    <link rel="stylesheet" href="../../../css/query.css">
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="../../../css/sidebar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

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
                    <a href="<?php echo $logo_link ?>" class="link-logo" title="Tela inicial">
                        <img src="../../../img/logo/nize_new.png" alt="Nize logotipo" id="logo-sidenav">
                    </a>
                </li>

                <li>
                    <?php if ($estaLogado): ?>

                <li>
                    <a href="<?php echo $logo_link ?>" title="Tela inicial">
                        <i class="bi bi-house"></i>

                        <span>Tela inicial</span>

                    </a>
                </li>
                <a href="visualizacao_produtos.php" class="active" title="Tela de produtos">
                    <i class="bi bi-box-seam"></i>
                    <span>Produtos</span>
                </a>
                </li>
                </li>
                <a href="visualizacao_pedidos.php" title="Tela de pedidos">
                    <i class="bi bi-clipboard2-check"></i>
                    <span>Pedidos</span>
                </a>
                </li>
                </li>
                <a href="minha_area.php" title="Minha área">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>Minha área</span>
                </a>
                </li>
                <li>
                    <a href="../controller/logout.php" class="btn-sair" title="Sair">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Encerrar sessão</span>
                    </a>
                </li>
            <?php else: ?>
                </li>
                <a href="cadastro_usuario.php" title="Criar cadastro">
                    <i class="bi bi-person-add"></i>
                    <span>Cadastre-se</span>
                </a>
                </li>
                </li>
                <a href="login.php" title="Fazer login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Fazer login</span>
                </a>
                </li>
            <?php endif; ?>
            </ul>
        </nav>
    </aside>

    <header id="header-mobile">
        <div class="container-header">
            <a href="#" data-resize-btn-mobile class="btn-menu" title="Esconder/expandir menu">
                <i class="bi bi-list"></i>
            </a>
            <a href="tela_inicial.php" class="link-logo-header" title="Tela inicial">
                <img src="../../../img/logo/nize_new.png" alt="Nize logotipo" id="logo-header">
            </a>
        </div>
    </header>

    <main class='conteudo-pagina'>

        <h1 id="tituloInicial">Termos de uso</h1>

        <h2>Termos de uso do Nize</h2>

        <details class="termos-uso container-inicial">
            <summary>Termos de uso</summary>
            <p>O nome "Nize" vem da palavra "organize", já que essa plataforma é uma forma de vendedores autônomos organizarem os seus produtos e pedidos.</p>
            <h3>1. Aceitação dos termos</h3>
            <p>Ao criar um cadastro conosco, você está ciente que aceita os termos de uso presentes nesta página. Caso não aceite, você não poderá utilizar a plataforma.</p>
            <h3>2. Uso do site</h3>
            <p>O usuário se compromete a usar o site apenas para fins legais. É proibido tentar invadir o sistema, enviar vírus, copiar conteúdos de forma ilegal ou prejudicar o funcionamento da página.</p>
            <h3>3. Propriedade Intelectual</h3>
            <p>Todo o conteúdo do site (textos, imagens, logotipos, marcas e códigos) pertence aos donos do site. Você não pode copiar ou usar esses materiais sem autorização prévia por escrito.</p>
            <h3>4. Alterações nos Termos</h3>
            <p>Podemos mudar estes termos a qualquer momento. A versão mais nova estará sempre publicada nesta mesma página, com a data de atualização.</p>
            <h3>5. Lei e Foro</h3>
            <p>Estes termos seguem as leis do Brasil. Qualquer problema ou dúvida será resolvido no foro da cidade onde a empresa está localizada.</p>
        </details>

        <details class="faq container-inicial">
            <summary>Perguntas frequentes</summary>
            <h3>1. Preciso de ajuda. Como fazer?</h3>
            <p>Para ajuda, você deve entrar em contato com nosso suporte via e-mail <a href="#">clicando aqui</a> ou através do e-mail sac@nize.com.br</p>
            <h3>2. Esqueci minha senha. E agora?</h3>

        </details>


        <a href="<?php echo $logo_link ?>" class="btn-voltar-erro"><span class="bi bi-arrow-left"></span>Voltar</a>



        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
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