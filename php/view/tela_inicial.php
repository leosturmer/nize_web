<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../util/seguranca.class.php';
Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="../../img/favicon/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/query.css">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/sidebar.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">



  <title>Início</title>
</head>

<body>
  <aside>
    <nav>
      <ul>
        <li>
          <a href="#" data-resize-btn class="btn-menu">
            <i class="bi bi-list"></i>
            <span>Esconder menu</span>
          </a>
        </li>

        <li>
          <a href="tela_inicial.php" class="link-logo">
            <img src="../../img/logo/nize_new.png" alt="Nize logotipo" id="logo-sidenav">
          </a>
        </li>

        <li>
        <li>
          <a href="tela_inicial.php" class="active">
            <i class="bi bi-house"></i>

            <span>Tela inicial</span>

          </a>
        </li>
        <a href="gui_visualizacao_produtos.php">
          <i class="bi bi-box-seam"></i>
          <span>Produtos</span>
        </a>
        </li>
        </li>
        <a href="gui_visualizacao_pedidos.php">
          <i class="bi bi-clipboard2-check"></i>
          <span>Pedidos</span>
        </a>
        </li>
        </li>
        <a href="gui_minha_area.php">
          <i class="bi bi-person-lines-fill"></i>
          <span>Minha área</span>
        </a>
        </li>
        <li>
          <a href="../controller/logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Encerrar sessão</span>
          </a>
        </li>
      </ul>
    </nav>
  </aside>

  <!-- <div class="conteudo-pagina"> -->

  <main class='conteudo-pagina'>
    <?php
    if (isset($_SESSION["msg"])) {
      echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
      unset($_SESSION["msg"]);
    }
    ?>

    <h1 id="tituloInicial">
      Orga<em>nize</em> seus pedidos
    </h1>

    <div class="container-inicial">
      <p>
        <?php
        if (!empty($usuario->loja)) {
          echo "Olá, <strong>$usuario->nome</strong>, da loja <strong>$usuario->loja</strong>.";
        } else {
          echo "Olá, <strong>" . $usuario->nome . "</strong>.";
        }
        ?>
      </p>
      <p>Utilize o menu para navegar pelo site!</p>
      <p>Aqui vai um resumo do que você pode fazer:</p>
      <p><strong>Produtos</strong>: faça o cadastro dos produtos que você produz e/ou vende. Visualize e altere todos eles!</p>
      <p><strong>Pedidos</strong>: organize seus pedidos, encomendas e vendas com os produtos cadastrados.</p>
      <p><strong>Minha área</strong>: acesse esta área para alterar os seus dados. Nesta área você pode disponibilizar a visualização pública da sua loja.</p>

      <h2 style="text-align: center;">Boas vendas!</h2>
    </div>
    <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
  </main>

  </div>

  <script>
    const msgElement = document.getElementById('session-msg');

    if (msgElement) {
      setTimeout(() => {
        msgElement.style.display = 'none';
      }, 6000);
    }
  </script>

  <!-- Acessibilidade -->

  <div vw class="enabled">
    <div vw-access-button></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
  </script>
  <script>
    const resizeBtn = document.querySelector("[data-resize-btn]");

    resizeBtn.addEventListener("click", function(e) {
      e.preventDefault();
      document.body.classList.toggle("sb-expanded");
    });
  </script>
</body>

</html>