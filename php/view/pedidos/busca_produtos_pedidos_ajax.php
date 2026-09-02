<?php
session_start();
require_once '../../model/produto.class.php';
require_once '../../model/usuario.class.php';
require_once '../../util/seguranca.class.php';
require_once '../../dao/produtodao.class.php';

Seguranca::verificarAcesso();
header('Content-Type: text/html; charset=utf-8');

$pesquisa = trim($_GET['pesquisaProdutos'] ?? '');
$estoqueProduto = trim($_GET['filtroEstoque'] ?? '');
$encomendaProduto = trim($_GET['filtroEncomenda'] ?? '');
$ordenar = trim($_GET['ordenarPor'] ?? '');

$produtoDAO = new ProdutoDAO();

$usuario = unserialize($_SESSION['usuario_logado']);
$idUsuarioLogado = $usuario->id_usuario;

if (!empty($pesquisa)) {
    $lista = $produtoDAO->buscarProdutoFiltro($pesquisa, $estoqueProduto, $encomendaProduto, $ordenar, $idUsuarioLogado);
} else {
    $lista = $produtoDAO->listarTodosProdutos($idUsuarioLogado);
}

if (empty($lista)) {

    echo '<h4>Nenhum produto correspondente foi encontrado!</h4>';
    exit;
}

if (!empty($lista)) {
    foreach ($lista as $item) {
        echo '<div class="product-view">';
        echo '<div class="texto-produto">';
        echo '<h2>' . htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")) . '</h2>';
        
        echo '<p><strong>Quantidade: </strong>' . htmlspecialchars($item['quantidade']) . '</p>';

        if ($item['valor_unitario']) {
            $valor_unitario = "R$ " . number_format($item['valor_unitario'], 2, ',', '.');
        } else {
            $valor_unitario = "Não informado";
        }

        echo '<p><strong>Valor unitário: </strong>' . $valor_unitario . '</p>';

        if (htmlspecialchars($item['aceita_visualizacao']) === '1') {
            $aceita_visualizacao = "Sim";
          } else {
            $aceita_visualizacao = "Não";
          }

        echo '<p><strong>Disponível para visualização: </strong>' . $aceita_visualizacao . '</p>';

        echo '<details class="detalhes-produto">
                <summary>Mais detalhes</summary>';


        if ($item['valor_custo']) {
            $valor_custo = "R$ " . number_format($item['valor_custo'], 2, ',', '.');
        } else {
            $valor_custo = "Não informado";
        }


        if (htmlspecialchars($item['aceita_encomenda']) === '1') {
            $aceita_encomenda = "Aceita";
        } else {
            $aceita_encomenda = "Não aceita";
        }

        echo '<p class="p-descricao"><strong>Comentário:</strong>';
        if ($item['comentario']) {
            echo htmlspecialchars($item['comentario']);
        } else {
            echo "--";
        }
        echo '</p>';
        echo '<p><strong>Aceita encomenda: </strong>' . $aceita_encomenda . '</p>';
        echo '<p class="p-descricao"><strong>Informações: </strong>' . htmlspecialchars($item['descricao']) . '</p>';
        echo '</details> </div>';

        echo '<div class="product-img-btn">';

        if ($item['imagem']) {
            echo "<img src='../../persistence/uploads/" . htmlspecialchars($item['imagem']) . "' alt='imagem do produto' class='img-produtos'>";
        } else {
            echo "<p class='img-produtos sem-imagem'>Nenhuma imagem cadastrada</p>";
        }
?>
        <form action="../../controller/pedidoControle.php" method="get" class="product-btns">
            <!-- <span class="bi bi-bag-plus"></span> -->
            <input type="number" step="1" min="0" onkeydown="return ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.key) || !isNaN(Number(event.key))" name="quantidadeVendida" id="quantidadeVendida" class="input-pedido" maxlength="3" placeholder="Quantidade" autocomplete="off">
            <input type="hidden" name="op" value="adicionarQuantidade">
            <input type="hidden" name="id" value="<?php echo $item['id_produto']; ?>">
            <input type="submit" class="btn-add" value="+ Adicionar">
        </form>
        </div>
        </div>
        </div>

<?php
    }
} else {
    echo "Nenhum produto encontrado";
}
