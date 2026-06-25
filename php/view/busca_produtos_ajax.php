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

$lista = $produtoDAO->buscarProdutoFiltro($pesquisa, $estoqueProduto, $encomendaProduto, $idUsuarioLogado);

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

        <?php if ($item['valor_custo']) {$valor_custo = "R$ " . number_format($item['valor_custo'], 2, ',', '.'); } else {$valor_custo = "Não informado"; }?>
        <p><strong>Valor de custo:</strong> <?php echo $valor_custo; ?></p>
        
        <?php 
        
        if(htmlspecialchars($item['aceita_encomenda']) === '1') {
            $aceita_encomenda = "Aceita";
        } else {
            $aceita_encomenda = "Não aceita";
        }
        
        if(htmlspecialchars($item['aceita_visualizacao']) === '1') {
            $aceita_visualizacao = "Sim";
        } else {
            $aceita_visualizacao = "Não";
        }
        
        
        ?>

        <p><strong>Aceita encomenda:</strong> <?php echo $aceita_encomenda; ?></p>
        <p><strong>Disponível para visualização:</strong> <?php echo $aceita_visualizacao; ?></p>
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

    <div class="product-btns">
        <a href="gui_alteracao_produto.php?id=<?php echo $item['id_produto']; ?>">Visualizar</a>
        <a href="../controller/produtoControle.php?op=excluir&id=<?php echo $item['id_produto'] ?>" onclick="return confirm('Deseja mesmo excluir?');">Excluir</a>
    </div>
</div> 
        <?php
}