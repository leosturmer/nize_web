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
  header("location:visualizacao_pedidos.php");
  exit;
}
$id_pedido = $_SESSION['pedidoSelecionado']["id_pedido"];
$infoPedidoSession = $_SESSION['pedidoSelecionado'];

$pedidoDAO = new PedidoDAO();
$infoPedidoBanco = $pedidoDAO->buscarPedidoID($id_pedido);

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


  <title>Pedido vendido - Nize</title>
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
        <a href="visualizacao_produtos.php" title="Tela de produtos">
          <i class="bi bi-box-seam"></i>
          <span>Produtos</span>
        </a>
        </li>
        </li>
        <a href="visualizacao_pedidos.php" class="active" title="Tela de pedidos">
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
      <div class="internal-nav-links" style="display: flex; align-items: center;">
        <h2 class="num-pedido num-pedido-cancelado">Pedido vendido - <?php echo $numero_pedido = str_pad($id_pedido, 4, '0', STR_PAD_LEFT); ?></h2>
        <a href="visualizacao_pedidos.php" title="Tela de pedidos"><span class="bi bi-arrow-left"></span>Voltar</a>
      </div>
      <div class="texto-pedido-cancelado">
        <p>Pedidos vendidos tem limitações de alteração</p>
      </div>
    </div>



    <div class="container-horizontal">
      <div class="produtos-no-pedido">
        <?php
        $_SESSION['total_compra'] = 0.00;

        if (!empty($_SESSION['carrinho'])) {
          foreach ($_SESSION['carrinho'] as $id_produto => $item) {
            $produtoVendido = $produtoDAO->buscarPorId($id_produto);

            // Trata item como array ou inteiro simples (compatibilidade)
            if (is_array($item)) {
              $quantidade = (int)$item['quantidade'];
              $valor_unitario = (float)$item['valor_unitario'];
            } else {
              $quantidade = (int)$item;
              $valor_unitario = (float)($produtoVendido['valor_unitario'] ?? 0);
            }

            $valor_total_item = $valor_unitario * $quantidade;
            $_SESSION['total_compra'] += $valor_total_item;

            if ($produtoVendido) {
              echo "<div class='produto-individual'>";
              echo "<h3>" . htmlspecialchars($produtoVendido['nome']) . "</h3><br>";
              echo "<p>";
              echo "<b>Quantidade</b>: " . $quantidade . "<br>";
              echo "<b>Unidade</b>: R$ " . number_format($valor_unitario, 2, ',', '.') . "<br>";
              echo "<b>Valor total</b>: R$ " . number_format($valor_total_item, 2, ',', '.') . "<br><br>";

              // Exibir o botão de remoção apenas se for a tela de alteração normal
              if (basename($_SERVER['PHP_SELF']) == 'alteracao_pedidos.php') {
                echo "<a href='../controller/pedidoControle.php?op=removerQuantidade&id=$id_produto&id_pedido=$id_pedido' class='btn-remover'>Remover produto</a>";
              }

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
        echo "<div class='total-pedido'><p><b>Total do pedido</b>: R$ " . number_format((float)$infoPedidoBanco['valor_final'], 2, ',', '.') . "</p></div>"; // Aqui tem que mudar
        $dataBanco = $infoPedidoBanco['data'];
        $formatoData = strtotime($dataBanco);
        $data = date("d/m/Y", $formatoData);
        ?>
        <form action="../controller/pedidoControle.php" method="get">
          <input type="hidden" name="op" value="alterar">
          <div class="form-pedidos-items">
            <fieldset id="pedidos-form">
              <!-- <div> -->
              <label for="prazopedido">
                Data
                <input type="date" name="prazoPedido" id="prazoPedido" class="input-pedido" required value="<?php echo $infoPedidoBanco['data'] ?>">
              </label>
              <label for="statusPedido">
                Status do Pedido
                <select name="statusPedido" id="statusPedido">
                  <option value="vendido" <?= $infoPedidoSession['status'] == 'vendido' ? 'selected' : '' ?>>Vendido</option>
                  <option value="cancelado" <?= $infoPedidoSession['status'] === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                </select>
              </label>

              <div id="containerVendido" style="display: none;">
                <!-- <label class="label-baixa-estoque">
                  Dar baixa no estoque?
                  <input type="checkbox" name="darBaixaEstoque" id="darBaixaEstoque" class="input-produto input-checkbox" value="1">
                </label> -->
              </div>
              <div id="containerCancelado" style="display: none;">
                <p>Atenção: <br> Pedidos cancelados não podem ser editados!<br></p>
                <label class="label-baixa-estoque">
                  Devolver produtos ao estoque?
                  <input type="checkbox" name="estornarEstoque" id="estornarEstoque" class="input-produto input-checkbox" value="1">
                </label>
              </div>
              <!-- </div> -->
              <label for="comentarioPedido">
                Comentários
                <textarea name="comentarioPedido" id="comentarioPedido" placeholder="Detalhes do pedido, dos produtos, da entrega, do cliente, entre outros."><?php echo $infoPedidoSession['comentario'] ?></textarea>
              </label>
            </fieldset>
          </div>
          <div class="form-pedidos-items">
            <button type="submit" class="btn-alt-pedido"><span class="bi bi-check2"></span>Alterar</button>
            <a href="../controller/pedidoControle.php?op=excluir&id=<?php echo $id_pedido ?>" onclick="return confirm('Deseja mesmo excluir?');"><span class="bi bi-trash3" class="btn-alt-pedido"></span>Excluir</a>
            <!-- <a href="../view/visualizacao_pedidos.php" class="btn-alt-pedido">Voltar</a> -->
          </div>
        </form>
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