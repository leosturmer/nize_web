<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

// Busca o produto original para clonar os dados
$id_produto = $_GET['id'] ?? null;
$produtoData = null;

if ($id_produto) {
    $produtoDAO = new ProdutoDAO();
    $produtoData = $produtoDAO->buscarPorId($id_produto);
}

// Se não achar o produto, redireciona de volta
if (!$produtoData) {
    $_SESSION['msg'] = "<p class='error-msg'>Produto não encontrado para clonagem.</p>";
    header("location:gui_visualizacao_produtos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nize - Clonar Produto</title>
    <link rel="shortcut icon" href="../../img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/query.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=dehaze" />
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
            <div class="internal-nav">
                <div class="internal-nav-links">
                    <h1>Clonar Produto</h1>
                    <a href="gui_visualizacao_produtos.php">Todos os produtos</a>
                </div>
            </div>

            <?php
            if (isset($_SESSION["msg"])) {
                echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
                unset($_SESSION["msg"]);
            }
            ?>

            <form action="../controller/produtoControle.php?op=cadastrar" method="post" enctype="multipart/form-data" class="form-cadastro">
                <fieldset id="products-form">
                    <legend>Informações do Novo Produto (Clone)</legend>

                    <div class="inner-products-form">
                        <label><strong>Nome do produto</strong>*: </label>
                        <input type="text" id="nomeProduto" name="nomeProduto" class="input-produto" autocomplete="off" required value="<?php echo htmlspecialchars($produtoData['nome'] . ' (Cópia)'); ?>">

                        <div class="div-inner-products">
                            <label><strong>Quantidade</strong>:
                                <input type="number" id="quantidadeProduto" name="quantidadeProduto" class="input-produto" maxlength="3" autocomplete="off" value="<?php echo $produtoData['quantidade']; ?>">
                            </label>
                            <label class="checkbox-acc">
                                <strong>Aceita encomendas</strong>:
                                <input type="checkbox" id="aceitaEncomenda" name="aceitaEncomenda" class="input-produto" value='1' <?php echo $produtoData['aceita_encomenda'] == 1 ? 'checked' : ''; ?>>
                            </label>
                        </div>

                        <div class="div-inner-products">
                            <label><strong>Valor unitário</strong>*: R$
                                <input type="number" id="valorUnitario" name="valorUnitario" step="0.01" class="input-produto" autocomplete="off" required value="<?php echo $produtoData['valor_unitario']; ?>">
                            </label>
                            <label><strong>Valor de custo</strong>: R$
                                <input type="number" id="valorCusto" name="valorCusto" step="0.01" class="input-produto" autocomplete="off" value="<?php echo $produtoData['valor_custo']; ?>">
                            </label>
                        </div>

                        <label class="descricao-produtos" for="descricaoProduto">
                            <strong>Descrição do produto</strong>
                            <textarea name="descricaoProduto" id="descricaoProduto" class="input-produto" autocomplete="off"><?php echo htmlspecialchars($produtoData['descricao']); ?></textarea>
                        </label>
                        <label class="checkbox-acc" for="">
                            <strong>Disponibilizar para visualização</strong>:
                            <input type="checkbox" id="aceitaVisualizacao" name="aceitaVisualizacao" class="input-produto" value="1" <?php echo $produtoData['aceita_visualizacao'] == 1 ? 'checked' : ''; ?>>
                        </label>

                        <input type="hidden" name="imagem_clonada" value="<?php echo $produtoData['imagem']; ?>">
                        <label><strong>Imagem</strong>:
                            <input type="file" name="imagemProduto" id="imagemProduto" class="input-produto" accept=".png, .jpg">
                        </label>
                        <?php if (!empty($produtoData['imagem'])): ?>
                            <?php echo "<img src='uploads/" . htmlspecialchars($produtoData['imagem']) . "' alt='imagem do produto' class='img-produtos img-alt-produto'>" ?>
                            <span class="span-alt-img">(Será mantida se não enviar outra)</span>
                        <?php else: ?>
                            <span>Nenhuma imagem</span>
                        <?php endif; ?>
                    </div>

                </fieldset>
                <div id="form-products-buttons">
                    <button type="submit">Salvar</button>
                    <button formaction="../view/gui_visualizacao_produtos.php">Cancelar</button>
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

        const msgElement = document.getElementById('session-msg');
        if (msgElement) {
            setTimeout(() => {
                msgElement.style.display = 'none';
            }, 6000);
        }
    </script>
</body>

</html>