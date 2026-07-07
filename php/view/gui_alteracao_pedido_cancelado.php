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
        <a href="gui_visualizacao_produtos.php">
          <i class="bi bi-box-seam"></i>
          <span>Produtos</span>
        </a>
        </li>
        </li>
        <a href="gui_visualizacao_pedidos.php" class="active">
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
    <?php
    if (isset($_SESSION["msg"])) {
      echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
      unset($_SESSION["msg"]);
    }
    ?>


    <div class="internal-nav">
      <div class="internal-nav-links">
        <h1>Visualização de pedido</h1>
        <a href="gui_visualizacao_pedidos.php">Visualizar pedidos</a>
      </div>
      <h2>Número do pedido: <?php echo $numero_pedido = str_pad($id_pedido, 4, '0', STR_PAD_LEFT); ?></h2>
    </div>


    <h3>Pedido cancelado</h3>
    <p>Não é possível fazer alterações em pedidos cancelados</p>

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

      echo "<div class='total-pedido'><p><b>Total do pedido</b>: R$ " . number_format((float)$infoPedido['valor_final'], 2, ',', '.') . "</p></div>"; // Aqui tem que mudar

      $dataBanco = $infoPedido['data'];
      $formatoData = strtotime($dataBanco);
      $data = date("d/m/Y", $formatoData);

      ?>

      <div id="pedidos-form" class="pedido-cancelado-infos">
        <p><b>Data/prazo</b>: <?php echo $data; ?> </p><br>
        <p><b>Comentários</b>: <?php echo $infoPedido['comentario']; ?></p> <br>
        </p>
      </div>

      <div class="form-pedidos-items">
        <a href="../controller/pedidoControle.php?op=carregarQuantidade&id=<?php echo $id_pedido; ?>&clonar=true" class="btn-add">Clonar</a>
        <a href="../controller/pedidoControle.php?op=limparCarrinho" class="btn-add">Voltar</a>
      </div>

      <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
  </main>

  </div>


  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // const statusPedido = document.getElementById("statusPedido");
      const containerVendido = document.getElementById("containerVendido");
      const containerCancelado = document.getElementById("containerCancelado");

      // Função que gerencia o que deve aparecer baseado no valor selecionado
      function gerenciarCheckboxes() {
        const valorSelecionado = statusPedido.value;

        if (valorSelecionado === "vendido") {
          containerVendido.style.display = "block"; // Mostra o de venda
          containerCancelado.style.display = "none"; // Esconde o de cancelamento
        } else if (valorSelecionado === "cancelado") {
          containerVendido.style.display = "none"; // Esconde o de venda
          containerCancelado.style.display = "block"; // Mostra o de cancelamento
        } else {
          // Se for "encomendado" ou "pagamento", esconde ambos
          containerVendido.style.display = "none";
          containerCancelado.style.display = "none";
        }
      }

      // 1. Escuta a mudança de opções no select pelo usuário
      // statusPedido.addEventListener("change", gerenciarCheckboxes);

      // 2. Executa uma vez ao carregar a página (importante para telas de ALTERAÇÃO)
      gerenciarCheckboxes();
    });
  </script>

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

    resizeBtn.addEventListener("click", function(e) {
      e.preventDefault();
      document.body.classList.toggle("sb-expanded");
    });
  </script>
</body>

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


</html>