<?php 
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../dao/usuariodao.class.php';
// require_once '../util/seguranca.class.php';
// Seguranca::verificarAcesso();


$id_usuario = $_GET['id']; // AQUI VAI TER QUE VIR PELO GET

$produtoDAO = new ProdutoDAO();
$usuarioDAO = new UsuarioDAO();

$nome_loja = $usuarioDAO->buscarNomeLoja($id_usuario);
$lista = $produtoDAO->listarTodosProdutosAbertos($id_usuario);

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

    <title>Visualização loja </title>
</head>
<body>
    
    <header><img src="../../img/logo/nize_new.png" alt="Nize" id="logo-sidenav"></header>
    
    <div class="conteudo-pagina">
        
        <main>
        
        <div class="internal-nav">

            <div class="internal-nav-inputs">
                <form onsubmit="return false;" id="form-pesquisa-produtos">
                    <input type="text" id="pesquisa-produtos" placeholder="Busque pelo nome ou descrição " autocomplete="off"><span class="material-symbols-outlined" id="search-icon">search</span>
                </form>

                <button type="button" id="btn-limpar-filtros">Resetar filtros</button>
            </div>

        </div>

        <div class="lista-produtos">

            <?php if (!empty($lista)): ?>
                <?php foreach ($lista as $item):?>
                    <div class="product-view">
                        <p><strong>Nome do produto:</strong> <?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></p> 

                        <?php if ($item['valor_unitario']) { $valor_unitario = "R$ " . number_format($item['valor_unitario'], 2, ',', '.'); } else {$valor_unitario = "Não informado"; }?> 
                        <p><strong>Valor unitário:</strong> <?php echo $valor_unitario?></p>

                        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($item['descricao']) ?></p>
                        
                        <?php if($item['imagem']){
                            echo "<img src='uploads/" . htmlspecialchars($item['imagem']) . "' alt='imagem do produto' class='img-produtos'>";
                        } else {
                            echo "<p>Nenhuma imagem cadastrada</p>";
                        } ?>
                
                </div> 
                <?php endforeach; ?>
                <?php else: echo "Nenhum produto cadastrado." ?>
                <?php endif; ?>
        </div>

        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>
    </div>

    <script src="busca_produtos.js"></script>
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