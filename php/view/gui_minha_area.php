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


  <title>Nize - Minha área</title>
</head>

<body>
  <aside>
    <nav>
      <ul>
        <li>
          <a href="#" data-resize-btn class="btn-menu">
            <i class="bi bi-list"></i>
            <!-- <span>Esconder menu</span> -->
          </a>
        </li>

        <li>
          <a href="tela_inicial.php" class="link-logo">
            <img src="../../img/logo/nize_new.png" alt="Nize logotipo" id="logo-sidenav">
          </a>
        </li>

        <li>
        <li>
          <a href="tela_inicial.php">
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
        <a href="gui_minha_area.php" class="active">
          <i class="bi bi-person-lines-fill"></i>
          <span>Minha área</span>
        </a>
        </li>
        <li>
          <a href="../controller/logout.php" class="btn-sair">
            <i class="bi bi-box-arrow-left"></i>
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
    ?>

    <h1>Minha área</h1>

    <div id="minha-area">
      <p>
        <strong>Nome</strong>: <?php echo $usuario->nome ?>
        <br>
        <strong>Nome loja</strong>: <?php echo $nome_loja ?>
        <br>
        <strong>E-mail</strong>: <?php echo $usuario->login ?>
        <br>
        <strong>Visualização da loja</strong>: <?php echo $view_loja ?>
        <br>
        <strong>Link de visualização</strong>: <?php echo $nome_visualizacao ?>
      </p>

    </div>

    <div class="usuario-btns">
      <a href="./gui_alteracao_cadastro.php" class="btn-alterar">Alterar cadastro</a>
      <button formaction="../controller/usuarioControle.php?op=excluir" onclick="return confirm('A exclusão deletará todos os dados do banco. Deseja confirmar?')" class="btn-excluir">Excluir conta</button>
    </div>

    <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
  </main>

  <script>
    const msgElement = document.getElementById('session-msg');

    if (msgElement) {
      setTimeout(() => {
        msgElement.style.display = 'none';
      }, 6000);
    }
  </script>

<script>
  const resizeBtn = document.querySelector("[data-resize-btn]");
  const icon = resizeBtn.querySelector("i");

  const alternarIcone = () => {
    const ativo = document.body.classList.contains("sb-expanded");
    icon.classList.toggle("bi-x-lg", ativo);
    icon.classList.toggle("bi-list", !ativo);
  };

  resizeBtn.addEventListener("click", (e) => {
    e.preventDefault();
    document.body.classList.toggle("sb-expanded");
    alternarIcone();
  });

  resizeBtn.addEventListener("mouseenter", alternarIcone);
  resizeBtn.addEventListener("mouseleave", alternarIcone);
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

</body>

</html>