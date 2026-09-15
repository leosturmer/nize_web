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


  <title>Dados do administrador - Nize</title>
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
        <h1>Dados do administrador</h1>
        <a href="<?php echo BASE_URL; ?>admin" title="Tela Minha Área"><span class="bi bi-arrow-left"></span>Voltar</a>
      </div>
    </div>

    <div class="alt-senha">
      <h3>Seus dados atuais:</h3>

      <hr>
      <p>
        <strong>Nome</strong>: <?php echo $usuario->nome ?>
        <br>
        <strong>E-mail</strong>: <?php echo $usuario->login ?>
        <br>

      <div class="container-horizontal cadastro-btns">
        <a href="<?php echo BASE_URL; ?>alt_dados_admin" class="btn-alterar btn-loja-alt-cadastro"><span class="bi bi-pencil-fill"></span>Alterar</a>
      </div>
      </p>

    </div>

    <footer><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.</a></footer>
    <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
  </main>

  </div>

  <script type="module" src="<?php echo BASE_URL; ?>js/main.js"></script>

  <script>
    function copyLink(url) {
      navigator.clipboard.writeText(url)
        .then(() => {
          alert("Link copiado!");
        })
        .catch(err => {
          console.error("Falha ao copiar: ", err);
        });
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