<?php
require_once '../../model/produto.class.php';
require_once '../../model/usuario.class.php';
require_once '../../dao/usuariodao.class.php';

header('Content-Type: text/html; charset=utf-8');

$pesquisa = trim($_GET['pesquisaUsuario'] ?? '');
$ordenar = trim($_GET['ordenarPor'] ?? '');

$usuarioDAO = new UsuarioDAO();
$lista_usuarios = $usuarioDAO->buscarUsuariosFiltro($pesquisa, $ordenar);

if (empty($lista_usuarios)) {
    echo '<h4>Nenhum cliente correspondente foi encontrado!</h4>';
    exit;
}
?>

<?php foreach ($lista_usuarios as $usuarioCadastrado): ?>
    <?php if ((int)$usuarioCadastrado['tipo_usuario'] !== 1): ?>
        <div class='usuario_cadastrado'>
            <div class="texto-users">
                <p>
                    Nome: <?php echo htmlspecialchars($usuarioCadastrado['nome'], ENT_QUOTES, 'UTF-8'); ?> <br>
                    E-mail: <?php echo htmlspecialchars($usuarioCadastrado['login'], ENT_QUOTES, 'UTF-8'); ?> <br>
                </p>
            </div>
            <div class="btns-admin-user">
                <form action="../../controller/usuarioControle.php?op=excluirUsuario&id=<?php echo $usuarioCadastrado['id_usuario']; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $usuarioCadastrado['id_usuario']; ?>">
                    <button class="btn-excluir" type="submit"><span class="bi bi-trash3"></span>Excluir</button>
                </form>
            </div>
        </div>
        <hr>
    <?php endif; ?>
<?php endforeach; ?>