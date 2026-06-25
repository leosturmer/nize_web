<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../util/seguranca.class.php';
Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);
$id_produto = $_GET['id'] ?? null;

if (!$id_produto) {
    header("location:gui_visualizacao_produtos.php");
    exit;
}

$produtoDAO = new ProdutoDAO();

$produto = $produtoDAO->buscarPorId($id_produto);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nize</title>

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
                    <h1>Alteração de produto</h1>
                    <a href="gui_visualizacao_produtos.php">Todos os produtos</a>
                </div>
            </div>

            <?php
            if (isset($_SESSION["msg"])) {
                echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
                unset($_SESSION["msg"]);
            }
            ?>

            <form action="../controller/produtoControle.php?op=alterar&id=<?php echo $produto['id_produto'] ?>" method="post" enctype="multipart/form-data" class="form-cadastro form-alt-produto">
                <fieldset id="products-form">
                    <legend>Informações do produto</legend>
                    <div class="inner-products-form">
                        <label><strong>Nome do produto</strong>*:</label>
                        <input type="text" id="nomeProduto" name="nomeProduto" class="input-produto alt-nome-produto" value="<?php echo htmlspecialchars($produto['nome']); ?>" autocomplete="off" required>
                        <?php

                        if ($produto['aceita_encomenda'] !== 1) {
                            $checkEncomenda = "";
                        } else {
                            $checkEncomenda = "checked";
                        }
                        if ($produto['aceita_visualizacao'] !== 1) {
                            $checkVisualizacao = "";
                        } else {
                            $checkVisualizacao = "checked";
                        }

                        ?>
                        <div class="div-inner-products">
                            <label><strong>Quantidade</strong>:
                                <input type="number" inputmode="" id="quantidadeProduto" name="quantidadeProduto" class="input-produto" value="<?php echo htmlspecialchars($produto['quantidade']); ?>" maxlength="3" autocomplete="off">
                            </label>

                            <label class="checkbox-acc" for="">
                                <strong>Aceita encomendas</strong>:
                                <input type="checkbox" id="aceitaEncomenda" name="aceitaEncomenda" class="input-produto" value="1" <?php echo " $checkEncomenda"; ?>>
                            </label>
                        </div>

                        <div class="div-inner-products">
                            <label><strong>Valor unitário</strong>*: R$ 
                                <input type="number" id="valorUnitario" name="valorUnitario" step="0.01" class="input-produto" value="<?php echo htmlspecialchars($produto['valor_unitario']); ?>" autocomplete="off" required>
                            </label>

                            <label><strong>Valor de custo</strong>: R$
                                <input type="number" id="valorCusto" name="valorCusto" step="0.01" class="input-produto" value="<?php echo htmlspecialchars($produto['valor_custo']); ?>" autocomplete="off">
                            </label>

                        </div>


                        <label class="descricao-produtos" for="descricaoProduto">
                            <strong>Descrição do produto</strong>
                            <textarea name="descricaoProduto" id="descricaoProduto" class="input-produto" placeholder="Adicione detalhes sobre o produto (material, cores, tamanho, etc)" autocomplete="off"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
                        </label>
                        <label class="checkbox-acc" for="">
                            <strong>Disponibilizar para visualizaçã</strong>o
                            <input type="checkbox" id="aceitaVisualizacao" name="aceitaVisualizacao" class="input-produto" value="1" <?php echo " $checkVisualizacao"; ?>>
                        </label>



                        <input type="hidden" name="imagem_atual" value="<?php echo $produto['imagem']; ?>">
                        <label><strong>Imagem</strong>:
                        <input type="file" name="imagemProduto" id="imagemProduto" class="input-produto" accept=".png, .jpg">
                        </label>
                        <?php if (!empty($produto['imagem'])): ?>
                            <?php echo "<img src='uploads/" . htmlspecialchars($produto['imagem']) . "' alt='imagem do produto' class='img-produtos img-alt-produto'>" ?>
                            <span class="span-alt-img">(Será mantida se não enviar outra)</span>
                        <?php else: ?>
                            <span>Nenhuma imagem</span>
                        <?php endif; ?>
                        
                    </div>

                </fieldset>

                <div id="form-products-buttons">
                    <button type="submit">Alterar</button>
                    <button formaction="gui_clonar_produto.php?id=<?php echo $produto['id_produto']; ?>">Clonar</button>
                    <button formaction="../view/gui_visualizacao_produtos.php">Voltar</button>
                </div>
            </form>

            <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
        </main>

    </div>

    <script>
        document.getElementById('imagemProduto').addEventListener('change', function() {
            // 1. Verifica se o usuário realmente selecionou um arquivo
            if (this.files && this.files[0]) {

                // 2. Pega o tamanho do arquivo em Bytes
                const tamanhoArquivo = this.files[0].size;

                // 3. Define o limite máximo: 2 Megabytes em Bytes (2 * 1024 * 1024)
                const limiteMaximo = 2 * 1024 * 1024;

                // 4. Se o tamanho for maior que o limite...
                if (tamanhoArquivo > limiteMaximo) {
                    alert('A imagem escolhida é muito grande! O tamanho máximo permitido é de 2 MB.');

                    // Limpa o campo para o usuário não conseguir enviar o arquivo gigante
                    this.value = '';
                }
            }
        });
    </script>

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