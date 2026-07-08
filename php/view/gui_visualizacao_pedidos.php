<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../dao/pedidodao.class.php';
require_once '../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

$pedidoDAO = new pedidoDAO();

$listaPedidos = $pedidoDAO->listarTodosPedidos($usuario->id_usuario);

if (!isset($_SESSION['carrinho'])) {
  $_SESSION['carrinho'] = [];
}

if (isset($_SESSION['pedidoSelecionado'])) {
  unset($_SESSION['pedidoSelecionado']);
  unset($_SESSION['carrinho']);
}

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


  <title>Lista de Pedidos</title>
</head>

<body>
  <aside>
    <nav>
      <ul>
        <li>
           <a href="#" data-resize-btn class="btn-menu" title="Esconder/expandir menu" >
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

 

  <main class='conteudo-pagina'>
    <?php
    if (isset($_SESSION["msg"])) {
      echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
      unset($_SESSION["msg"]);
    }
    ?>

    <div class="internal-nav">
      <div class="internal-nav-links">
        <h1>Lista de Pedidos</h1>
        <a href="gui_cadastro_pedidos.php">Cadastrar novo pedido</a>
      </div>

      <div class="internal-nav-inputs">
        <form onsubmit="return false;" id="form-pesquisa-pedidos">
          <input type="text" id="pesquisa-pedidos" placeholder="Digite sua pesquisa" autocomplete="off"><span id="search-icon" class="bi bi-search"></span>
        </form>

        <input type="date" id="filtro-data">
        <select id="filtro-status">
          <option value="">Todos os status</option>
          <option value="encomendado">Encomendado</option>
          <option value="pagamento">Pagamento</option>
          <option value="vendido">Vendido</option>
          <option value="cancelado">Cancelado</option>
        </select>

        <select id="filtro-order">
          <option value="">Ordenar por</option>
          <option value="numero-asc">Número pedido (crescente)</option>
          <option value="numero-desc">Número pedido (descrescente)</option>
          <option value="data-asc">Data (crescente)</option>
          <option value="data-desc">Data (descrescente)</option>
        </select>

        <button type="button" id="btn-limpar-filtros">Resetar filtros</button>

      </div>
    </div>


    <div class="lista-pedidos">
      <?php if (!empty($listaPedidos)): ?>
        <?php foreach ($listaPedidos as $id_pedido => $dados_pedido): ?>
          <div class="product-view">

            <h2 class="num-pedido">Número do pedido: <?php echo $numero_pedido = str_pad($id_pedido, 4, '0', STR_PAD_LEFT); ?></h2>
            <?php
            $dataBanco = $dados_pedido['data'];
            $formatoData = strtotime($dataBanco);
            $data = date("d/m/Y", $formatoData);

            $comentario = htmlspecialchars($dados_pedido['comentario']);
            $status = $dados_pedido['status'];

            $statusView = '';
            if ($status == "encomendado") {
              $statusView = "Encomendado";
            } else if ($status == "pagamento") {
              $statusView = "Aguardando pagamento";
            } else if ($status == "vendido") {
              $statusView = "Vendido";
            } else if ($status == "cancelado") {
              $statusView = "Cancelado";
            }

            foreach ($dados_pedido['produtos'] as $produto) {
              echo "<p><strong>" . htmlspecialchars($produto['nome']) . "</strong>: " . htmlspecialchars($produto['quantidade']) . " unidades</p>";
            }
            ?>

            <p><strong>Data: </strong><?php echo $data ?></p>
            <p><strong>Valor final: </strong> R$ <?php echo number_format((float)$dados_pedido['valor_final'], 2, ',', '.') ?></p>
            <p><strong>Status: </strong><?php echo $statusView ?></p>
            <p class="p-descricao"><strong>Comentário: </strong><?php if ($comentario) {
                                                                  echo $comentario;
                                                                } else {
                                                                  echo "Nenhum comentário adicionado";
                                                                } ?></p>

            <div class="product-btns">
              <a href="../controller/pedidoControle.php?op=carregarQuantidade&id=<?php echo $id_pedido ?>">Visualizar</a>
              <a href="../controller/pedidoControle.php?op=excluir&id=<?php echo $id_pedido ?>" onclick="return confirm('Deseja mesmo excluir?');">Excluir</a>
            </div>
          </div> <?php endforeach; ?>
      <?php else: ?>
        <p>Nenhum pedido cadastrado.</p>
      <?php endif; ?>
    </div>


    <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
  </main>

  </div>

  <script src="../../js/busca_pedidos.js"></script>
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