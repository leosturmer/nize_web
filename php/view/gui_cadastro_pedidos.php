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

if (isset($_SESSION['pedidoSelecionado'])) {
    unset($_SESSION['pedidoSelecionado']);
}

if (isset($_SESSION['encomendaSelecionada'])) {
    unset($_SESSION['encomendaSelecionada']);
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


    <title>Cadastro de pedido</title>
</head>

<body>
    <details class="coll-sidenav" open>
        <summary><span class="material-symbols-outlined">dehaze</span></summary>
        <div class="sidenav">
            <img src="../../img/logo/nize_new.png" alt="Nize" id="logo-sidenav">
            <a href="tela_inicial.php">Tela inicial</a>
            <a href="gui_visualizacao_produtos.php">Produtos</a>
            <a href="gui_visualizacao_pedidos.php">Pedidos</a>
            <a href="gui_minha_area.php">Minha área</a>
            <a href="../controller/logout.php" id="btn-sair">Encerrar sessão</a>
        </div>
    </details>
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
                    <h1>Cadastro de pedido</h1>
                    <a href="gui_visualizacao_pedidos.php">Visualizar pedidos</a>
                </div>
            </div>

            <details class="produtos-pedido">
                <summary>Adicione os produtos ao pedido</summary>
                <div class="adicionar-produtos">

                    <form onsubmit="return false;" id="form-pesquisa-produtos" class="form-produto-pedido">
                        <input type="text" id="pesquisa-produtos" placeholder="Busque pelo nome ou descrição" autocomplete="off"><span class="material-symbols-outlined" id="search-icon">search</span>
                    </form>

                    <div class="lista-produtos-pedido">
                        <?php if (!empty($listaProdutos)): ?>
                            <?php foreach ($listaProdutos as $item): ?>
                                <div class="product-view">
                                    <p><strong>Nome do produto:</strong> <?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></p>
                                    <p><strong>Quantidade disponível:</strong> <?php echo htmlspecialchars($item['quantidade']); ?> </p>
                                    <p><strong>Valor unitário: R$</strong> <?php echo number_format((float)$item['valor_unitario'], 2, ',', '.') ?> </p>


                                    <p><strong>Aceita encomenda:</strong> <?php echo $item['aceita_encomenda'] ? "Sim" : "Não"; ?></p>

                                    <p class="p-descricao"><strong>Descrição:</strong> <?php if (htmlspecialchars($item['descricao'])) {
                                                                                            echo htmlspecialchars($item['descricao']);
                                                                                        } else {
                                                                                            echo 'Sem informações';
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
                            echo "<b>Valor do produto</b>: R$ " . number_format((float)$produtoVendido['valor_unitario'], 2, ',', '.') . "<br>";

                            $valor_total = (float)$produtoVendido['valor_unitario'];
                            $valor_total = $valor_total * $quantidade;

                            echo "<b>Valor total</b>: R$ " . (number_format((float)$valor_total, 2, ',', '.')) . "<br><br>";

                            echo "<a href='../controller/pedidoControle.php?op=removerQuantidade&id=$id_produto&valor=$valor'>Remover produto</a>";

                            echo "</div>";
                        } else {
                            echo "<p><b>Produto ID $id_produto</b> não foi encontrado no estoque.</p>";
                        }
                    }
                } else {
                    echo "<p>Nenhum produto adicionado ao pedido.</p>";
                }

                echo "</div>";
                echo "<div class='total-pedido'><p><b>Total do pedido</b>: R$ " . number_format($_SESSION['total_compra'], 2, ',', '.') . "</p></div>";
                ?>


                <form action="../controller/pedidoControle.php" method="get">
                    <input type="hidden" name="op" value="cadastrar">

                    <div class="form-pedidos-items">
                        <fieldset id="pedidos-form">
                            <label for="prazoPedido" class="label-column">
                                Prazo de entrega
                                <input type="date" name="prazoPedido" id="prazoPedido" class="input-pedido" required>
                            </label>
                            <label for="statusPedido" class="label-column">
                                Status do Pedido
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
                                Comentários
                                <textarea name="comentarioPedido" id="comentarioPedido" class="input-pedido" placeholder="Detalhes do pedido, dos produtos, da entrega, do cliente, entre outros."></textarea>
                            </label>
                        </fieldset>

                    </div>
                    <div class="form-pedidos-items">
                        <button type="submit">Cadastrar</button>
                        <a href="../controller/pedidoControle.php?op=limparCarrinho">Resetar pedido</a>
                    </div>
                </form>


                <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
        </main>

    </div>

    <script src="busca_produtos_pedido.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusPedido = document.getElementById("statusPedido");
            const containerVendido = document.getElementById("containerVendido");

            function gerenciarCheckboxes() {
                const valorSelecionado = statusPedido.value;

                if (valorSelecionado === "vendido") {
                    containerVendido.style.display = "block"; // Mostra o de venda
                } else {
                    containerVendido.style.display = "none";
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

</body>

</html>