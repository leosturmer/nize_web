<?php 
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../util/seguranca.class.php';
Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

$produtoDAO = new ProdutoDAO();

$lista = $produtoDAO->listarTodosProdutos($usuario->id_usuario);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../../img/nize_favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/query.css">
    <link rel="stylesheet" href="../../css/style.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=dehaze" />


    <title>Produtos</title>
</head>
<body>
    
    <details class="coll-sidenav" open>
        <summary><span class="material-symbols-outlined">dehaze</span></summary>
        <div class="sidenav">
            <img src="../../img/logo/nize_border.png" alt="Nize" id="logo-sidenav">
            <a href="tela_inicial.php">Tela inicial</a>
            <a href="gui_visualizacao_produtos.php">Produtos</a>
            <a href="gui_visualizacao_pedidos.php">Pedidos</a>
            <a href="gui_minha_area.php">Minha área</a>
            <a href="../controller/logout.php" id="btn-sair">Encerrar sessão</a>
        </div>
    </details>
    
    <div class="conteudo-pagina">

    <main>
        <div class="internal-nav">
            <h1>Lista de Produtos</h1>

            <div class="internal-nav-links">

                <form onsubmit="return false;">
                    <input type="text" id="pesquisa-produtos" placeholder="Busque pelo nome ou descrição" autocomplete="off">
                </form>

                <details>
                    <summary>Mais filtros</summary>


                    <select id="filtro-estoque">
                            <option value="">Todos o estoque</option>
                            <option value="com-estoque">Com estoque</option>
                            <option value="sem-estoque">Sem estoque</option>
                    </select>

                    <select id="filtro-encomenda">
                            <option value="">Todos os produtos</option>
                            <option value="com-encomenda">Aceita encomenda</option>
                            <option value="sem-encomenda">Não aceita encomenda</option>
                    </select>

                    <button type="button" id="btn-limpar-filtros">Limpar Filtros</button>

                </details>

                <a href="gui_produtos.php">Cadastrar novo produto</a>
            </div>
        </div>

        <?php
            if (isset($_SESSION["msg"])) {
                echo $_SESSION['msg'];
                unset($_SESSION["msg"]);
            }
        ?>

        <div class="lista-produtos">

            <?php if (!empty($lista)): ?>
                <?php foreach ($lista as $item):?>
                    <div class="product-view">
                        <p><strong>Nome do produto:</strong> <?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></p> 
                        <p><strong>Quantidade:</strong> <?php echo htmlspecialchars($item['quantidade']);?> </p>

                        <?php if ($item['valor_unitario']) { $valor_unitario = "R$ " . number_format($item['valor_unitario'], 2, ',', '.'); } else {$valor_unitario = "Não informado"; }?> 
                        <p><strong>Valor unitário:</strong> <?php echo $valor_unitario?></p>

                        <?php if ($item['valor_custo']) {$valor_custo = "R$ " . number_format($item['valor_custo'], 2, ',', '.'); } else {$valor_custo = "Não informado"; }?>
                        <p><strong>Valor de custo:</strong> <?php echo $valor_custo; ?></p>
                        
                        <?php if(htmlspecialchars($item['aceita_encomenda']) === '1') {
                            $aceita_encomenda = "Aceita";
                        } else {
                            $aceita_encomenda = "Não aceita";
                        }?>

                        <p><strong>Aceita encomenda:</strong> <?php echo $aceita_encomenda; ?></p>
                        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($item['descricao']) ?></p>
                        
                        <?php if($item['imagem']){
                            echo "<img src='uploads/" . htmlspecialchars($item['imagem']) . "' alt='imagem do produto' class='img-produtos'>";
                        } else {
                            echo "<p class='img-produtos'>Nenhuma imagem cadastrado</p>";
                        } ?>
                
                    <div class="product-btns">
                        <a href="gui_alteracao_produto.php?id=<?php echo $item['id_produto']; ?>">Visualizar</a>
                        <a href="../controller/produtoControle.php?op=excluir&id=<?php echo $item['id_produto'] ?>" onclick="return confirm('Deseja mesmo excluir?');">Excluir </a>
                    </div>
                </div> 
                <?php endforeach; ?>
                <?php else: echo "Nenhum produto cadastrado." ?>
                <?php endif; ?>
        </div>

        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>
    </div>


    <script src="busca_produtos.js"></script>
</body>
</html>