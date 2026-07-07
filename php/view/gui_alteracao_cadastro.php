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

    <link rel="shortcut icon" href="../../img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/query.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/sidebar.css">


        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <title>Nize - Alteração de cadastro</title>
</head>

<body>
        <aside>
      <nav>
        <ul>
          <li>
            <a href="#" data-resize-btn class="btn-menu">
              <i class="bi bi-list"></i>              
              <span>Esconder menu</span>
            </a>
          </li>

          <li>
            <a href="tela_inicial.php" class="link-logo">
              <img src="../../img/logo/nize_new.png" alt="Nize logotipo" id="logo-sidenav">
            </a>
          </li>

          <li>
            <li>
              <a href="tela_inicial.php"  >
                <i class="bi bi-house"></i>

                <span>Tela inicial</span>

              </a>
            </li>
            <a href="gui_visualizacao_produtos.php">
              <i class="bi bi-box-seam"></i>
              <span>Produtos</span>
            </a>
          </li>
            </li>
            <a href="gui_visualizacao_pedidos.php">
              <i class="bi bi-clipboard2-check"></i>
              <span>Pedidos</span>
            </a>
          </li>
            </li>
            <a href="gui_minha_area.php">
              <i class="bi bi-person-lines-fill"></i> 
              <span>Minha área</span>
            </a>
          </li>
          <li>
            <a href="../controller/logout.php">
              <i class="bi bi-box-arrow-right"></i>
              <span>Encerrar sessão</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>
    <!-- <div class="conteudo-pagina"> -->


    <main class='conteudo-pagina'>

            <?php
            if (isset($_SESSION["msg"])) {
                echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
                unset($_SESSION["msg"]);
            }
            ?>

            <h1>Alteração de cadastro</h1>

            <div class="container-horizontal">
                <div id="minha-area">
                    <h3>Seus dados atuais:</h3>
                    <?php
                    if ($usuario->nome_loja) {
                        $nome_loja = $usuario->nome_loja;
                    } else {
                        $nome_loja = "Não informado";
                    }
                    if ($usuario->aceita_visualizacao == 1) {
                        $view_loja = "Aberta";
                        $checkViewLoja = "checked";
                    } else {
                        $view_loja = "Fechada";
                        $checkViewLoja = "";
                    }
                    if ($usuario->nome_visualizacao) {
                        $nome_visualizacao = $usuario->nome_visualizacao;
                    } else {
                        $nome_visualizacao = "Não informado";
                    }
                    ?>
                    <hr>
                    <p>
                        <strong>Nome</strong>: <?php echo $usuario->nome ?>
                        <br>
                        <strong>Nome loja</strong>: <?php echo $nome_loja ?>
                        <br>
                        <strong>E-mail</strong>: <?php echo $usuario->login ?>
                        <br>
                        <strong>Visualização da loja</strong>: <?php echo $view_loja ?>
                        <br>
                        <strong>Link de visualização</strong>: <?php echo $nome_visualizacao ?>
                    </p>
                </div>

                <div id="novos-dados">
                    <h3>Alterar dados</h3>
                    <form action="../controller/usuarioControle.php?op=alterar" method="post" id="form-cadastro">
                        <label for="usuNome">Nome completo*</label>
                        <input type="text" placeholder="digite seu nome" class="input-login" name="usuNome" value="<?php echo $usuario->nome ?>" autocomplete="off" required>
                        <label for="usuLoja">Nome da loja (opcional)</label>
                        <input type="text" placeholder="nome  da loja" class="input-login" name="usuLoja" value="<?php echo $usuario->nome_loja ?>" autocomplete="off">
                        <label for="usuEmail">E-mail*</label>
                        <input type="email" placeholder="e-mail" class="input-login" name="usuEmail" value=<?php echo $usuario->login ?> autocomplete="off" required>

                        <label for="aceitaVisualizacao" class="checkbox-acc">Abrir visualização da loja?
                            <input type="checkbox" name="aceitaVisualizacao" class="input-produto input-checkbox" value='1' <?php echo $checkViewLoja ?>>
                        </label>

                        <label for="usuNomeView">Link de visualização (sem espaços)</label>
                        <div class="checkbox-acc">
                            <span>nize.com.br/view_loja/</span>
                            <input type="text" name="usuNomeView" pattern="^\S+$" class="input-login input-nome-view" placeholder="nomedaloja" value="<?php echo $usuario->nome_visualizacao ?>">
                        </div>

                        <div class="checkbox-acc" style="margin-top: 1em;">
                            <div>
                                <label for="usuTelefone">Número de WhatsApp: </label>
                                <p style="font-size: 12px;">Apenas números</p>
                            </div>
                            <input type="text" name="usuTelefone" class="input-login input-nome-view" placeholder="55 55 99999999" value="<?php echo $usuario->telefone ?>">
                        </div>


                        <div class="container-horizontal">
                            <button type="submit">Alterar cadastro</button>
                            <a href="./view_loja.php?loja=<?php echo $usuario->nome_visualizacao ?>" class="btn-alterar">Visualizar loja</a>
                        </div>
                    </form>
                </div>
            </div>

            <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
        </main>

    </div>

    <script>
        const msgElement = document.getElementById('session-msg');

        if (msgElement) {
            setTimeout(() => {
                msgElement.style.display = 'none';
            }, 6000);
        }
    </script>
    <script>
      const resizeBtn = document.querySelector("[data-resize-btn]");

      resizeBtn.addEventListener("click", function (e) {
        e.preventDefault();
        document.body.classList.toggle("sb-expanded");
      });
    </script>
</body>

</html>