<?php
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../dao/usuariodao.class.php';

header('Content-Type: text/html; charset=utf-8');

$pesquisa = trim($_GET['pesquisaProdutos'] ?? '');
$ordenar = trim($_GET['ordenarPor'] ?? '');
$nome_loja = trim($_GET['nome_loja'] ?? '');

$usuarioDao = new UsuarioDAO();

$idLoja = (int)$usuarioDao->buscarId($nome_loja); 

if (empty($idLoja)) {
    echo '<h4>Loja inválida!</h4>';
    exit;
}

$produtoDAO = new ProdutoDAO();

$lista = $produtoDAO->buscarProdutoFiltro($pesquisa, '', '', $ordenar, $idLoja, true);

if (empty($lista)) {
    echo '<h4>Nenhum produto correspondente foi encontrado!</h4>';
    exit;
}

foreach ($lista as $item) {
?>
    <div class="product-view">

        <div class="texto-produto">
            <p><strong>Nome do produto:</strong> <?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></p>
            <?php if ($item['valor_unitario']) {
                $valor_unitario = "R$ " . number_format($item['valor_unitario'], 2, ',', '.');
            } else {
                $valor_unitario = "Não informado";
            } ?>
            <p><strong>Valor unitário:</strong> <?php echo $valor_unitario ?></p>
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
        </div>
    </div>
    </div>

<?php
}
?>