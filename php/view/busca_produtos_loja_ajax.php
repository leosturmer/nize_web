<?php
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';

header('Content-Type: text/html; charset=utf-8');

$pesquisa = trim($_GET['pesquisaProdutos'] ?? '');
$idLoja = trim($_GET['id_loja'] ?? '');

if (empty($idLoja)) {
    echo '<h4>Loja inválida!</h4>';
    exit;
}

$produtoDAO = new ProdutoDAO();

$lista = $produtoDAO->buscarProdutoFiltro($pesquisa, '', '', $idLoja, true);

if (empty($lista)) {
    echo '<h4>Nenhum produto correspondente foi encontrado!</h4>';
    exit;
}

foreach ($lista as $item) {
    echo '<div class="product-view">';
    ?>

    <p><strong>Nome do produto:</strong> <?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></p> 

    <p><strong>Quantidade:</strong> <?php if ($item['quantidade'] === 0 || $item['quantidade'] == null) {echo "Sem estoque";} else { echo htmlspecialchars($item['quantidade']); }?> </p>

    <?php if ($item['valor_unitario']) { $valor_unitario = "R$ " . number_format($item['valor_unitario'], 2, ',', '.'); } else {$valor_unitario = "Não informado"; }?> 
    <p><strong>Valor unitário:</strong> <?php echo $valor_unitario?></p>

    <p class="p-descricao"><strong>Descrição:</strong> 
        <?php if ($item['descricao']) { 
            echo htmlspecialchars($item['descricao']); 
            } else { 
                echo "Nenhuma descrição informada";
            } ?></p>
        
        <?php if($item['imagem']){
            echo "<img src='uploads/" . htmlspecialchars($item['imagem']) . "' alt='imagem do produto' class='img-produtos'>";
        } else {
            echo "<p>Nenhuma imagem cadastrada</p>";
        } ?>
    </div>
</div> 

<?php
} 
         ?>

    