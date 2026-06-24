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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=dehaze" />


    <title>Pedidos</title>
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
                echo "<div id='session-msg'>" . $_SESSION['msg'].  "</div>";
            unset($_SESSION["msg"]);
            }
        ?>

        <div class="internal-nav">
            <h1>Alteração de Pedido</h1>
            <div class="internal-nav-links">
                <a href="gui_visualizacao_pedidos.php">Visualizar pedidos</a>
            </div>
        </div>

        <h2>Número do pedido: <?php echo $numero_pedido = str_pad($id_pedido, 4, '0', STR_PAD_LEFT); ?></h2>

        
            <details>
                <summary style="cursor: pointer;">Clique para adicionar produtos à pedido</summary> 
                    <div class="adicionar-produtos">

                        <form onsubmit="return false;">
                            <input type="text" id="pesquisa-produtos" class="input-pesquisa" placeholder="Busque pelo nome ou descrição" autocomplete="off">
                        </form>

                        <p>Adicione os produtos ao pedido</p>

                        <div class="lista-produtos">
                            <?php if (!empty($listaProdutos)): ?>
                                <?php foreach ($listaProdutos as $item):?>
                                    <div class="product-view">
                                        <p><strong>Nome do produto:</strong> <?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></p>
                                        <p><strong>Quantidade disponível:</strong> <?php echo htmlspecialchars($item['quantidade']);?> </p>
                                        <p><strong>Valor unitário:</strong> <?php echo "R$ " . number_format((float)$item['valor_unitario'], 2, ',', '.'); ?> </p>

                                        <p><strong>Aceita encomenda:</strong> <?php if ($item['aceita_encomenda']) {echo "Sim";} else {echo "Não"; } ?></p>
                        
                                        <p><strong>Descrição:</strong> <?php if ($item['descricao']) {echo htmlspecialchars($item['descricao']); } else { echo "Não informada";}?></p>
                        
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
        
            <div class="produtos-na-pedido">
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

                            echo "<h4>Produto</b>: " . htmlspecialchars($produtoVendido['nome']) . "</h4><br>";
                            echo "<p>";
                            echo "<b>Quantidade</b>: " . $quantidade . "<br>";
                            echo "<b>Valor do produto</b>: R$ " . number_format((float)$produtoVendido['valor_unitario'], 2, ',', '.') . "<br>";

                            $valor_total = (float)$produtoVendido['valor_unitario'];
                            $valor_total = $valor_total * $quantidade;
        
                            echo "<b>Valor total</b>: R$ " . (number_format((float)$valor_total, 2, ',', '.')) . "<br>";
                            echo "<a href='../controller/pedidoControle.php?op=removerQuantidade&id=$id_produto&id_pedido=$id_pedido'>Remover produto</a>";
                            echo "</form>";
                        } else {
                            echo "<p><b>Produto ID $id_produto</b> não foi encontrado no estoque.</p>";
                        }
                    }
                } else {
                    echo "<p>Nenhum produto encontrado nesta pedido.</p>";
                }

                echo "<p><b>Total do pedido</b>: R$ " . number_format($_SESSION['total_compra'], 2, ',', '.') . "</p>";

                ?>
            </div>


        <form action="../controller/pedidoControle.php" method="get">
            <input type="hidden" name="op" value="alterar">
            

            <fieldset id="pedidos-form">
                <div>
                    <label for="prazopedido">
                        Prazo de entrega
                        <input type="date" name="prazoPedido" id="prazoPedido" class="input-pedido" required value="<?php echo $infoPedido['data'] ?>">
                    </label>
                    <label for="statusPedido">
                        Status da Pedido

                        <select name="statusPedido" id="statusPedido">
                            <option value="encomendado" <?= $infoPedido['status'] == 'encomendado' ? 'selected' : '' ?>>Encomendado</option>
                            <option value="pagamento" <?= $infoPedido['status'] == 'pagamento' ? 'selected' : '' ?>>Aguardando pagamento</option>
                            <option value="vendido" <?= $infoPedido['status'] == 'vendido' ? 'selected' : '' ?>>Vendido</option>
                            <option value="cancelado" <?= $infoPedido['status'] === 'cancelado' ? 'selected' : '' ?> >Cancelado</option>
                        </select>
                    </label>

                    <div id="containerVendido" style="display: none;">
                        <label style="display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" name="darBaixaEstoque" id="darBaixaEstoque" value="1">
                            Dar baixa no estoque?
                        </label>
                    </div>

                    <div id="containerCancelado" style="display: none;">
                        <p>Atenção: Um pedido cancelado não poderá mais ser editado posteriormente!</p>
                        <label style="display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" name="estornarEstoque" id="estornarEstoque" value="1">
                            Devolver produtos ao estoque?
                        </label>
                    </div>

                </div>

                <label for="comentarioPedido">
                        Comentários
                <textarea name="comentarioPedido" id="comentarioPedido" placeholder="Detalhes da pedido, dos produtos, da entrega, do cliente, entre outros."><?php echo $infoPedido['comentario'] ?></textarea>
                </label>

            </fieldset>
           
            <div class="product-btns">
                <button type="submit">Alterar</button>
                <button formaction="../controller/pedidoControle.php?op=carregarQuantidade&id=<?php echo $id_pedido; ?>&clonar=true" class="btn-add">Clonar</button>
                <button formaction="../view/gui_visualizacao_pedidos.php">Voltar</button>        
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
        const containerCancelado = document.getElementById("containerCancelado");

        // Função que gerencia o que deve aparecer baseado no valor selecionado
        // O parâmetro 'origemDoClique' serve para saber se foi o usuário mudando manualmente
        function gerenciarCheckboxes(origemDoClique = false) {
            const valorSelecionado = statusPedido.value;

            if (valorSelecionado === "vendido") {
                containerVendido.style.display = "block";   // Mostra o de venda
                containerCancelado.style.display = "none";  // Esconde o de cancelamento
            } else if (valorSelecionado === "cancelado") {
                containerVendido.style.display = "none";  // Esconde o de venda
                containerCancelado.style.display = "block"; // Mostra o de cancelamento
                
                // Se foi uma mudança manual do usuário no select, exibe o aviso pop-up
                if (origemDoClique === true) {
                    alert("Atenção: Se você salvar este pedido como CANCELADO, ele não poderá mais ser editado!");
                }
            } else {
                // Se for "encomendado" ou "pagamento", esconde ambos
                containerVendido.style.display = "none";
                containerCancelado.style.display = "none";
            }
        }

        // 1. Escuta a mudança de opções no select pelo usuário (passando true para indicar clique manual)
        statusPedido.addEventListener("change", function() {
            gerenciarCheckboxes(true);
        });

        // 2. Executa uma vez ao carregar a página (sem passar parâmetro para não disparar o alert na abertura)
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
</body>
</html>