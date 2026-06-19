<?php
session_start();
require_once '../model/produto.class.php';
require_once '../model/usuario.class.php';
require_once '../util/seguranca.class.php';
require_once '../dao/produtodao.class.php';

Seguranca::verificarAcesso();
header('Content-Type: text/html; charset=utf-8');

$pesquisa = trim($_GET['pesquisaProdutos'] ?? '');
$estoqueProduto = trim($_GET['filtroEstoque'] ?? '');
$encomendaProduto = trim($_GET['filtroEncomenda'] ?? '');

$produtoDAO = new ProdutoDAO();

$usuario = unserialize($_SESSION['usuario_logado']);
$idUsuarioLogado = $usuario->id_usuario;

if (!empty($pesquisa)) {
    $lista = $produtoDAO->buscarProdutoFiltro($pesquisa, $idUsuarioLogado, $encomendaProduto, $estoqueProduto);
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
            echo '<p><strong>Nome do produto: </strong>' . htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")) . '</p>'; 
            echo '<p><strong>Quantidade: </strong>' . htmlspecialchars($item['quantidade']) . '</p>';

            if ($item['valor_unitario']) { 
                $valor_unitario = "R$ " . number_format($item['valor_unitario'], 2, ',', '.'); 
                } else {
                    $valor_unitario = "Não informado"; 
            }
            
            echo '<p><strong>Valor unitário: </strong>' . $valor_unitario . '</p>';

            if ($item['valor_custo']) {
                $valor_custo = "R$ " . number_format($item['valor_custo'], 2, ',', '.'); 
                } else {
                    $valor_custo = "Não informado"; 
            }
            
            echo '<p><strong>Valor de custo: </strong>' . $valor_custo . '</p>';
            
            if(htmlspecialchars($item['aceita_encomenda']) === '1') {
                $aceita_encomenda = "Aceita";
            } else {
                $aceita_encomenda = "Não aceita";
            }

            echo '<p><strong>Aceita encomenda: </strong>' . $aceita_encomenda . '</p>';
            echo '<p><strong>Descrição: </strong>' . htmlspecialchars($item['descricao']) . '</p>';
            
            if($item['imagem']){
                echo "<img src='uploads/" . htmlspecialchars($item['imagem']) . "' alt='imagem do produto' class='img-produtos'>";
            } else {
                echo "<p class='img-produtos'>Nenhuma imagem cadastrado</p>";
            }
        ?>
            <form action="../controller/pedidoControle.php" method="get" class="product-btns">
                <input type="number" name="quantidadeVendida" id="quantidadeVendida" maxlength="3" placeholder="Digite a quantidade" autocomplete="off">
                <input type="hidden" name="op" value="adicionarQuantidade">
                <input type="hidden" name="id" value="<?php echo $item['id_produto']; ?>">
                <input type="submit" value="Adicionar ao pedido">
            </form>
<?php
        }
} else {
    echo "Nenhum produto encontrado";
}