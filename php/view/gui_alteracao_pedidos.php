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

$listaProdutos = $produtoDAO->listarTodosProdutos($usuario->id_usuario);

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
                <h1>Alteração de Pedido</h1>
                <a href="gui_visualizacao_pedidos.php">Visualizar pedidos</a>
            </div>
            <h2>Número do pedido: <?php echo $numero_pedido = str_pad($id_pedido, 4, '0', STR_PAD_LEFT); ?></h2>
        </div>



        <details class="produtos-pedido">
            <summary>Adicione os produtos ao pedido</summary>
            <div class="adicionar-produtos">

                <form onsubmit="return false;" id="form-pesquisa-produtos" class="form-produto-pedido">
                    <input type="text" id="pesquisa-produtos" placeholder="Busque pelo nome ou descrição" autocomplete="off"><span id="search-icon" class="bi bi-search"></span>
                </form>

                <div class="lista-produtos-pedido">
                    <?php if (!empty($listaProdutos)): ?>
                        <?php foreach ($listaProdutos as $item): ?>
                            <div class="product-view">
                                <p><strong>Nome do produto:</strong> <?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></p>
                                <p><strong>Quantidade disponível:</strong> <?php echo htmlspecialchars($item['quantidade']); ?> </p>
                                <p><strong>Valor unitário:</strong> <?php echo "R$ " . number_format((float)$item['valor_unitario'], 2, ',', '.'); ?> </p>

                                <p><strong>Aceita encomenda:</strong> <?php if ($item['aceita_encomenda']) {
                                                                            echo "Sim";
                                                                        } else {
                                                                            echo "Não";
                                                                        } ?></p>

                                <p><strong>Descrição:</strong> <?php if ($item['descricao']) {
                                                                    echo htmlspecialchars($item['descricao']);
                                                                } else {
                                                                    echo "Sem informações";
                                                                } ?></p>

                                <?php if ($item['imagem']) {
                                    echo "<img src='uploads/" . htmlspecialchars($item['imagem']) . "' alt='imagem do produto' class='img-produtos'>";
                                } else {
                                    echo "<p class='img-produtos'>Nenhuma imagem cadastrada</p>";
                                } ?>

                                <form action="../controller/pedidoControle.php" method="get" class="product-btns">
                                    <input type="number" name="quantidadeVendida" id="quantidadeVendida" class="input-pedido" maxlength="3" placeholder="Digite a quantidade" autocomplete="off">
                                    <input type="hidden" name="op" value="adicionarQuantidade">
                                    <input type="hidden" name="id" value="<?php echo $item['id_produto']; ?>">
                                    <input type="submit" class="btn-add" value="Adicionar ao pedido">
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php else: echo "Nenhum produto cadastrado." ?>
                    <?php endif; ?>
                </div>
            </div>
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
                            $quantidade =  (int)$quantidade;
                            $valor = $valor_unitario * $quantidade;
                            $_SESSION['total_compra'] += $valor;
                            echo "<div class='produto-individual'>";
                            echo "<h3>" . htmlspecialchars($produtoVendido['nome']) . "</h3><br>";
                            echo "<p>";
                            echo "<b>Quantidade</b>: " . $quantidade . "<br>";
                            echo "<b>Valor unitário</b>: R$ " . number_format((float)$produtoVendido['valor_unitario'], 2, ',', '.') . "<br>";
                            $valor_total = (float)$produtoVendido['valor_unitario'];
                            $valor_total = $valor_total * $quantidade;
                            echo "<b>Valor total</b>: R$ " . (number_format((float)$valor_total, 2, ',', '.')) . "<br><br>";
                            echo "<a href='../controller/pedidoControle.php?op=removerQuantidade&id=$id_produto&id_pedido=$id_pedido' class='btn-remover'>Remover produto</a>";
                            // echo "</form>";
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
                    <input type="hidden" name="op" value="alterar">
                    <div class="form-pedidos-items">
                        <fieldset id="pedidos-form">
                            <!-- <div> -->
                            <label for="prazopedido">
                                Prazo de entrega
                                <input type="date" name="prazoPedido" id="prazoPedido" class="input-pedido" required value="<?php echo $infoPedido['data'] ?>">
                            </label>
                            <label for="statusPedido">
                                Status do Pedido
                                <select name="statusPedido" id="statusPedido">
                                    <option value="encomendado" <?= $infoPedido['status'] == 'encomendado' ? 'selected' : '' ?>>Encomendado</option>
                                    <option value="pagamento" <?= $infoPedido['status'] == 'pagamento' ? 'selected' : '' ?>>Aguardando pagamento</option>
                                    <option value="vendido" <?= $infoPedido['status'] == 'vendido' ? 'selected' : '' ?>>Vendido</option>
                                    <option value="cancelado" <?= $infoPedido['status'] === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                </select>
                            </label>
                            <div id="containerVendido" style="display: none;">
                                <label class="label-baixa-estoque">
                                    Dar baixa no estoque?
                                    <input type="checkbox" name="darBaixaEstoque" id="darBaixaEstoque" class="input-produto input-checkbox" value="1">
                                </label>
                            </div>
                            <div id="containerCancelado" style="display: none;">
                                <p>Atenção: <br> Um pedido cancelado não poderá mais ser editado posteriormente!<br></p>
                                <label class="label-baixa-estoque">
                                    Devolver produtos ao estoque?
                                    <input type="checkbox" name="estornarEstoque" id="estornarEstoque" class="input-produto input-checkbox" value="1">
                                </label>
                            </div>
                            <!-- </div> -->
                            <label for="comentarioPedido">
                                Comentários
                                <textarea name="comentarioPedido" id="comentarioPedido" placeholder="Detalhes do pedido, dos produtos, da entrega, do cliente, entre outros."><?php echo $infoPedido['comentario'] ?></textarea>
                            </label>
                        </fieldset>
                    </div>
                    <div class="form-pedidos-items">
                        <button type="submit" class="btn-alt-pedido">Alterar</button>
                        <a href="../controller/pedidoControle.php?op=carregarQuantidade&id=<?php echo $id_pedido; ?>&clonar=true" class="btn-alt-pedido">Clonar</a>
                        <button formaction="../view/gui_visualizacao_pedidos.php" class="btn-alt-pedido">Voltar</button>
                    </div>
                </form>
            </div>
        </div>


        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>

    </div>

    <script src="busca_produtos_pedido.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusPedido = document.getElementById("statusPedido");
            const containerVendido = document.getElementById("containerVendido");
            const containerCancelado = document.getElementById("containerCancelado");


            function gerenciarCheckboxes(origemDoClique = false) {
                const valorSelecionado = statusPedido.value;

                if (valorSelecionado === "vendido") {
                    containerVendido.style.display = "block";
                    containerCancelado.style.display = "none";
                } else if (valorSelecionado === "cancelado") {
                    containerVendido.style.display = "none";
                    containerCancelado.style.display = "block";


                    if (origemDoClique === true) {
                        alert("Atenção: Se você salvar este pedido como CANCELADO, ele não poderá mais ser editado!");
                    }
                } else {
                    containerVendido.style.display = "none";
                    containerCancelado.style.display = "none";
                    document.getElementById("darBaixaEstoque").checked = false;
                    document.getElementById("estornarEstoque").checked = false;

                }
            }

            statusPedido.addEventListener("change", function() {
                gerenciarCheckboxes(true);
            });

            gerenciarCheckboxes(false);
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