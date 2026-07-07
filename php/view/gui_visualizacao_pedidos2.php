<?php
session_start();
require_once '../model/usuario.class.php';
require_once '../model/produto.class.php';
require_once '../dao/produtodao.class.php';
require_once '../dao/pedidodao.class.php';
require_once '../util/seguranca.class.php';

Seguranca::verificarAcesso();

$usuario = unserialize($_SESSION['usuario_logado']);

$pedidoDAO = new pedidoDAO();

$listaPedidos = $pedidoDAO->listarTodosPedidos($usuario->id_usuario);

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_SESSION['pedidoSelecionado'])) {
    unset($_SESSION['pedidoSelecionado']);
    unset($_SESSION['carrinho']);
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
    <link rel="stylesheet" href="../../css/sidebar.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <title>Lista de Pedidos</title>
</head>

<body>

    <!-- Sidebar -->
<div id="hs-sidebar-content-push" class="hs-overlay [--body-scroll:true] lg:[--overlay-backdrop:false] [--is-layout-affect:true] [--opened:lg] [--auto-close:lg] hs-overlay-open:translate-x-0 lg:hs-overlay-layout-open:translate-x-0 lg:block lg:-translate-x-full lg:inset-e-auto lg:bottom-0 w-64 -translate-x-full transition-all duration-300 transform h-full hidden fixed top-0 inset-s-0 bottom-0 z-60 bg-white border-e border-gray-200" role="dialog" tabindex="-1" aria-label="Sidebar" >
  <div class="relative flex flex-col h-full max-h-full">
      <!-- Header -->
      <header class="p-4 flex justify-between items-center gap-x-2">

        <a class="flex-none font-semibold text-xl text-gray-800 focus:outline-hidden focus:opacity-80" href="#" aria-label="Brand">Brand</a>

        <div class="lg:hidden -me-2">
          <!-- Close Button -->
          <button type="button" class="flex justify-center items-center gap-x-3 size-6 bg-white border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50" data-hs-overlay="#hs-sidebar-content-push">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            <span class="sr-only">Close</span>
          </button>
          <!-- End Close Button -->
        </div>
      </header>
      <!-- End Header -->

      <!-- Body -->
      <nav class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
        <div class="hs-accordion-group pb-0 px-2 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
          <ul class="space-y-1">
            <li>
              <a class="flex items-center gap-x-3.5 py-2 px-2.5 bg-gray-100 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Dashboard
              </a>
            </li>

            <li class="hs-accordion" id="users-accordion">
              <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" aria-expanded="true" aria-controls="users-accordion-collapse-1">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Users

                <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>

                <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
              </button>

              <div id="users-accordion-collapse-1" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" role="region" aria-labelledby="users-accordion">
                <ul class="hs-accordion-group pt-1 ps-7 space-y-1" data-hs-accordion-always-open>
                  <li class="hs-accordion" id="users-accordion-sub-1">
                    <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" aria-expanded="true" aria-controls="users-accordion-sub-1-collapse-1">
                      Sub Menu 1

                      <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>

                      <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </button>

                    <div id="users-accordion-sub-1-collapse-1" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" role="region" aria-labelledby="users-accordion-sub-1">
                      <ul class="pt-1 ps-2 space-y-1">
                        <li>
                          <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                            Link 1
                          </a>
                        </li>
                        <li>
                          <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                            Link 2
                          </a>
                        </li>
                        <li>
                          <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                            Link 3
                          </a>
                        </li>
                      </ul>
                    </div>
                  </li>

                  <li class="hs-accordion" id="users-accordion-sub-2">
                    <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" aria-expanded="true" aria-controls="users-accordion-sub-2-collapse-1">
                      Sub Menu 2

                      <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>

                      <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </button>

                    <div id="users-accordion-sub-2-collapse-1" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" role="region" aria-labelledby="users-accordion-sub-2">
                      <ul class="pt-1 ps-2 space-y-1">
                        <li>
                          <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                            Link 1
                          </a>
                        </li>
                        <li>
                          <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                            Link 2
                          </a>
                        </li>
                        <li>
                          <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                            Link 3
                          </a>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </li>

            <li class="hs-accordion" id="account-accordion">
              <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" aria-expanded="true" aria-controls="account-accordion-sub-1-collapse-1">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="15" r="3"/><circle cx="9" cy="7" r="4"/><path d="M10 15H6a4 4 0 0 0-4 4v2"/><path d="m21.7 16.4-.9-.3"/><path d="m15.2 13.9-.9-.3"/><path d="m16.6 18.7.3-.9"/><path d="m19.1 12.2.3-.9"/><path d="m19.6 18.7-.4-1"/><path d="m16.8 12.3-.4-1"/><path d="m14.3 16.6 1-.4"/><path d="m20.7 13.8 1-.4"/></svg>
                Account

                <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>

                <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
              </button>

              <div id="account-accordion-sub-1-collapse-1" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" role="region" aria-labelledby="account-accordion">
                <ul class="pt-1 ps-7 space-y-1">
                  <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                      Link 1
                    </a>
                  </li>
                  <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                      Link 2
                    </a>
                  </li>
                  <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                      Link 3
                    </a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="hs-accordion" id="projects-accordion">
              <button type="button" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" aria-expanded="true" aria-controls="projects-accordion-sub-1-collapse-1">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15.5 2H8.6c-.4 0-.8.2-1.1.5-.3.3-.5.7-.5 1.1v12.8c0 .4.2.8.5 1.1.3.3.7.5 1.1.5h9.8c.4 0 .8-.2 1.1-.5.3-.3.5-.7.5-1.1V6.5L15.5 2z"/><path d="M3 7.6v12.8c0 .4.2.8.5 1.1.3.3.7.5 1.1.5h9.8"/><path d="M15 2v5h5"/></svg>
                Projects

                <svg class="hs-accordion-active:block ms-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>

                <svg class="hs-accordion-active:hidden ms-auto block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
              </button>

              <div id="projects-accordion-sub-1-collapse-1" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" role="region" aria-labelledby="projects-accordion">
                <ul class="pt-1 ps-7 space-y-1">
                  <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                      Link 1
                    </a>
                  </li>
                  <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                      Link 2
                    </a>
                  </li>
                  <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                      Link 3
                    </a>
                  </li>
                </ul>
              </div>
            </li>

            <li>
              <a class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                Calendar <span class="ms-auto py-0.5 px-1.5 inline-flex items-center gap-x-1.5 text-xs bg-gray-200 text-gray-800 rounded-full">New</span>
              </a>
            </li>
            <li>
              <a class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" href="#">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                Documentation
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <!-- End Body -->
  </div>
</div>
<!-- End Sidebar -->

<!-- Content -->
<div class="sm:hs-overlay-layout-open:ms-64 min-h-160 bg-white transition-all duration-300">
  <!-- Navigation Toggle -->
  <div class="lg:hidden p-2">
    <button type="button" class="flex justify-center items-center gap-x-3 size-8 text-sm text-gray-600 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-sidebar-content-push" aria-label="Toggle navigation" data-hs-overlay="#hs-sidebar-content-push">
      <svg class="sm:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M15 3v18"/><path d="m8 9 3 3-3 3"/></svg>
      <svg class="hidden sm:block shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M15 3v18"/><path d="m10 15-3-3 3-3"/></svg>
      <span class="sr-only">Navigation Toggle</span>
    </button>
  </div>
  <!-- End Navigation Toggle -->
</div>
<!-- End Content -->


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
              <a href="tela_inicial.php" class="active">
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

            <div class="internal-nav">
                <div class="internal-nav-links">
                    <h1>Lista de Pedidos</h1>
                    <a href="gui_cadastro_pedidos.php">Cadastrar novo pedido</a>
                </div>

                <div class="internal-nav-inputs">
                    <form onsubmit="return false;" id="form-pesquisa-pedidos">
                        <input type="text" id="pesquisa-pedidos" placeholder="Digite sua pesquisa" autocomplete="off"><span id="search-icon"  class="bi bi-search"></span >
                    </form>

                    <input type="date" id="filtro-data">
                    <select id="filtro-status">
                        <option value="">Todos os status</option>
                        <option value="encomendado">Encomendado</option>
                        <option value="pagamento">Pagamento</option>
                        <option value="vendido">Vendido</option>
                        <option value="cancelado">Cancelado</option>
                    </select>

                    <select id="filtro-order">
                        <option value="">Ordenar por</option>
                        <option value="numero-asc">Número pedido (crescente)</option>
                        <option value="numero-desc">Número pedido (descrescente)</option>
                        <option value="data-asc">Data (crescente)</option>
                        <option value="data-desc">Data (descrescente)</option>
                    </select>

                    <button type="button" id="btn-limpar-filtros">Resetar filtros</button>

                </div>
            </div>


            <div class="lista-pedidos">
                <?php if (!empty($listaPedidos)): ?>
                    <?php foreach ($listaPedidos as $id_pedido => $dados_pedido): ?>
                        <div class="product-view">

                            <h2 class="num-pedido">Número do pedido: <?php echo $numero_pedido = str_pad($id_pedido, 4, '0', STR_PAD_LEFT); ?></h2>
                            <?php
                            $dataBanco = $dados_pedido['data'];
                            $formatoData = strtotime($dataBanco);
                            $data = date("d/m/Y", $formatoData);

                            $comentario = htmlspecialchars($dados_pedido['comentario']);
                            $status = $dados_pedido['status'];

                            $statusView = '';
                            if ($status == "encomendado") {
                                $statusView = "Encomendado";
                            } else if ($status == "pagamento") {
                                $statusView = "Aguardando pagamento";
                            } else if ($status == "vendido") {
                                $statusView = "Vendido";
                            } else if ($status == "cancelado") {
                                $statusView = "Cancelado";
                            }

                            foreach ($dados_pedido['produtos'] as $produto) {
                                echo "<p><strong>" . htmlspecialchars($produto['nome']) . "</strong>: " . htmlspecialchars($produto['quantidade']) . " unidades</p>";
                            }
                            ?>

                            <p><strong>Data: </strong><?php echo $data ?></p>
                            <p><strong>Valor final: </strong> R$ <?php echo number_format((float)$dados_pedido['valor_final'], 2, ',', '.') ?></p>
                            <p><strong>Status: </strong><?php echo $statusView ?></p>
                            <p class="p-descricao"><strong>Comentário: </strong><?php if ($comentario) {
                                                                                    echo $comentario;
                                                                                } else {
                                                                                    echo "Nenhum comentário adicionado";
                                                                                } ?></p>

                            <div class="product-btns">
                                <a href="../controller/pedidoControle.php?op=carregarQuantidade&id=<?php echo $id_pedido ?>">Visualizar</a>
                                <a href="../controller/pedidoControle.php?op=excluir&id=<?php echo $id_pedido ?>" onclick="return confirm('Deseja mesmo excluir?');">Excluir</a>
                            </div>
                        </div> <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum pedido cadastrado.</p>
                <?php endif; ?>
            </div>


            <footer>Leonardo Stürmer &copy; Todos os direitos reservados</footer>
        </main>

    </div>

    <script src="busca_pedidos.js"></script>
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