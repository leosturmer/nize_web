<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../util/seguranca.class.php';
Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

$produtoDAO = new ProdutoDAO();

$lista = $produtoDAO->listarTodosProdutos($usuario->id_usuario);

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


  <title>Lista de Produtos</title>
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
        <h1>Lista de Produtos</h1>
        <a href="gui_cadastro_produtos.php"><span class="bi bi-plus"></span>Produto</a>
      </div>

      <div class="internal-nav-inputs">
        <form onsubmit="return false;" id="form-pesquisa-produtos">
          <input type="text" id="pesquisa-produtos" placeholder="Busque pelo nome ou descrição " autocomplete="off"><span id="search-icon" class="bi bi-search"></span>
        </form>

        <details class="filtros-produtos">
          <summary><span class="bi bi-filter"></span>Filtrar</summary>
          <div>
            <select id="filtro-estoque">
              <option value="">Estoque</option>
              <option value="com-estoque">Com estoque</option>
              <option value="sem-estoque">Sem estoque</option>
            </select>
            <select id="filtro-encomenda">
              <option value="">Encomenda</option>
              <option value="com-encomenda">Aceita encomenda</option>
              <option value="sem-encomenda">Não aceita encomenda</option>
            </select>
            <select id="filtro-order">
              <option value="">Ordenar por</option>
              <option value="nome-asc">Nome (crescente)</option>
              <option value="nome-desc">Nome (descrescente)</option>
              <option value="quant-asc">Quantidade (descrescente)</option>
              <option value="quant-desc">Quantidade (descrescente)</option>
            </select>
            <button type="button" id="btn-limpar-filtros">Resetar filtros</button>
          </div>
        </details>

      </div>


    </div>

    <?php
    if (isset($_SESSION["msg"])) {
      echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
      unset($_SESSION["msg"]);
    }
    ?>

    <div class="lista-produtos">

      <?php if (!empty($lista)): ?>
        <?php foreach ($lista as $item): ?>
          <div class="product-view">
            <div class="texto-produto">
              <p><strong>Nome do produto:</strong> <?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></p>
              <p><strong>Quantidade:</strong> <?php if ($item['quantidade'] === 0 || $item['quantidade'] == null) {
                                                echo "Sem estoque";
                                              } else {
                                                echo htmlspecialchars($item['quantidade']);
                                              } ?> </p>
              <?php if ($item['valor_unitario']) {
                $valor_unitario = "R$ " . number_format($item['valor_unitario'], 2, ',', '.');
              } else {
                $valor_unitario = "Não informado";
              } ?>
              <p><strong>Valor unitário:</strong> <?php echo $valor_unitario ?></p>
              <?php if ($item['valor_custo']) {
                $valor_custo = "R$ " . number_format($item['valor_custo'], 2, ',', '.');
              } else {
                $valor_custo = "Não informado";
              } ?>
              <p><strong>Valor de custo:</strong> <?php echo $valor_custo; ?></p>
              <?php
              if (htmlspecialchars($item['aceita_encomenda']) === '1') {
                $aceita_encomenda = "Aceita";
              } else {
                $aceita_encomenda = "Não aceita";
              }
              if (htmlspecialchars($item['aceita_visualizacao']) === '1') {
                $aceita_visualizacao = "Sim";
              } else {
                $aceita_visualizacao = "Não";
              }
              ?>
              <p><strong>Aceita encomenda:</strong> <?php echo $aceita_encomenda; ?></p>
              <p><strong>Disponível para visualização:</strong> <?php echo $aceita_visualizacao; ?></p>
              <p class="p-descricao"><strong>Descrição:</strong>
                <?php if ($item['descricao']) {
                  echo htmlspecialchars($item['descricao']);
                } else {
                  echo "Nenhuma descrição informada";
                } ?></p>
            </div>

            <div class="product-img-btn">
              <?php if ($item['imagem']) {
                echo "<img src='uploads/" . htmlspecialchars($item['imagem']) . "' alt='imagem do produto' class='img-produtos'>";
              } else {
                echo "<p>Nenhuma imagem cadastrada</p>";
              } ?>
              <div class="product-btns">
                <a href="gui_alteracao_produto.php?id=<?php echo $item['id_produto']; ?>">Visualizar</a>
                <a href="../controller/produtoControle.php?op=excluir&id=<?php echo $item['id_produto'] ?>" onclick="return confirm('Deseja mesmo excluir?');">Excluir</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: echo "Nenhum produto cadastrado." ?>
      <?php endif; ?>
    </div>

    <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
  </main>

  <script type="module" src="../../js/main.js"></script>
  <script src="../../js/busca_produtos.js"></script>

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