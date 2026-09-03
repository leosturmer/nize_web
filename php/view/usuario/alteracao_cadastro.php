<?php
session_start();
require_once '../../model/usuario.class.php';

require_once '../../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="../../../assets/img/favicon/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="../../../assets/css/variables.css">
  <link rel="stylesheet" href="../../../assets/css/sidebar.css">
  <link rel="stylesheet" href="../../../assets/css/components.css">
  <link rel="stylesheet" href="../../../assets/css/responsive.css">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


  <title>Alteração de cadastro- Nize</title>
</head>



<body>
  <aside id="sidebar">
    <nav>
      <ul>
        <li>
          <a href="#" data-resize-btn class="btn-menu" title="Esconder/expandir menu">
            <i class="bi bi-list"></i>

          </a>
        </li>

        <li>
          <a href="../general/tela_inicial.php" class="link-logo" title="Tela inicial">
            <img src="../../../assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-sidenav">
          </a>
        </li>

        <li>
        <li>
          <a href="../general/tela_inicial.php" title="Tela inicial">
            <i class="bi bi-house"></i>

            <span>Tela inicial</span>

          </a>
        </li>
        <a href="../produtos/visualizacao_produtos.php" title="Tela de produtos">
          <i class="bi bi-box-seam"></i>
          <span>Produtos</span>
        </a>
        </li>
        </li>
        <a href="../pedidos/visualizacao_pedidos.php" title="Tela de pedidos">
          <i class="bi bi-clipboard2-check"></i>
          <span>Pedidos</span>
        </a>
        </li>
        </li>
        <a href="minha_area.php" class="active" title="Minha área">
          <i class="bi bi-person-lines-fill"></i>
          <span>Minha área</span>
        </a>
        </li>
        <li>
          <a href="../../controller/logout.php" class="btn-sair" title="Sair">
            <i class="bi bi-box-arrow-left"></i>
            <span>Encerrar sessão</span>
          </a>
        </li>
      </ul>
    </nav>
  </aside>

  <header id="header-mobile">
    <div class="container-header">
      <a href="#" data-resize-btn-mobile class="btn-menu" title="Esconder/expandir menu">
        <i class="bi bi-list"></i>
      </a>
      <a href="../general/tela_inicial.php" class="link-logo-header" title="Tela inicial">
        <img src="../../../assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-header">
      </a>
    </div>
  </header>

  <main class='conteudo-pagina'>
    <a id="top"></a>

    <?php
    if (isset($_SESSION["msg"])) {
      echo "<div id='session-msg'>" . $_SESSION['msg'] .  "</div>";
      unset($_SESSION["msg"]);
    }
    ?>

    <div class="internal-nav">
      <div class="internal-nav-links">
        <h1>Alteração de cadastro</h1>
        <a href="minha_area.php" title="Tela Minha Área"><span class="bi bi-arrow-left"></span>Voltar</a>
      </div>
    </div>

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
        if ($usuario->telefone) {
          $telefone = $usuario->telefone;
        } else {
          $telefone = "Não informado";
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
          <br>
          <strong>WhatsApp</strong> (opcional): <?php echo $telefone ?>
        </p>
      </div>

      <div id="novos-dados">
        <h3>Alterar dados</h3>
        <form action="../../controller/usuarioControle.php?op=alterar" method="post" id="form-cadastro">
          <label for="usuNome">Nome completo*</label>
          <input type="text" placeholder="digite seu nome" class="input-login" name="usuNome" value="<?php echo $usuario->nome ?>" autocomplete="off" maxlength="50" required>
          <label for="usuLoja">Nome da loja (opcional)</label>
          <input type="text" placeholder="nome  da loja" class="input-login" name="usuLoja" value="<?php echo $usuario->nome_loja ?>" autocomplete="off" maxlength="50">
          <label for="usuEmail">E-mail*</label>
          <input type="email" placeholder="e-mail" class="input-login" name="usuEmail" value=<?php echo $usuario->login ?> autocomplete="off" maxlength="50" required>

          <div class="pedidos-online">
            <hr>
            <p class="p-info-pedidos-online">Para permitir pedidos online, os três campos abaixo são obrigatórios</p>
            <label for="aceitaVisualizacao" class="checkbox-acc">Abrir visualização da loja?
              <input type="checkbox" name="aceitaVisualizacao" class="input-produto input-checkbox" value='1' autocomplete="off" <?php echo $checkViewLoja ?>>
            </label>
            <label for="usuNomeView"><b>Link de visualização</b></label>
            <div class="checkbox-acc">
              <span>nize.com.br/loja/</span>
              <input type="text" name="usuNomeView" pattern="^\S+$" class="input-login input-nome-view" placeholder="nomedaloja" value="<?php echo $usuario->nome_visualizacao ?>" autocomplete="off" title="Link para a loja não deve conter espaços" maxlength="20">
            </div>
            <div class="checkbox-acc" style="margin-top: 1em;">
              <div>
                <label for="usuTelefone">Número de WhatsApp: </label>
              </div>
              <input type="text" name="usuTelefone" class="input-login input-nome-view" placeholder="55 99999999" value="<?php echo $usuario->telefone ?>" autocomplete="off" title="Telefone com DDD e número" maxlength="16">
            </div>
          </div>

          <div class="container-horizontal cadastro-btns">
            <button type="submit" class="btn-salvar"><span class="bi bi-check2"></span>Alterar</button>
            <button formaction="../../controller/usuarioControle.php?op=excluir" onclick="return confirm('A exclusão deletará todos os dados do banco.\n\nESSA AÇÃO NÃO PODE SER DESFEITA.\n\nDeseja confirmar?')" class="btn-excluir"><span class="bi bi-person-x"></span>Excluir</button>
          </div>
        </form>
      </div>
    </div>

    <footer><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.</a></footer>
    <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
  </main>

  </div>

  <script type="module" src="../../../js/main.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const campoNome = document.querySelector("input[name='usuNome']");
      const campoLoja = document.querySelector("input[name='usuLoja']");
      const campoEmail = document.querySelector("input[name='usuEmail']");
      const checkView = document.querySelector("input[name='aceitaVisualizacao']");
      const campoNomeView = document.querySelector("input[name='usuNomeView']");
      const campoTelefone = document.querySelector("input[name='usuTelefone']");
      const formCadastro = document.getElementById("form-cadastro");

      // Verifica se o usuário veio de outra página do site
      const veioDeOutraPagina = !document.referrer.includes("alterar_usuario.php") && !document.referrer.includes("minha_area.php");

      if (veioDeOutraPagina) {
        // Se veio de fora (abriu a edição agora), limpa rascunhos anteriores para puxar limpo do banco
        localStorage.removeItem("alt_usu_nome");
        localStorage.removeItem("alt_usu_loja");
        localStorage.removeItem("alt_usu_email");
        localStorage.removeItem("alt_usu_check");
        localStorage.removeItem("alt_usu_nomeview");
        localStorage.removeItem("alt_usu_telefone");
      } else {
        // Se apenas recarregou, restaura o que ele digitou por cima
        if (localStorage.getItem("alt_usu_nome") && campoNome) {
          campoNome.value = localStorage.getItem("alt_usu_nome");
        }
        if (localStorage.getItem("alt_usu_loja") && campoLoja) {
          campoLoja.value = localStorage.getItem("alt_usu_loja");
        }
        if (localStorage.getItem("alt_usu_email") && campoEmail) {
          campoEmail.value = localStorage.getItem("alt_usu_email");
        }
        if (localStorage.getItem("alt_usu_check") !== null && checkView) {
          checkView.checked = localStorage.getItem("alt_usu_check") === "true";
        }
        if (localStorage.getItem("alt_usu_nomeview") && campoNomeView) {
          campoNomeView.value = localStorage.getItem("alt_usu_nomeview");
        }
        if (localStorage.getItem("alt_usu_telefone") && campoTelefone) {
          campoTelefone.value = localStorage.getItem("alt_usu_telefone");
        }
      }

      // Salva os valores em tempo real conforme o usuário digita ou altera
      if (campoNome) {
        campoNome.addEventListener("input", function() {
          localStorage.setItem("alt_usu_nome", campoNome.value);
        });
      }
      if (campoLoja) {
        campoLoja.addEventListener("input", function() {
          localStorage.setItem("alt_usu_loja", campoLoja.value);
        });
      }
      if (campoEmail) {
        campoEmail.addEventListener("input", function() {
          localStorage.setItem("alt_usu_email", campoEmail.value);
        });
      }
      if (checkView) {
        checkView.addEventListener("change", function() {
          localStorage.setItem("alt_usu_check", checkView.checked);
        });
      }
      if (campoNomeView) {
        campoNomeView.addEventListener("input", function() {
          localStorage.setItem("alt_usu_nomeview", campoNomeView.value);
        });
      }
      if (campoTelefone) {
        campoTelefone.addEventListener("input", function() {
          localStorage.setItem("alt_usu_telefone", campoTelefone.value);
        });
      }

      // Limpa o armazenamento quando o formulário for enviado com sucesso
      if (formCadastro) {
        formCadastro.addEventListener("submit", function() {
          localStorage.removeItem("alt_usu_nome");
          localStorage.removeItem("alt_usu_loja");
          localStorage.removeItem("alt_usu_email");
          localStorage.removeItem("alt_usu_check");
          localStorage.removeItem("alt_usu_nomeview");
          localStorage.removeItem("alt_usu_telefone");
        });
      }
    });
  </script>

  <!-- Acessibilidade -->

  <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
  </script>

</body>

</html>