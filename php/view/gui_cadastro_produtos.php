<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../util/seguranca.class.php';
Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nize</title>

  <link rel="shortcut icon" href="../../img/favicon/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/query.css">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/sidebar.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


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
          <a href="tela_inicial.php">
            <i class="bi bi-house"></i>

            <span>Tela inicial</span>

          </a>
        </li>
        <a href="gui_visualizacao_produtos.php" class="active">
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
            <i class="bi bi-box-arrow-left"></i>
            <span>Encerrar sessão</span>
          </a>
        </li>
      </ul>
    </nav>
  </aside>

  <!-- <div class="conteudo-pagina"> -->


  <main class='conteudo-pagina'>

    <div class="internal-nav">
      <div class="internal-nav-links">
        <h1>Cadastro de produto</h1>
        <a href="gui_visualizacao_produtos.php">Todos os produtos</a>
      </div>
    </div>

    <?php
    if (isset($_SESSION["msg"])) {
      echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
      unset($_SESSION["msg"]);
    }
    ?>

    <form action="#" method="post" enctype="multipart/form-data" class="form-cadastro">
      <fieldset id="products-form">
        <legend>Informações do produto</legend>
        <div class="inner-products-form">
          <label><strong>Nome do produto</strong>*:</label>
          <input type="text" id="nomeProduto" name="nomeProduto" class="input-produto" autocomplete="off" placeholder="o nome do produto vai aqui" required>


          <div class="div-inner-products">
            <label><strong>Quantidade</strong>:
              <input type="number" inputmode="" id="quantidadeProduto" name="quantidadeProduto" class="input-produto " maxlength="3" placeholder="00" autocomplete="off">
            </label>

            <label class="checkbox-acc" for="">
              <strong>Aceita encomendas</strong>:
              <input type="checkbox" id="aceitaEncomenda" name="aceitaEncomenda" class="input-produto input-checkbox" value='1'>
            </label>


          </div>

          <div class="div-inner-products">

            <label><strong>Valor unitário</strong>*: R$
              <input type="number" id="valorUnitario" name="valorUnitario" step="0.01" class="input-produto" autocomplete="off" placeholder="00,00" required>
            </label>


            <label><strong>Valor de custo</strong>: R$
              <input type="number" id="valorCusto" name="valorCusto" step="0.01" class="input-produto" placeholder="00,00" autocomplete="off">
            </label>

          </div>

          <label class="descricao-produtos" for="descricaoProduto">
            <strong>Descrição do produto</strong>
          </label>
          <textarea name="descricaoProduto" id="descricaoProduto" placeholder="Adicione detalhes sobre o produto (material, cores, tamanho, etc)" class="input-produto" autocomplete="off"></textarea>

          <label class="checkbox-acc" for="">
            <strong>Disponibilizar para visualização</strong>:
            <input type="checkbox" id="aceitaVisualizacao" name="aceitaVisualizacao" class="input-produto input-checkbox" value='1'>
          </label>


          <label><strong>Imagem</strong>: (max. 2mb)
          </label>
          <input type="file" name="imagemProduto" id="imagemProduto" class="input-produto" accept=".png, .jpg">

        </div>

      </fieldset>
      <div id="form-products-buttons">
        <button type="submit" formaction="../controller/produtoControle.php?op=cadastrar">Cadastrar</button>
        <button type="reset">Limpar</button>
      </div>
    </form>

    <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
  </main>
  <script>
    document.getElementById('imagemProduto').addEventListener('change', function() {
      if (this.files && this.files[0]) {

        const tamanhoArquivo = this.files[0].size;

        const limiteMaximo = 2 * 1024 * 1024;

        if (tamanhoArquivo > limiteMaximo) {
          alert('A imagem escolhida é muito grande! O tamanho máximo permitido é de 2 MB.');

          this.value = '';
        }
      }
    });

    const msgElement = document.getElementById('session-msg');

    if (msgElement) {
      setTimeout(() => {
        msgElement.style.display = 'none';
      }, 6000);
    }
  </script>
  <script>
    const resizeBtn = document.querySelector("[data-resize-btn]");

    resizeBtn.addEventListener("click", function(e) {
      e.preventDefault();
      document.body.classList.toggle("sb-expanded");
    });
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