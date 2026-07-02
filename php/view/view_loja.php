<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../dao/usuariodao.class.php';


$nome_visualizacao = trim($_GET['loja']);

$produtoDAO = new ProdutoDAO();
$usuarioDAO = new UsuarioDAO();

$id_usuario = (int)$usuarioDAO->buscarId($nome_visualizacao);
$dadosView = $usuarioDAO->buscarAceitaView($id_usuario);

$aceita_visualizacao = $dadosView['aceita_visualizacao'];

$dadosNomeLoja = $usuarioDAO->buscarNomeLoja($id_usuario);

$nome_loja = $dadosNomeLoja['nome_loja'];

$dadosTelefone = $usuarioDAO->buscarTelefone($id_usuario);
$telefone = $dadosTelefone['telefone'];


$lista = $produtoDAO->listarTodosProdutos($id_usuario);

if (!empty($_SESSION['usuario_logado'])) {
    $logo_link = "tela_inicial.php";
} else {
    $logo_link = "../../index.php";
}

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

    <header class="header-view-loja">
        <a href="<?php echo $logo_link ?>"><img src="../../img/logo/nize_new.png" alt="Nize" id="logo-sidenav"></a>
    </header>

    <div class="conteudo-pagina">

        <main>

            <div class="internal-nav">
                <?php if ($aceita_visualizacao === 1): ?>

                    <h1><?php echo $nome_loja; ?></h1>

                    <div class="internal-nav-inputs">
                        <form onsubmit="return false;" id="form-pesquisa-produtos">
                            <input type="text" id="pesquisa-produtos" placeholder="Busque pelo nome ou descrição " autocomplete="off"><span class="material-symbols-outlined" id="search-icon">search</span>
                        </form>

                        <select id="filtro-order">
                            <option value="nome-asc">Ordenar por</option>
                            <option value="nome-asc">Nome (crescente)</option>
                            <option value="nome-desc">Nome (descrescente)</option>
                            <option value="valor-asc">Preço (crescente)</option>
                            <option value="valor-desc">Preço (descrescente)</option>
                        </select>

                        <button type="button" id="btn-limpar-filtros">Resetar filtros</button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="lista-produtos">


                <?php if (!empty($lista) && $aceita_visualizacao === 1): ?>
                    <?php foreach ($lista as $item): ?>
                        <div class="product-view">
                            <p><strong>Nome do produto:</strong> <?php echo htmlspecialchars(mb_convert_encoding($item['nome'], "UTF-8", "AUTO")); ?></p>

                            <?php if ($item['valor_unitario']) {
                                $valor_unitario = "R$ " . number_format($item['valor_unitario'], 2, ',', '.');
                            } else {
                                $valor_unitario = "Não informado";
                            } ?>
                            <p><strong>Valor unitário:</strong> <?php echo $valor_unitario ?></p>

                            <p class="p-descricao"><strong>Descrição:</strong> <?php echo htmlspecialchars($item['descricao']) ?></p>

                            <?php if ($item['imagem']) {
                                echo "<img src='uploads/" . htmlspecialchars($item['imagem']) . "' alt='imagem do produto' class='img-produtos'>";
                            } else {
                                echo "<p>Nenhuma imagem cadastrada</p>";
                            } ?>

                        </div>
                    <?php endforeach; ?>
                <?php else: echo "Nenhum produto cadastrado." ?>
                <?php endif; ?>


            </div>
            <div class="div-btn-wpp">

                <?php if ($aceita_visualizacao === 1 && !empty($telefone)): ?>
                <a href="https://wa.me/<?php echo $telefone; ?>"><img src="../../img/icons/whatsapp64.png" alt=""></a>
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