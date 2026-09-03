<?php
session_start();
require_once '../../model/usuario.class.php';
require_once '../../model/produto.class.php';
require_once '../../dao/produtodao.class.php';
require_once '../../dao/pedidodao.class.php';
require_once '../../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

$produtoDAO = new ProdutoDAO();

$listaProdutos = $produtoDAO->listarTodosProdutos($usuario->id_usuario);

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

$dadosRascunho   = $_SESSION['dados_pedido'] ?? [];
$prazoExibicao   = $dadosRascunho['prazoPedido'] ?? $data;
$statusExibicao  = $dadosRascunho['statusPedido'] ?? $infoPedidoSession['status'];
$comentExibicao  = $dadosRascunho['comentarioPedido'] ?? $infoPedidoBanco['comentario'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../../../assets/img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../../assets/css/variables.css">
    <link rel="stylesheet" href="../../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../../assets/css/components.css">
    <link rel="stylesheet" href="../../../assets/css/responsive.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">



    <title>Alteração de pedido- Nize</title>
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
                <a href="../produtos/visualizacao_produtos.php" title="Tela de produtos">
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
        <?php
        if (isset($_SESSION["msg"])) {
            echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
            unset($_SESSION["msg"]);
        }
        ?>

        <div class="internal-nav">
            <div class="internal-nav-links">
                <h1 class="num-pedido">Alteração - Pedido <?php echo str_pad($infoPedidoBanco['num_pedido'], 4, '0', STR_PAD_LEFT); ?></h1>
                <a href="visualizacao_pedidos.php" title="Tela de pedidos"><span class="bi bi-arrow-left"></span>Voltar</a>
            </div>

        </div>



        <details class="produtos-pedido">
            <summary class="summary-pedido">Adicione os produtos ao pedido</summary>
            <!-- <div class="adicionar-produtos"> -->

            <form onsubmit="return false;" id="form-pesquisa-produtos" class="form-produto-pedido">
                <input type="text" id="pesquisa-produtos" placeholder="Busque pelo nome ou descrição" autocomplete="off" maxlength="50"><span id="search-icon" class="bi bi-search"></span>
            </form>

            </div>
            <div class="lista-produtos-pedido">
                <?php if (!empty($listaProdutos)): ?>
                    <?php foreach ($listaProdutos as $item): ?>
                        <div class="product-view">
                            <div class="texto-produto">
                                <h2><?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></h2>
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
                                }

                                if (htmlspecialchars($item['aceita_visualizacao']) === '1') {
                                    $aceita_visualizacao = "Sim";
                                } else {
                                    $aceita_visualizacao = "Não";
                                }

                                ?>
                                <p><strong>Disponível para visualização:</strong> <?php echo $aceita_visualizacao; ?></p>

                                <details class="detalhes-produto">
                                    <summary>Mais detalhes</summary>
                                    <p><strong>Valor de custo:</strong> <?php echo $valor_custo; ?></p>
                                    <?php
                                    if (htmlspecialchars($item['aceita_encomenda']) === '1') {
                                        $aceita_encomenda = "Aceita";
                                    } else {
                                        $aceita_encomenda = "Não aceita";
                                    }
                                    ?>
                                    <p><strong>Aceita encomenda:</strong> <?php echo $aceita_encomenda; ?></p>

                                    <p class="p-descricao"><strong>Comentário:</strong>
                                        <?php if ($item['comentario']) {
                                            echo htmlspecialchars($item['comentario']);
                                        } else {
                                            echo "--";
                                        } ?></p>
                                    <p class="p-descricao"><strong>Informações:</strong>
                                        <?php if ($item['descricao']) {
                                            echo htmlspecialchars($item['descricao']);
                                        } else {
                                            echo "--";
                                        } ?></p>
                                </details>
                            </div>
                            <div class="product-img-btn">
                                <?php if ($item['imagem']) {
                                    echo "<img src='../../persistence/uploads/" . htmlspecialchars($item['imagem']) . "' alt='imagem do produto' class='img-produtos'>";
                                } else {
                                    echo "<p class='img-produtos sem-imagem'>Nenhuma imagem cadastrada</p>";
                                } ?>
                                <form action="../../controller/pedidoControle.php" method="get" class="product-btns form-add-produto">
                                    <input type="number" step="1" min="0" onkeydown="return ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.key) || !isNaN(Number(event.key))" name="quantidadeVendida" id="quantidadeVendida" class="input-pedido" maxlength="3" placeholder="Quantidade" autocomplete="off">
                                    <input type="hidden" name="op" value="adicionarQuantidade">
                                    <input type="hidden" name="id" value="<?php echo $item['id_produto']; ?>">
                                    <input type="hidden" name="id_pedido" value="<?php echo $id_pedido; ?>">

                                    <!-- Inputs ocultos para capturar o formulário de alteração -->
                                    <input type="hidden" name="prazoPedido" class="hdn-prazo">
                                    <input type="hidden" name="statusPedido" class="hdn-status">
                                    <input type="hidden" name="comentarioPedido" class="hdn-comentario">

                                    <input type="submit" class="btn-add" value="+ Adicionar">
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: echo "Nenhum produto cadastrado." ?>
                <?php endif; ?>
            </div>
        </details>

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
                            echo "<b>Valor unitário</b>: R$ " . number_format($valor_unitario, 2, ',', '.') . "<br>";
                            echo "<b>Valor total</b>: R$ " . number_format($valor_total_item, 2, ',', '.') . "</p>";

                            // Exibir o botão de remoção apenas se for a tela de alteração normal
                            if (basename($_SERVER['PHP_SELF']) == 'alteracao_pedidos.php') {
                                echo "<a href='../../controller/pedidoControle.php?op=removerQuantidade&id=$id_produto&id_pedido=$id_pedido' class='btn-remover'><span class='bi bi-x-square'></span>Remover</a>";
                            }

                            echo "</div>";
                        } else {
                            echo "<p><b>Produto ID $id_produto</b> não foi encontrado no estoque.</p>";
                        }
                    }
                } else {
                    echo "<p>Nenhum produto encontrado no pedido.</p>";
                }

                $dataBanco = $infoPedidoBanco['data'];
                $formatoData = strtotime($dataBanco);
                $data = date("Y-m-d", $formatoData);
                ?>
            </div>
            <div class="infos-pedido">
                <div class='total-pedido'>
                    <p><b>Total do pedido</b>: R$ <?php echo number_format($_SESSION['total_compra'], 2, ',', '.') ?> </p>
                </div>
                <form action="../../controller/pedidoControle.php" method="get">
                    <input type="hidden" name="op" value="alterar">
                    <div class="form-pedidos-items">
                        <fieldset id="pedidos-form">
                            <label for="prazoPedido">
                                Prazo de entrega*
                                <input type="date" placeholder="00/00/0000" name="prazoPedido" id="prazoPedido" class="input-pedido" autocomplete="off" required value="<?php echo htmlspecialchars($prazoExibicao); ?>">
                            </label>
                            <label for="statusPedido">
                                Status do Pedido
                                <select name="statusPedido" id="statusPedido">
                                    <option value="encomendado" <?= $statusExibicao == 'encomendado' ? 'selected' : '' ?>>Encomendado</option>
                                    <option value="encomenda_online" <?= $statusExibicao == 'encomenda_online' ? 'selected' : '' ?>>Encomenda online</option>
                                    <option value="pagamento" <?= $statusExibicao == 'pagamento' ? 'selected' : '' ?>>Aguardando pagamento</option>
                                    <option value="vendido" <?= $statusExibicao == 'vendido' ? 'selected' : '' ?>>Vendido</option>
                                    <option value="cancelado" <?= $statusExibicao === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                </select>
                            </label>
                            <div id="containerVendido" style="display: none;">
                                <label class="label-baixa-estoque">
                                    Dar baixa no estoque?
                                    <input type="checkbox" name="darBaixaEstoque" id="darBaixaEstoque" class="input-produto input-checkbox" value="1" autocomplete="off">
                                </label>
                            </div>
                            <div id="containerCancelado" style="display: none;">
                                <p>Atenção: <br> Pedidos cancelados não podem ser editados!<br></p>
                                <label class="label-baixa-estoque">
                                    Devolver produtos ao estoque?
                                    <input type="checkbox" name="estornarEstoque" id="estornarEstoque" class="input-produto input-checkbox" value="1" autocomplete="off">
                                </label>
                            </div>

                            <label for="comentarioPedido">
                                Comentários
                                <textarea maxlength="500" rows="5" cols="40" name="comentarioPedido" id="comentarioPedido" placeholder="Detalhes do pedido, dos produtos, da entrega, do cliente, entre outros."><?php echo htmlspecialchars($comentExibicao); ?></textarea>
                            </label>
                            <?php if ($infoPedidoBanco['mensagem_cliente']): ?>
                                <p><b>Mensagem do cliente</b>: <?php echo htmlspecialchars($infoPedidoBanco['mensagem_cliente']); ?></p>
                            <?php endif; ?>
                        </fieldset>
                    </div>
                    <div class="form-pedidos-items">
                        <button type="submit" class="btn-alt-pedido"><span class="bi bi-check2"></span>Alterar</button>
                        <a href="../../controller/pedidoControle.php?op=excluir&id=<?php echo $id_pedido ?>" onclick="return confirm('Deseja mesmo excluir?\n\nESSA AÇÃO NÃO PODE SER DESFEITA.');"><span class="bi bi-trash3"></span>Excluir</a>
                    </div>
                </form>
            </div>
        </div>


        <footer><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.</a></footer>
        <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
    </main>

    </div>

    <script type="module" src="../../../js/main.js"></script>

    <script src="../../../js/busca_produtos_pedido.js"></script>


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