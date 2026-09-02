<?php
session_start();
require_once '../../model/usuario.class.php';
require_once '../../model/produto.class.php';
require_once '../../dao/produtodao.class.php';
require_once '../../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

// Busca o produto original para duplicar os dados
$id_produto = $_GET['id'] ?? null;
$produtoData = null;

if ($id_produto) {
  $produtoDAO = new ProdutoDAO();
  $produtoData = $produtoDAO->buscarPorId($id_produto);
}

// Se não achar o produto, redireciona de volta
if (!$produtoData) {
  $_SESSION['msg'] = "<p class='error-msg'>Produto não encontrado para clonagem.</p>";
  header("location:visualizacao_produtos.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Duplicar produto- Nize</title>
  <link rel="shortcut icon" href="../../../assets/img/favicon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../../../assets/css/variables.css">
  <link rel="stylesheet" href="../../../assets/css/sidebar.css">
  <link rel="stylesheet" href="../../../assets/css/components.css">
  <link rel="stylesheet" href="../../../assets/css/responsive.css">
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
        <a href="visualizacao_produtos.php" class="active" title="Tela de produtos">
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
        <a href="../usuario/minha_area.php" title="Minha área">
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
    <div class="internal-nav">
      <div class="internal-nav-links">
        <h1>Duplicar Produto</h1>
        <a href="visualizacao_produtos.php" title="Tela de produtos"><span class="bi bi-arrow-left"></span>Voltar</a>
      </div>
    </div>

    <?php
    if (isset($_SESSION["msg"])) {
      echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
      unset($_SESSION["msg"]);
    }
    ?>

    <form action="../../controller/produtoControle.php?op=cadastrar" method="post" enctype="multipart/form-data" class="form-cadastro-produto">
      <fieldset id="products-form">
        <legend>Informações do Novo Produto (Cópia)</legend>

        <div class="inner-products-form">
          <label><strong>Nome do produto</strong>*: </label>
          <input type="text" id="nomeProduto" name="nomeProduto" class="input-produto" autocomplete="off" maxlength="50" required value="<?php echo htmlspecialchars($produtoData['nome'] . ' (Cópia)'); ?>">

          <div class="div-inner-products">
            <label><strong>Quantidade</strong>:
              <input type="number"  step="1" min="0" onkeydown="return ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.key) || !isNaN(Number(event.key))" id="quantidadeProduto" name="quantidadeProduto" class="input-produto" maxlength="3" autocomplete="off" value="<?php echo $produtoData['quantidade']; ?>">
            </label>
            <label class="checkbox-acc">
              <strong>Aceita encomendas</strong>:
              <input type="checkbox" id="aceitaEncomenda" name="aceitaEncomenda" class="input-produto" value='1' autocomplete="off" <?php echo $produtoData['aceita_encomenda'] == 1 ? 'checked' : ''; ?>>
            </label>
          </div>

          <div class="div-inner-products">
            <label><strong>Valor unitário</strong>*: R$
              <input type="number" min="0" id="valorUnitario" name="valorUnitario" step="0.10" class="input-produto" autocomplete="off" maxlength="6" required value="<?php echo $produtoData['valor_unitario']; ?>">
            </label>
            <label><strong>Valor de custo</strong>: R$
              <input type="number" min="0" id="valorCusto" name="valorCusto" step="0.10" class="input-produto" autocomplete="off" maxlength="6" value="<?php echo $produtoData['valor_custo']; ?>">
            </label>
          </div>

          <label class="comentario-produtos" for="comentarioProduto">
            <strong>Comentários</strong>
          </label>
          <textarea maxlength="500" rows="5" cols="40" name="comentarioProduto" id="comentarioProduto" placeholder="Adicione comentarios pessoais sobre o produto" class="input-produto" autocomplete="off"><?php echo htmlspecialchars($produtoData['comentario']); ?></textarea>

          <label class="checkbox-acc" for="">
            <strong>Disponibilizar para visualização</strong>:
            <input type="checkbox" id="aceitaVisualizacao" name="aceitaVisualizacao" class="input-produto" value="1" autocomplete="off" <?php echo $produtoData['aceita_visualizacao'] == 1 ? 'checked' : ''; ?>>
          </label>


          <label class="descricao-produtos" for="descricaoProduto">
            <strong>Informações do produto</strong>
            <textarea maxlength="500" rows="5" cols="40" name="descricaoProduto" id="descricaoProduto" class="input-produto" autocomplete="off"><?php echo htmlspecialchars($produtoData['descricao']); ?></textarea>
          </label>
          
          
          <input type="hidden" name="imagem_clonada" value="<?php echo $produtoData['imagem']; ?>">
          <label><strong>Imagem</strong>:
            <input type="file" name="imagemProduto" id="imagemProduto" class="input-produto" accept=".png, .jpg" autocomplete="off">
          </label>
          <?php if (!empty($produtoData['imagem'])): ?>
            <?php echo "<img src='../../persistence/uploads/" . htmlspecialchars($produtoData['imagem']) . "' alt='imagem do produto' class='img-produtos img-alt-produto'>" ?>
            <span class="span-alt-img">(Será mantida se não enviar outra)</span>
          <?php else: ?>
            <span class="sem-imagem">Nenhuma imagem cadastrada</span>
          <?php endif; ?>
        </div>

      </fieldset>
      <div id="form-products-buttons">
        <button type="submit"><span class="bi bi-check2"></span>Salvar</button>
        <button formaction="./visualizacao_produtos.php"><span class="bi">✖</span>Cancelar</button>
      </div>
    </form>

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