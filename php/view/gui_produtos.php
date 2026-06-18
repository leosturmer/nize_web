<?php 
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../util/seguranca.class.php';
Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nize</title>

    <link rel="shortcut icon" href="../../img/nize_favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/query.css">
    <link rel="stylesheet" href="../../css/style.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=dehaze" />


</head>
<body>
    <details class="coll-sidenav" open>
        <summary><span class="material-symbols-outlined">dehaze</span></summary>
        <div class="sidenav">
            <img src="../../img/logo/nize-new.png" alt="Nize" id="logo-sidenav">
            <a href="tela-inicial.php">Tela inicial</a>
            <a href="gui_visualizacao_produtos.php">Produtos</a>
            <a href="gui_visualizacao_pedidos.php">Pedidos</a>
            <a href="gui_minha_area.php">Minha área</a>
            <a href="../controller/logout.php" id="btn-sair">Encerrar sessão</a>
        </div>
    </details>
    
    <div class="conteudo-pagina">
    
    <main>

    <!-- Conteúdo da página -->
        <div class="internal-nav">
            <h1>Produtos</h1>
            <div class="internal-nav-links">
                <!-- <a href="gui_produtos.php">Gerenciar produtos</a> -->
                <a href="gui_visualizacao_produtos.php">Todos os produtos</a>
            </div>
        </div>

        <?php
            if (isset($_SESSION["msg"])) {
                echo $_SESSION['msg'];
            unset($_SESSION["msg"]);
            }
        ?>

        <form action="#" method="post" enctype="multipart/form-data">
            <fieldset id="products-form">
                <legend>Informações do produto</legend>
                <label>Nome do produto*:
                    <input type="text" id="nomeProduto" name="nomeProduto" autocomplete="off">
                </label>

                <label class="checkbox-acc-encomenda" for="">
                    Aceita encomendas*:
                    <input type="checkbox" id="aceitaEncomenda" name="aceitaEncomenda" value='1'>
                </label>

                <label>Quantidade:
                    <input type="number" inputmode="" id="quantidadeProduto" name="quantidadeProduto" maxlength="3" autocomplete="off">
                </label>

                <label>Valor unitário*:
                    <input type="number" id="valorUnitario" name="valorUnitario" step="0.01" autocomplete="off" required>
                </label>

                <label>Valor de custo:
                    <input type="number" id="valorCusto" name="valorCusto" step="0.01" autocomplete="off">
                </label>

                <label>Imagem: (max. 2mb)
                    <input type="file" name="imagemProduto" id="imagemProduto" accept=".png, .jpg">
                </label>

                <label class="descricao-produtos" for="descricaoProduto"> 
                    Descrição do produto
                    <textarea name="descricaoProduto" id="descricaoProduto" placeholder="Adicione detalhes sobre o produto (material, cores, tamanho, etc)" autocomplete="off"></textarea>
                </label>
                
            </fieldset>
            <div id="form-products-buttons">
                <button type="submit" formaction="../controller/produtoControle.php?op=cadastrar">Cadastrar</button>
                <button type="reset">Limpar</button>
            </div>
        </form>

        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>
    </div>
<script>
document.getElementById('imagemProduto').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        
        const tamanhoArquivo = this.files[0].size; 
        
        const limiteMaximo = 2 * 1024 * 1024; 

        if (tamanhoArquivo > limiteMaximo) {
            alert('A imagem escolhida é muito grande! O tamanho máximo permitido é de 2 MB.');
            
            this.value = ''; 
        }
    }
});
</script>
</body>
</html>