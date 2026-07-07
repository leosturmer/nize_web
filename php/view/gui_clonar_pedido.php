<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../util/seguranca.class.php';
Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);
$produtoDAO = new ProdutoDAO();
$listaProdutos = $produtoDAO->listarTodosProdutos($usuario->id_usuario);

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Certifica-se de que não há pedido selecionado para não sobrescrever dados antigos por engano
if (isset($_SESSION['pedidoSelecionado'])) {
    unset($_SESSION['pedidoSelecionado']);
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


    <title>Clonar Pedido</title>
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
        ?>

        <div class="internal-nav">
            <div class="internal-nav-links">
                <h1>Clonar Pedido</h1>
                <a href="gui_visualizacao_pedidos.php">Visualizar pedidos</a>
            </div>
        </div>

        <details class="produtos-pedido">
            <summary>Adicione os produtos ao pedido clonado</summary>

            <!-- <div class="adicionar-produtos"> -->
            <form onsubmit="return false;" id="form-pesquisa-produtos" class="form-produto-pedido">
                <input type="text" id="pesquisa-produtos" placeholder="Busque pelo nome ou descrição" autocomplete="off"><span id="search-icon" class="bi bi-search"></span>
            </form>
            <div class="lista-produtos-pedido">
                <?php if (!empty($listaProdutos)): ?>
                    <?php foreach ($listaProdutos as $item): ?>
                        <div class="product-view">
                            <p><strong>Nome do produto:</strong> <?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></p>
                            <p><strong>Quantidade disponível:</strong> <?php echo htmlspecialchars($item['quantidade']); ?> </p>
                            <p><strong>Valor unitário: R$</strong> <?php echo number_format((float)$item['valor_unitario'], 2, ',', '.') ?> </p>
                            <p><strong>Aceita encomenda:</strong> <?php echo $item['aceita_encomenda'] ? "Sim" : "Não"; ?></p>
                            <p class="p-descricao"><strong>Descrição:</strong> <?php echo htmlspecialchars($item['descricao']) ? htmlspecialchars($item['descricao']) : 'Sem informações'; ?></p>

                            <?php if ($item['imagem']) {
                                echo "<img src='uploads/" . htmlspecialchars($item['imagem']) . "' alt='imagem do produto' class='img-produtos'>";
                            } else {
                                echo "<p class='img-produtos'>Nenhuma imagem cadastrada</p>";
                            } ?>

                            <form action="../controller/pedidoControle.php" method="get" class="product-btns">
                                <input type="number" name="quantidadeVendida" id="quantidadeVendida" class="input-pedido" maxlength="3" placeholder="Digite a quantidade" autocomplete="off">
                                <input type="hidden" name="op" value="adicionarQuantidade">
                                <input type="hidden" name="id" value="<?php echo $item['id_produto']; ?>">
                                <input type="hidden" name="origem" value="clonar">
                                <input type="submit" class="btn-add" value="Adicionar ao pedido">
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: echo "Nenhum produto cadastrado." ?>
                <?php endif; ?>
            </div>
            <!-- </div> -->
        </details>

        <div class="container-horizontal">
            <div class="produtos-no-pedido">
                <?php
                $_SESSION['total_compra'] = 0.00;
                if (!empty($_SESSION['carrinho'])) {
                    foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                        $produtoVendido = $produtoDAO->buscarPorId($id_produto);
                        if ($produtoVendido) {
                            $valor_unitario = (float)$produtoVendido['valor_unitario'];
                            $quantidade = (int)$quantidade;
                            $valor = $valor_unitario * $quantidade;
                            $_SESSION['total_compra'] += $valor;
                            echo "<div class='produto-individual'>";
                            echo "<h3>" . htmlspecialchars($produtoVendido['nome']) . "</h3><br>";
                            echo "<p>";
                            echo "<b>Quantidade</b>: " . $quantidade . "<br>";
                            echo "<b>Valor unitário</b>: R$ " . number_format((float)$produtoVendido['valor_unitario'], 2, ',', '.') . "<br>";
                            $valor_total = (float)$produtoVendido['valor_unitario'];
                            $valor_total = $valor_unitario * $quantidade;
                            echo "<b>Valor total</b>: R$ " . (number_format((float)$valor_total, 2, ',', '.')) . "<br><br>";
                            echo "<a href='../controller/pedidoControle.php?op=removerQuantidade&id=$id_produto&valor=$valor&origem=clonar' class='btn-remover'>Remover produto</a>";
                            echo "</div>";
                        } else {
                            echo "<p><b>Produto ID $id_produto</b> não foi encontrado no estoque.</p>";
                        }
                    }
                } else {
                    echo "<p>Nenhum produto adicionado ao pedido.</p>";
                }
                ?>
            </div>

            <div class="infos-pedido">
                <div class='total-pedido'>
                    <p><b>Total do pedido</b>: R$ <?php echo number_format($_SESSION['total_compra'], 2, ',', '.') ?> </p>
                </div>

                <form action="../controller/pedidoControle.php" method="get">
                    <input type="hidden" name="op" value="cadastrar">
                    <div class="form-pedidos-items">
                        <fieldset id="pedidos-form">
                            <label for="prazoPedido" class="label-column">
                                Prazo de entrega do novo pedido
                                <input type="date" name="prazoPedido" id="prazoPedido" class="input-pedido" required>
                            </label>
                            <label for="statusPedido" class="label-column">
                                Status do Novo Pedido
                                <select name="statusPedido" id="statusPedido">
                                    <option value="encomendado">Encomendado</option>
                                    <option value="pagamento">Aguardando pagamento</option>
                                    <option value="vendido">Vendido</option>
                                </select>
                            </label>
                            <div id="containerVendido" style="display: none;">
                                <label class="label-baixa-estoque">Dar baixa no estoque?
                                    <input type="checkbox" name="darBaixaEstoque" id="darBaixaEstoque" class="input-produto input-checkbox" value="1">
                                </label>
                            </div>
                            <label for="comentarioPedido" class="label-column">
                                Comentários / Observações
                                <textarea name="comentarioPedido" id="comentarioPedido" class="input-pedido" placeholder="Detalhes do novo pedido..."></textarea>
                            </label>
                        </fieldset>
                    </div>
                    <div class="form-pedidos-items">
                        <button type="submit">Cadastrar</button>
                        <a href="../controller/pedidoControle.php?op=limparCarrinho">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>

        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>

    <script src="busca_produtos_pedido.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusPedido = document.getElementById("statusPedido");
            const containerVendido = document.getElementById("containerVendido");

            function gerenciarCheckboxes() {
                if (statusPedido.value === "vendido") {
                    containerVendido.style.display = "block";
                } else {
                    containerVendido.style.display = "none";
                    document.getElementById("darBaixaEstoque").checked = false;

                }
            }

            statusPedido.addEventListener("change", gerenciarCheckboxes);
            gerenciarCheckboxes();
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