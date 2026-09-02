<?php
session_start();
require_once '../../model/usuario.class.php';
require_once '../../model/produto.class.php';
require_once '../../dao/produtodao.class.php';
require_once '../../dao/usuariodao.class.php';


$nome_visualizacao = trim($_GET['loja']);

$produtoDAO = new ProdutoDAO();
$usuarioDAO = new UsuarioDAO();

$id_usuario = (int)$usuarioDAO->buscarId($nome_visualizacao);
$dadosView = $usuarioDAO->buscarAceitaView($id_usuario);

$aceita_visualizacao = $dadosView['aceita_visualizacao'];

$dadosNomeLoja = $usuarioDAO->buscarNomeLoja($id_usuario);

$nome_loja = $dadosNomeLoja['nome_loja'];

$dadosTelefone = $usuarioDAO->buscarTelefone($id_usuario);
$telefone = $dadosTelefone['telefone'];


$lista = $produtoDAO->listarTodosProdutosAbertos($id_usuario);

if (!empty($_SESSION['usuario_logado'])) {
    $logo_link = "../general/tela_inicial.php";
} else {
    $logo_link = "../../../index.php";
}

?>

<!DOCTYPE html>
<html lang="pt-br" class="html-loja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../../../assets/img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../../assets/css/variables.css">
    <link rel="stylesheet" href="../../../assets/css/sidebar.css">
    <link rel="stylesheet" href="../../../assets/css/components.css">
    <link rel="stylesheet" href="../../../assets/css/responsive.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <title><?php echo $nome_loja ?>- Nize</title>
</head>

