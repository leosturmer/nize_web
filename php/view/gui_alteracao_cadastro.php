<?php
session_start();
require_once '../model/usuario.class.php';

require_once '../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

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


    <title>Nize - Alteração de cadastro</title>
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

        <?php
        if (isset($_SESSION["msg"])) {
        echo $_SESSION['msg'];
        unset($_SESSION["msg"]);
        }
        ?>

            <h1>Minha área</h1>
        <div id="minha-area">
            <h3>Seus dados atuais:</h3>
            <p>
            Nome: <?php echo $usuario->nome ?>
            <?php if ($usuario->nome_loja) {
                echo "Nome da loja: $usuario->nome_loja";
            } else {echo "Nome da loja: não informado"; }?>
            E-mail: <?php echo $usuario->login ?>
            </p>
        </div>

        <div id="novos-dados">
            <form action="../controller/usuarioControle.php?op=alterar" method="post" id="form-cadastro">

                <label for="usuNome">Nome completo*</label>
                <input type="text" placeholder="digite seu nome" class="input-login" name="usuNome" required value="<?php echo $usuario->nome ?>" autocomplete="off"> 

                <label for="usuLoja">Nome da loja (opcional)</label>
                <input type="text" placeholder="nome  da loja" class="input-login" name="usuLoja" value="<?php echo $usuario->nome_loja ?>" autocomplete="off">

                <label for="usuEmail">E-mail*</label>
                <input type="email" placeholder="e-mail" class="input-login" name="usuEmail" required value=<?php echo $usuario->login ?> autocomplete="off">
                

                <button type="submit">Alterar cadastro</button>
                <button formaction="../controller/usuarioControle.php?op=excluir" onclick="return confirm('A exclusão deletará todos os dados. Deseja confirmar?')">Excluir conta</button>
        </form>
        </div>       

        <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
    </main>

    </div>
</body>
</html>