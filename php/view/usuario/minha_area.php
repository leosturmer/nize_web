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


  <title>Minha área- Nize</title>
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
          <a href="../general/tela_inicial.php" class="link-logo" title="Tela inicial">
            <img src="../../../assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-sidenav">
          </a>
        </li>

        <li>
        <li>
          <a href="../general/tela_inicial.php" title="Tela inicial">
            <i class="bi bi-house"></i>

            <span>Tela inicial</span>

          </a>
        </li>
        <a href="../produtos/visualizacao_produtos.php" title="Tela de produtos">
          <i class="bi bi-box-seam"></i>
          <span>Produtos</span>
        </a>
        </li>
        </li>
        <a href="../pedidos/visualizacao_pedidos.php" title="Tela de pedidos">
          <i class="bi bi-clipboard2-check"></i>
          <span>Pedidos</span>
        </a>
        </li>
        </li>
        <a href="minha_area.php" class="active" title="Minha área">
          <i class="bi bi-person-lines-fill"></i>
          <span>Minha área</span>
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

    if ($usuario->nome_loja) {
      $nome_loja = $usuario->nome_loja;
    } else {
      $nome_loja = "Não informado";
    }

    if ($usuario->aceita_visualizacao == 1) {
      $view_loja = "Aberta";
    } else {
      $view_loja = "Fechada";
    }

    if ($usuario->nome_visualizacao) {
      $nome_visualizacao = $usuario->nome_visualizacao;
    } else {
      $nome_visualizacao = "Não informado";
    }

    if ($usuario->telefone) {
      $telefone = $usuario->telefone;
    } else {
      $telefone = "Não informado" . $usuario->telefone;
    }

    ?>

    <div class="main-minha-area">
      <h1>Minha área</h1>
      <div id="minha-area">
        <p>
        <h3>Seus dados atuais:</h3>
        <hr>
        <strong>Nome</strong>: <?php echo $usuario->nome ?>
        <br>
        <strong>Nome loja</strong>: <?php echo $nome_loja ?>
        <br>
        <strong>E-mail</strong>: <?php echo $usuario->login ?>
        <br>
        <strong>Visualização da loja</strong>: <?php echo $view_loja ?>
        <br>
        <strong>Link de visualização</strong>: <?php echo $nome_visualizacao ?>
        <br>
        <strong>WhatsApp</strong> (opcional): <?php echo $telefone ?>
        </p>
      </div>

      <?php
      $link_view_loja = '';
      $target = '';
      $texto_msg = '';

      if (!$usuario->nome_visualizacao || $usuario->aceita_visualizacao == 0) {

        if (!$usuario->nome_visualizacao && $usuario->aceita_visualizacao == 0) {
          $texto_msg = "sem link e sem visualização";
        } else if (!$usuario->nome_visualizacao && $usuario->aceita_visualizacao == 1) {
          $texto_msg = "sem link";
        } else if ($usuario->aceita_visualizacao == 0 && $usuario->nome_visualizacao) {
          $texto_msg = "sem visualização aberta";
        }

        $_SESSION['msg'] = "<p class='error-msg'>Loja $texto_msg! </p>";
        $link_view_loja = "alteracao_cadastro.php";
        $target = "";
      } else {
        $link_view_loja = "./view_loja.php?loja=$usuario->nome_visualizacao";
        $target = "_blank";
      }
      ?>


      <div class="usuario-btns">
        <a href="./alteracao_cadastro.php" class="btn-alterar"><span class="bi bi-pencil" style="margin-left: 0;"></span>Editar</a>

        <a href="<?php echo $link_view_loja ?>" target="<?php echo $target ?>" class="btn-alterar">Ver loja<span class="bi bi-box-arrow-up-right"></span></a>
      </div>
    </div>

    <footer><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.</a></footer>
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