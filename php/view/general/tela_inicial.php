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

  <title>Início - Nize</title>
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
          <a href="tela_inicial.php" class="link-logo" title="Tela inicial">
            <img src="../../../assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-sidenav">
          </a>
        </li>

        <li>
          <a href="tela_inicial.php" class="active" title="Tela inicial">
            <i class="bi bi-house"></i>
            <span>Tela inicial</span>
          </a>
        </li>

        <li>
          <a href="../produtos/visualizacao_produtos.php" title="Tela de produtos">
            <i class="bi bi-box-seam"></i>
            <span>Produtos</span>
          </a>
        </li>

        <li>
          <a href="../pedidos/visualizacao_pedidos.php" title="Tela de pedidos">
            <i class="bi bi-clipboard2-check"></i>
            <span>Pedidos</span>
          </a>
        </li>

        <li>
          <a href="../usuario/minha_area.php" title="Minha área">
            <i class="bi bi-person-lines-fill"></i>
            <span>Minha área</span>
          </a>
        </li>

        <li class="item-logout">
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
      <a href="tela_inicial.php" class="link-logo-header" title="Tela inicial">
        <img src="../../../assets/img/logo/nize_new.png" alt="Nize logotipo" id="logo-header">
      </a>
    </div>
  </header>

  <main class='conteudo-pagina'>
        <a id="top"></a>

    <?php
    if (isset($_SESSION["msg"])) {
      echo "<div id='session-msg'>" . $_SESSION['msg'] . "</div>";
      unset($_SESSION["msg"]);
    }
    ?>

    <h1 id="tituloInicial">
      Organize suas vendas
    </h1>

    <div class="container-inicial">
      <p>
        <?php
          echo "Olá, <strong>" . $usuario->nome_loja. "</strong>.";
        ?>
      </p>
      <p>Bora gerenciar seus produtos e pedidos?</p>
      <p>Siga o passo a passo abaixo para aprender a utilizar o sistema!</p>

      <h3 class="h3-inicial">Como utilizar o sistema</h3>

      <details class="faq-inicial">
        <summary>Navegando pelo sistema</summary>
        <p>
          Utilize o menu lateral (ou o menu do cabeçalho em telas menores) para navegar entre as opções:
        </p>
        <ul class="lista-passos-1">
          <li><strong>Tela inicial</strong>: Retorna a esta página de orientações.</li>
          <li><strong>Produtos</strong>: Acessa a listagem e gestão do seu catálogo.</li>
          <li><strong>Pedidos</strong>: Acessa a listagem e controle de vendas.</li>
          <li><strong>Minha área</strong>: Gerencia seus dados e configurações da loja.</li>
          <li><strong>Encerrar sessão</strong>: Desconecta sua conta com segurança.</li>
        </ul>
      </details>

      <details class="faq-inicial">
        <summary>Gestão de Produtos</summary>
        <p>Aprenda a cadastrar, pesquisar, editar, duplicar e excluir seus produtos:</p>
        <ul class="lista-passos-1">
          <li><strong>Cadastrar</strong>: Na tela <span>Produtos</span>, clique em <span>+ Produto</span> no canto superior direito. Preencha os campos (marcados com * são obrigatórios) e clique em <span>Salvar</span>.</li>
          <li><strong>Pesquisar e Filtrar</strong>: Utilize a barra de busca por nome/descrição ou os filtros por estoque, opção de encomenda e ordenação.</li>
          <li><strong>Editar</strong>: Na lista de produtos, clique em <span>Editar</span> junto ao produto desejado, altere as informações e clique em <span>Alterar</span>.</li>
          <li><strong>Duplicar</strong>: Clique em <span>Duplicar</span> para abrir o formulário já preenchido com os dados do item original e salve uma nova cópia.</li>
          <li><strong>Excluir</strong>: Acesse a edição do produto, clique em <span>Excluir</span> e confirme a remoção.</li>
        </ul>
      </details>

      <details class="faq-inicial">
        <summary>Gestão de Pedidos</summary>
        <p>Para criar pedidos, você precisa ter produtos previamente cadastrados:</p>
        <ul class="lista-passos-1">
          <li><strong>Cadastrar Pedido</strong>: Na tela <span>Pedidos</span>, clique em <span>+ Pedido</span>. Selecione os produtos, informe a quantidade e clique em <span>Adicionar</span>. Preencha o prazo de entrega, status e salve.</li>
          <li><strong>Pesquisar e Filtrar</strong>: Busque pelo número do pedido, comentário ou filtre por data e status.</li>
          <li><strong>Duplicar e Excluir</strong>: Use <span>Duplicar</span> para reintroduzir pedidos parecidos ou <span>Editar</span> para encontrar o botão de <span>Excluir</span>.</li>
        </ul>
      </details>

      <details class="faq-inicial">
        <summary>Regras de Status de Pedidos e Estoque</summary>
        <p>O comportamento do pedido muda conforme seu status:</p>
        <ul class="lista-passos-1">
          <li><strong>Encomendado / Aguardando pagamento</strong>: Permitem alteração total dos dados e produtos do pedido.</li>
          <li><strong>Vendido</strong>: Permite dar baixa no estoque (caso haja quantidade suficiente). Não é possível adicionar ou remover produtos após a venda. O único status seguinte permitido é <span>Cancelado</span>.</li>
          <li><strong>Cancelado</strong>: Permite optar por devolver os itens ao estoque. Pedidos cancelados não podem ser alterados, apenas duplicados ou excluídos.</li>
        </ul>
      </details>

      <details class="faq-inicial">
        <summary>Abrindo uma loja virtual</summary>
        <p>
          A loja virtual gera um link público para seus clientes visualizarem seu catálogo e enviarem pedidos diretamente para o seu WhatsApp.
        </p>
        <p>Passos necessários para ativar:</p>
        <ul class="lista-passos-1">
          <li><strong>Nos Produtos</strong>: Marque a opção <span>Disponibilizar para visualização</span> nos produtos que deseja exibir na loja.</li>
          <li><strong>Na tela Minha Área</strong>:
            <ul class="lista-passos-2">
              <li>Marque a opção <b>Abrir visualização da loja?</b>.</li>
              <li>Insira o seu <b>Link de visualização</b>.</li>
              <li>Adicione o seu <b>Número de WhatsApp</b>.</li>
            </ul>
          </li>
        </ul>
      </details>

      <details class="faq-inicial">
        <summary>Minha Área e Exclusão de Conta</summary>
        <p>Em <span>Minha área</span> você pode gerenciar suas informações e conta:</p>
        <ul class="lista-passos-1">
          <li><strong>Alterar Dados</strong>: Clique em <span>Editar</span>, atualize seus dados cadastrais e clique em <span>Alterar</span>.</li>
          <li><strong>Excluir Conta</strong>: Na tela de edição de cadastro, clique em <span>Excluir</span>. Esta ação é permanente e apaga todos os seus dados do sistema.</li>
        </ul>
      </details>

      <a href="./guia_utilizacao.php" id="link-guia-sistema">Clique aqui para acessar o Guia de Utilização do Sistema</a>

      <h2 class="boas-vendas">Boas vendas!</h2>
    </div>
    <footer><a href="https://github.com/leosturmer" target="_blank">Leonardo Stürmer &copy; Todos os direitos reservados.</a></footer>
  <div id="scrollTop"><a href="#top"><span class="bi bi-chevron-up"></span></a></div>
    </main>

  <script type="module" src="../../../js/main.js"></script>

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