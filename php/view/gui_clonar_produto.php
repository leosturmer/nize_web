<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

// Busca o produto original para clonar os dados
$id_produto = $_GET['id'] ?? null;
$produtoData = null;

if ($id_produto) {
  $produtoDAO = new ProdutoDAO();
  $produtoData = $produtoDAO->buscarPorId($id_produto);
}

// Se não achar o produto, redireciona de volta
if (!$produtoData) {
  $_SESSION['msg'] = "<p class='error-msg'>Produto não encontrado para clonagem.</p>";
  header("location:gui_visualizacao_produtos.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clonar produto- Nize</title>
  <link rel="shortcut icon" href="../../img/favicon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/query.css">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/sidebar.css">
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
          <a href="tela_inicial.php" class="link-logo" title="Tela inicial">
            <img src="../../img/logo/nize_new.png" alt="Nize logotipo" id="logo-sidenav">
          </a>
        </li>

        <li>
        <li>
          <a href="tela_inicial.php" title="Tela inicial">
            <i class="bi bi-house"></i>

            <span>Tela inicial</span>

          </a>
        </li>
        <a href="gui_visualizacao_produtos.php" class="active" title="Tela de produtos">
          <i class="bi bi-box-seam"></i>
          <span>Produtos</span>
        </a>
        </li>
        </li>
        <a href="gui_visualizacao_pedidos.php" title="Tela de pedidos">
          <i class="bi bi-clipboard2-check"></i>
          <span>Pedidos</span>
        </a>
        </li>
        </li>
        <a href="gui_minha_area.php" title="Minha área">
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
      </ul>
    </nav>
  </aside>

  <header id="header-mobile">
    <div class="container-header">
      <a href="#" data-resize-btn-mobile class="btn-menu" title="Esconder/expandir menu">
        <i class="bi bi-list"></i>
      </a>
      <a href="tela_inicial.php" class="link-logo-header" title="Tela inicial">
        <img src="../../img/logo/nize_new.png" alt="Nize logotipo" id="logo-header">
      </a>
    </div>
  </header>

  <main class='conteudo-pagina'>
    <div class="internal-nav">
      <div class="internal-nav-links">
        <h1>Clonar Produto</h1>
        <a href="gui_visualizacao_produtos.php" title="Tela de produtos"><span class="bi bi-arrow-left"></span>Voltar</a>
      </div>
    </div>

    <?php
    if (isset($_SESSION["msg"])) {
      echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
      unset($_SESSION["msg"]);
    }
    ?>

    <form action="../controller/produtoControle.php?op=cadastrar" method="post" enctype="multipart/form-data" class="form-cadastro-produto">
      <fieldset id="products-form">
        <legend>Informações do Novo Produto (Clone)</legend>

        <div class="inner-products-form">
          <label><strong>Nome do produto</strong>*: </label>
          <input type="text" id="nomeProduto" name="nomeProduto" class="input-produto" autocomplete="off" required value="<?php echo htmlspecialchars($produtoData['nome'] . ' (Cópia)'); ?>">

          <div class="div-inner-products">
            <label><strong>Quantidade</strong>:
              <input type="number" id="quantidadeProduto" name="quantidadeProduto" class="input-produto" maxlength="3" autocomplete="off" value="<?php echo $produtoData['quantidade']; ?>">
            </label>
            <label class="checkbox-acc">
              <strong>Aceita encomendas</strong>:
              <input type="checkbox" id="aceitaEncomenda" name="aceitaEncomenda" class="input-produto" value='1' <?php echo $produtoData['aceita_encomenda'] == 1 ? 'checked' : ''; ?>>
            </label>
          </div>

          <div class="div-inner-products">
            <label><strong>Valor unitário</strong>*: R$
              <input type="number" id="valorUnitario" name="valorUnitario" step="0.01" class="input-produto" autocomplete="off" required value="<?php echo $produtoData['valor_unitario']; ?>">
            </label>
            <label><strong>Valor de custo</strong>: R$
              <input type="number" id="valorCusto" name="valorCusto" step="0.01" class="input-produto" autocomplete="off" value="<?php echo $produtoData['valor_custo']; ?>">
            </label>
          </div>

          <label class="descricao-produtos" for="descricaoProduto">
            <strong>Descrição do produto</strong>
            <textarea name="descricaoProduto" id="descricaoProduto" class="input-produto" autocomplete="off"><?php echo htmlspecialchars($produtoData['descricao']); ?></textarea>
          </label>
          <label class="checkbox-acc" for="">
            <strong>Disponibilizar para visualização</strong>:
            <input type="checkbox" id="aceitaVisualizacao" name="aceitaVisualizacao" class="input-produto" value="1" <?php echo $produtoData['aceita_visualizacao'] == 1 ? 'checked' : ''; ?>>
          </label>

          <input type="hidden" name="imagem_clonada" value="<?php echo $produtoData['imagem']; ?>">
          <label><strong>Imagem</strong>:
            <input type="file" name="imagemProduto" id="imagemProduto" class="input-produto" accept=".png, .jpg">
          </label>
          <?php if (!empty($produtoData['imagem'])): ?>
            <?php echo "<img src='uploads/" . htmlspecialchars($produtoData['imagem']) . "' alt='imagem do produto' class='img-produtos img-alt-produto'>" ?>
            <span class="span-alt-img">(Será mantida se não enviar outra)</span>
          <?php else: ?>
            <span>Nenhuma imagem</span>
          <?php endif; ?>
        </div>

      </fieldset>
      <div id="form-products-buttons">
        <button type="submit"><span class="bi bi-check2"></span>Salvar</button>
        <button formaction="../view/gui_visualizacao_produtos.php"><span class="bi bi-x-lg"></span>Cancelar</button>
      </div>
    </form>

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