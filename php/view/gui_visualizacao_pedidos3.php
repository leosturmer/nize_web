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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=dehaze,search" />

    <script>
        const resizeBtn = document.querySelector("[data-resize-btn]");

resizeBtn.addEventListener("click", function (e) {
  e.preventDefault();
  document.body.classList.toggle("sb-expanded");
});

    </script>

    <style>
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  --sb-width: 5rem;
  font-family: system-ui, sans-serif;
  font-size: 16px;
  line-height: 1.7;
  color: #333;
  background-color: #fff;
}

body.sb-expanded {
  --sb-width: 12.5rem;
}

h1 {
  font-size: 1.5rem;
  font-weight: bold;
}

p {
  margin-bottom: 1.5rem;
}

aside {
  position: fixed;
  /* top: 0;
  left: 0;
  bottom: 0; */
  inset: 0 auto 0 0;
  padding: 1rem;
  /* width: 80px; */
  width: var(--sb-width);
  background-image: linear-gradient(#90c3fd, #ba71ff, #ff71b8);
  transition: width 0.5s ease-in-out;
}

nav {
  height: 100%;
  /* border: 1px solid #000; */
}

nav ul {
  list-style: none;
  height: 100%;
  display: flex;
  flex-flow: column;
  gap: 0.25rem;
}

nav li:last-child {
  margin-top: auto;
}

nav a {
  display: flex;
  align-items: center;
  gap: 0.625rem;
  padding: 0.625rem 0.875rem;
  font-size: 1.25rem;
  line-height: 1;
  color: #fff;
  text-decoration: none;
  border-radius: 0.375rem;
  transition: background-color 0.5s ease-in-out, color 0.5s ease-in-out;
}

nav a.active,
nav a:hover,
nav a:focus-visible {
  outline: none;
  color: #b366fc;
  background-color: #fff;
}

nav a span {
  font-size: 0.875rem;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
}

.sb-expanded nav a span {
  opacity: 1;
  visibility: visible;
}

.sb-expanded aside .bx-chevrons-right {
  rotate: 180deg;
}

main {
  margin-left: 5rem;
  padding: 1rem 2rem;
  transition: margin-left 0.5s ease-in-out;
}

@media (min-width: 768px) {
  main {
    margin-left: var(--sb-width);
  }
}

.placeholder {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 0.625rem;
  min-height: 600px;
}

.placeholder > div {
  background-color: rgb(238, 238, 252);
  border-radius: 0.375rem;
}

.ph-1 {
  grid-area: 1 / 1 / 2 / 3;
}

.ph-2 {
  grid-area: 1 / 3 / 2 / 4;
}

.ph-3 {
  grid-area: 2 / 1 / 3 / 2;
}

.ph-4 {
  grid-area: 2 / 2 / 3 / 4;
}

.ph-5 {
  grid-area: 3 / 1 / 4 / 2;
}

.ph-6 {
  grid-area: 3 / 2 / 4 / 3;
}

.ph-7 {
  grid-area: 3 / 3 / 4 / 4;
}

.ph-8 {
  grid-area: 4 / 1 / 5 / 4;
}


    </style>


     <title>Lista de Pedidos</title>
</head>

<body>

<aside>
  <nav>
    <ul>
      <li>
        <a href="#" class="active">
          <i class="bx bx-home-circle"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-grid-alt"></i>
          <span>Explore</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-carousel"></i>
          <span>Slideshow</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-collection"></i>
          <span>Collections</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-cloud-download"></i>
          <span>Downloads</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-chat"></i>
          <span>Messages</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-cog"></i>
          <span>Settings</span>
        </a>
      </li>
      <li>
        <a href="#" data-resize-btn>
          <i class="bx bx-chevrons-right"></i>
          <span>Collapse</span>
        </a>
      </li>
    </ul>
  </nav>
</aside>

<main>
  <h1>Expandable Sidebar</h1>
  <p>
    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem ab non
    dolorem reiciendis harum quasi inventore a eum soluta. Suscipit id
    asperiores libero veritatis ducimus sapiente minus reprehenderit
    eligendi pariatur.
  </p>

  <div class="placeholder">
    <div class="ph-1"></div>
    <div class="ph-2"></div>
    <div class="ph-3"></div>
    <div class="ph-4"></div>
    <div class="ph-5"></div>
    <div class="ph-6"></div>
    <div class="ph-7"></div>
    <div class="ph-8"></div>
  </div>
</main>

    <!-- <details class="coll-sidenav" open>
        <summary><span class="material-symbols-outlined">dehaze</span></summary>
        <div class="sidenav">
            <img src="../../img/logo/nize_new.png" alt="Nize" id="logo-sidenav">
            <a href="tela_inicial.php">Tela inicial</a>
            <a href="gui_visualizacao_produtos.php">Produtos</a>
            <a href="gui_visualizacao_pedidos.php">Pedidos</a>
            <a href="gui_minha_area.php">Minha área</a>
            <a href="../controller/logout.php" id="btn-sair">Encerrar sessão</a>
        </div>
    </details> -->

    <div class="conteudo-pagina">

        <main>
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
                        <input type="text" id="pesquisa-pedidos" placeholder="Digite sua pesquisa" autocomplete="off"><span class="material-symbols-outlined" id="search-icon">search</span>
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

    <script src="busca_pedidos.js"></script>
    <script>
        const msgElement = document.getElementById('session-msg');

        if (msgElement) {
            setTimeout(() => {
                msgElement.style.display = 'none';
            }, 6000);
        }
    </script>


</body>

</html>