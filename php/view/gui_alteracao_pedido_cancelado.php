<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../dao/pedidodao.class.php';
require_once '../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

$produtoDAO = new ProdutoDAO();

if (empty($_SESSION['pedidoSelecionado'])) {
  $_SESSION['msg'] = "<p class='error-msg'>Nenhum pedido selecionado!</p>";
  echo $_SESSION['msg'];
  header("location:gui_visualizacao_pedidos.php");
  exit;
}
$id_pedido = $_SESSION['pedidoSelecionado']["id_pedido"];
$infoPedido = $_SESSION['pedidoSelecionado'];


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


  <title>Pedidos</title>
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
        <a href="gui_visualizacao_produtos.php" title="Tela de produtos">
          <i class="bi bi-box-seam"></i>
          <span>Produtos</span>
        </a>
        </li>
        </li>
        <a href="gui_visualizacao_pedidos.php" class="active" title="Tela de pedidos">
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
    <?php
    if (isset($_SESSION["msg"])) {
      echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
      unset($_SESSION["msg"]);
    }
    ?>


    <div class="internal-nav">
      <div class="internal-nav-links">
        <h1>Pedido cancelado</h1>
        <a href="gui_visualizacao_pedidos.php" title="Tela de pedidos"><span class="bi bi-arrow-left"></span>Voltar</a>
      </div>
      <div class="texto-pedido-cancelado">
        <p>Não é possível fazer alterações em pedidos cancelados</p>
      </div>
      <h2 class="num-pedido num-pedido-cancelado">Número do pedido: <?php echo $numero_pedido = str_pad($id_pedido, 4, '0', STR_PAD_LEFT); ?></h2>
    </div>



    <div class="container-horizontal">
      <div class="produtos-no-pedido">
        <?php
        if (!empty($_SESSION['carrinho'])) {
          foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
            $produtoVendido = $produtoDAO->buscarPorId($id_produto);
            if ($produtoVendido) {
              echo "<div class='produto-individual'>";
              echo "<h3>" . htmlspecialchars($produtoVendido['nome']) . "</h3><br>";
              echo "<p>";
              echo "<b>Quantidade</b>: " . $quantidade . "<br>";
              echo "<b>Valor do produto</b>: R$ " . number_format((float)$produtoVendido['valor_unitario'], 2, ',', '.') . "<br>";
              $valor_total = (float)$produtoVendido['valor_unitario'];
              $valor_total = $valor_total * $quantidade;
              echo "<b>Valor total</b>: R$ " . (number_format((float)$valor_total, 2, ',', '.')) . "<br>";
              echo "</div>";
            } else {
              echo "<p><b>Produto ID $id_produto</b> não foi encontrado no estoque.</p>";
            }
          }
        } else {
          echo "<p>Nenhum produto encontrado no pedido.</p>";
        }
        echo "</div>";
        echo "<div class='infos-pedido'>";
        echo "<div class='total-pedido'><p><b>Total do pedido</b>: R$ " . number_format((float)$infoPedido['valor_final'], 2, ',', '.') . "</p></div>"; // Aqui tem que mudar
        $dataBanco = $infoPedido['data'];
        $formatoData = strtotime($dataBanco);
        $data = date("d/m/Y", $formatoData);
        ?>
        <div class="form-pedidos-items">
          <div id="pedidos-form" class="pedido-cancelado-infos">
            <p><b>Data/prazo</b>: <?php echo $data; ?> </p><br>
            <p><b>Comentários</b>: <?php echo $infoPedido['comentario']; ?></p> <br>
            </p>
          </div>
        </div>
        <div class="form-pedidos-items">
          <a href="../controller/pedidoControle.php?op=carregarQuantidade&id=<?php echo $id_pedido; ?>&clonar=true" class="btn-add"><span class="bi bi-copy"></span>Clonar</a>
          <a href="../controller/pedidoControle.php?op=excluir&id=<?php echo $id_pedido ?>" onclick="return confirm('Deseja mesmo excluir?');" class="btn-alt-pedido"><span class="bi bi-trash3"></span>Excluir</a>
          <!-- <a href="../controller/pedidoControle.php?op=limparCarrinho" class="btn-add">Voltar</a> -->
        </div>
      </div>
    </div>

    <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
  </main>

  </div>

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