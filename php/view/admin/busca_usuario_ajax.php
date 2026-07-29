<?php
require_once '../../model/produto.class.php';
require_once '../../model/usuario.class.php';
require_once '../../dao/usuariodao.class.php';

header('Content-Type: text/html; charset=utf-8');

$pesquisa = trim($_GET['pesquisaCliente'] ?? '');
$ordenar = trim($_GET['ordenarPor'] ?? '');
// $nome_loja = trim($_GET['nome_loja'] ?? '');
// $nome_visualizacao = trim($_GET['loja']);

$usuarioDao = new UsuarioDAO();

// Fazer a busca de usuarios

$lista_usuarios = $usuarioDAO->buscarUsuariosFiltro($pesquisa, $ordenar);

// $lista = $produtoDAO->buscarProdutoFiltro($pesquisa, '', '', $ordenar, $idLoja, true);

if (empty($lista_usuarios)) {
    echo '<h4>Nenhum cliente correspondente foi encontrado!</h4>';
    exit;
}
?>

<div id="lista_usuarios_cadastrados">
    <?php
    foreach ($lista_usuarios as $usuarioCadastrado):
        if ((int)$usuarioCadastrado['tipo_usuario'] !== 1):
    ?>
            <div class='usuario_cadastrado'>
                <div class="texto-users">
                    <p>
                        Nome: <?php echo $usuarioCadastrado['nome'] ?> <br>
                        E-mail: <?php echo $usuarioCadastrado['login'] ?> <br>
                    </p>
                </div>
                <div class="btns-admin-user">
                    <form action="../../controller/usuarioControle.php?op=excluirUsuario&id=<?php echo $usuarioCadastrado['id_usuario'] ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo $usuarioCadastrado['id_usuario']; ?>">
                        <button class="btn-excluir" type="submit"><span class="bi bi-trash3"></span>Excluir</button>
                    </form>
                </div>
            </div>
            <hr>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

</div>