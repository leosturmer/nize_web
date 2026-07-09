<?php
session_start();

if (!empty($_SESSION['usuario_logado'])) {
    $logo_link = "tela_inicial.php";
} else {
    $logo_link = "../../index.php";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro</title>

    <link rel="shortcut icon" href="../../img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/query.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
</head>

<body>

    <aside id="sidebar">
        <a href="<?php echo $logo_link ?>" class="link-logo" title="Tela inicial">
            <img src="../../img/logo/nize_new.png" alt="Nize" id="logo-sidenav-view">
        </a>
    </aside>

   

    <main class='conteudo-pagina'>
        <h1 class="titulo-erro">Ops! Algo deu errado</h1>

        <div class="container-inicial container-erro">
            <p>Alguma operação causou erro.</p>

            <p>Vamos tentar de novo?</p>
        </div>

        <a href="<?php echo $logo_link ?>" class="btn-voltar-erro">Voltar para o sistema</a>



        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>

    <script type="module" src="../../js/main.js"></script>


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