<body>

    <aside id="sidebar" class="sacola-compras">
        <ul>
            <?php if ($aceita_visualizacao === 1 && !empty($telefone)): ?>
                <li>
                    <a href="#" data-resize-btn class="btn-menu btn-sacola" title="Esconder/expandir menu">
                        <i class="bi bi-bag"></i>
                    </a>
                </li>
            <?php endif; ?>

            <li class="li-img-sidenav">
                <a href="<?php echo $logo_link ?>" class="link-logo" title="Tela inicial">
                    <img src="../../../assets/img/logo/nize_new.png" alt="Nize" id="logo-sidenav-view">
                </a>
            </li>


            <li class="produtos-sacola-sidenav">
                <div class="produtos-no-pedido">
                    <?php
                    $_SESSION['total_compra'] = 0.00;
                    // 1. Mudamos de $_SESSION['carrinho'] para $_SESSION['sacola']
                    if (!empty($_SESSION['sacola'])) {
                        foreach ($_SESSION['sacola'] as $id_produto => $item) {
                            // Suporta se o item for array ou apenas inteiro
                            $quantidade = is_array($item) ? (int)$item['quantidade'] : (int)$item;
                            $produtoVendido = $produtoDAO->buscarPorId($id_produto);

                            if ($produtoVendido) {
                                $valor_unitario = (float)$produtoVendido['valor_unitario'];
                                $valor = $valor_unitario * $quantidade;
                                $_SESSION['total_compra'] += $valor;

                                echo "<div class='produto-individual'>";
                                echo "<div class='texto-produto'>";
                                echo "<h3>" . htmlspecialchars($produtoVendido['nome']) . "</h3><br>";
                                echo "<p>";
                                echo "<b>Quantidade</b>: " . $quantidade . "<br>";
                                echo "<b>Valor unitário</b>: R$ " . number_format($valor_unitario, 2, ',', '.') . "<br>";
                                echo "<b>Valor total</b>: R$ " . number_format($valor, 2, ',', '.') . "</p>";
                                echo "</div>";

                                // Link de remoção passando origem=loja e nome da loja
                                echo "<a href='../../controller/pedidoControle.php?op=removerQuantidade&id=$id_produto&valor=$valor&origem=loja&loja=" . urlencode($nome_visualizacao) . "' class='btn-remover'><span class='bi bi-x-square'></span>Remover</a>";
                                echo "</div>";
                                echo "<hr>";
                            } else {
                                echo "<p><b>Produto</b> não foi encontrado no estoque.</p>";
                            }
                        }
                    } else {
                        echo "<p style='margin-bottom: 0.5em'>Nenhum produto adicionado ao pedido.</p>";
                    }
                    ?>
                </div>

                <div class='total-pedido'>
                    <p><b>Total do pedido</b>: R$ <?php echo "<span id='total-compra'>" . number_format($_SESSION['total_compra'], 2, ',', '.') . "</span>"; ?></p>
                </div>

                <div class="pedido-loja">
                    <form action="../../controller/pedidoControle.php" method="get">
                        <input type="hidden" name="op" value="solicitarPedido">
                        <input type="hidden" name="loja" value="<?php echo htmlspecialchars($nome_visualizacao); ?>">

                        <div class="info-btn-sacola">
                            <p>Informações do pedido</p>
                            <label for="nomeCliente">Nome completo<input type="text" name="nomeCliente" placeholder="Nome e Sobrenome" class="input-produto" pattern=".*\s+.*" title="Digite pelo menos nome e sobrenome com um espaço" maxlength="50" required></label>

                            <label for="telefoneCliente">Telefone<input type="tel" name="telefoneCliente" placeholder="Ex: 55 99999999" class="input-produto" maxlength="16" required></label>

                            <label for="mensagemCliente" class="label-column">
                                <textarea maxlength="500" rows="5" cols="40" name="mensagemCliente" id="mensagemCliente" class="input-pedido" placeholder="Gostaria de adicionar alguma informação?" maxlength="500" rows="5" cols="40"></textarea required>
                            </label>
                            <div class="product-btns">
                                <button type="submit"><span class="bi bi-check2"></span>Enviar</button>
                                <!-- Botão Limpar apenas para a view_loja -->
                                <a href="../../controller/pedidoControle.php?op=limparCarrinho&origem=loja&loja=<?php echo urlencode($nome_visualizacao); ?>"><span class="bi bi-arrow-clockwise"></span>Limpar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
        </ul>
    </aside>

    <header id="header-mobile">
        <div class="container-header container-header-loja">
            <a href="#" data-resize-btn-mobile class="btn-menu btn-sacola" title="Esconder/expandir menu">
                <i class="bi bi-bag"></i>
            </a>
            <a href="../general/tela_inicial.php" class="link-logo-header" title="Tela inicial">
                <img src="../../../assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-header">
            </a>
        </div>
    </header>


    <main class='conteudo-pagina conteudo-loja'>
        <div class="internal-nav">
            <?php
            if (isset($_SESSION["msg"])) {
                echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
                unset($_SESSION["msg"]);
            }

            if (isset($_SESSION['pedido_sucesso']) && $_SESSION['pedido_sucesso'] === true) {
                $numPedido = $_SESSION['ultimo_pedido_num'] ?? '';

                unset($_SESSION['pedido_sucesso']);
                unset($_SESSION['ultimo_pedido_num']);

                // Exemplo: Enviando o número do pedido junto na mensagem do WhatsApp
                $mensagemWpp = urlencode("Olá! Acabei de fazer o pedido *#{$numPedido}* na loja.");
                $urlDestino  = !empty($telefone) ? "https://wa.me/55{$telefone}?text={$mensagemWpp}" : "tela_inicial.php";
            ?>
                <script>
                    setTimeout(function() {
                        window.open("<?php echo $urlDestino; ?>", "_blank");
                    }, 3000);
                </script>
            <?php
            }

            if ($aceita_visualizacao === 1): ?>

                <?php if (!empty($nome_loja)): ?>
                <h1 class="nome-loja"><?php echo $nome_loja; ?></h1>
                <?php endif; ?>

                <div class="internal-nav-inputs">
                    <form onsubmit="return false;" id="form-pesquisa-produtos">
                        <input type="text" id="pesquisa-produtos" class="pesquisa-loja" placeholder="🔎︎ Busque pelo nome ou descrição" autocomplete="off" maxlength="50">
                    </form>

                    <details class="filtros-produtos">
                        <summary><span class="bi bi-filter"></span>Filtrar</summary>
                        <div>
                            <select id="filtro-order">
                                <option value="nome-asc">Ordenar por</option>
                                <option value="nome-asc">Nome (crescente)</option>
                                <option value="nome-desc">Nome (decrecente)</option>
                                <option value="valor-asc">Preço (crescente)</option>
                                <option value="valor-desc">Preço (decrecente)</option>
                            </select>
                            <button type="button" id="btn-limpar-filtros"><span class="bi bi-arrow-clockwise"></span>Limpar</button>
                        </div>
                    </details>
                </div>
        </div>
    <?php endif; ?>

    <div class="lista-produtos lista-produtos-loja">


        <?php if (!empty($lista) && $aceita_visualizacao === 1): ?>
            <?php foreach ($lista as $item): ?>
                <div class="product-view product-view-loja">
                    <div class="texto-produto">
                        <h2><strong><?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></strong></h2>

                        <?php if ($item['imagem']) {
                            echo "<img src='../../persistence/uploads/" . htmlspecialchars($item['imagem']) . "' alt='imagem do produto' class='img-produtos'>";
                        } else {
                            echo "<img src='#' alt='Produto sem imagem' class='img-produtos sem-imagem'>";
                        } ?>

                        <?php if ($item['valor_unitario']) {
                            $valor_unitario = "R$ " . number_format($item['valor_unitario'], 2, ',', '.');
                        } else {
                            $valor_unitario = "Não informado";
                        } ?>

                        <p class="p-valor"><strong><?php echo $valor_unitario ?></strong></p>
                        
                    </div>
                    
                    <p class="p-descricao"><?php echo htmlspecialchars($item['descricao']) ?></p>
                    
                    <div class="product-img-btn">
                        <form action="../../controller/pedidoControle.php" method="get" class="product-btns">
                            <input type="number"  step="1" min="0" onkeydown="return ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.key) || !isNaN(Number(event.key))"
                            name="quantidadeVendida" id="quantidadeVendida" class="input-pedido" maxlength="3" placeholder="Quantidade" autocomplete="off">
                            <input type="hidden" name="op" value="adicionarSacola">
                            <input type="hidden" name="id" value="<?php echo $item['id_produto']; ?>">
                            <input type="hidden" name="loja" value="<?php echo htmlspecialchars($nome_visualizacao); ?>">
                            <input type="submit" class="btn-add" value="+ Adicionar">
                        </form>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: echo "Nenhum produto cadastrado." ?>
        <?php endif; ?>


    </div>
    <div class="div-btn-wpp">
        <?php if ($aceita_visualizacao === 1 && !empty($telefone)): ?>
            <a href="https://wa.me/<?php echo "55" . $telefone; ?>" target="_blank"><img src="../../../assets/img/icons/whatsapp64.png" alt="botão whatsapp"></a>
        <?php endif; ?>
    </div>

    <footer><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.</a></footer>
    <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
    </main>

    <script src="../../../js/busca_produtos.js"></script>
    <script type="module" src="../../../js/main.js"></script>

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