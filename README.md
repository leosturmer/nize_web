# Nize - Sistema para Vendedores Autônomos

O **Nize** é uma plataforma desenvolvida como Projeto Integrador do curso Técnico em Desenvolvimento de Sistemas do Senac RS. Projetado especificamente para vendedores autônomos, o sistema permite o gerenciamento completo de produtos, pedidos, estoque e vendas em um único local.

O projeto teve início em 2024, contando primeiramente com uma [versão desktop em Python](https://github.com/leosturmer/Nize_Python_Desktop). Atualmente, a plataforma encontra-se em sua versão web, desenvolvida em PHP, HTML5, CSS3, JavaScript e banco de dados MySQL.

---

## Funcionalidades Principais

* **Gestão de Usuários:** Cadastro, autenticação e gerenciamento de perfil.
* **Gestão de Produtos:** Cadastro, edição, duplicação, exclusão e controle de estoque.
* **Gestão de Pedidos:** Controle completo do fluxo de vendas, suporte a encomendas e históricos.
* **Vitrine Virtual (Loja Online):** Opção para tornar produtos públicos e gerar um link exclusivo da loja.
* **Integração com WhatsApp:** Pedidos realizados por clientes na vitrine virtual são salvos no banco de dados e redirecionados diretamente para o WhatsApp do vendedor.

---

## Arquitetura e Tecnologias

O desenvolvimento seguiu a metodologia ágil incremental, permitindo constante evolução do escopo. A estrutura da aplicação adota o padrão de arquitetura **MVC (Model-View-Controller)** associado ao padrão **DAO (Data Access Object)** para abstração e manipulação do banco de dados.

### Tecnologias Utilizadas:
* **Back-end:** PHP
* **Front-end:** HTML5, CSS3, JavaScript
* **Banco de Dados:** MySQL
* **Auxílio de IA:** Utilização do Gemini para suporte na lógica de scripts JavaScript e na complexidade do Controller/DAO durante o processamento relacional de produtos e pedidos.

---

## Documentação do Usuário

Para instruções detalhadas de operação e navegação no sistema, consulte o nosso [Guia de Utilização](./guia_utilizacao.md).

---

## Telas do Sistema

> Projeto em desenvolvimento ativo até setembro de 2026.

| Autenticação e Geral | Gestão de Produtos | Gestão de Pedidos |
| :--- | :--- | :--- |
| **Index**<br>![Index](./github_img/telas/1_index.png) | **Visualização de Produtos**<br>![Visualização de produtos](./github_img/telas/6_visualizacao_produtos.png) | **Visualização de Pedidos**<br>![Visualização de pedidos](./github_img/telas/10_visualizacao_pedidos.png) |
| **Cadastro de Usuário**<br>![Cadastro de usuário](./github_img/telas/2_cadastro_usuario.png) | **Cadastro de Produto**<br>![Cadastro de produtos](./github_img/telas/7_cadastro_produto.png) | **Cadastro de Pedido**<br>![Cadastro de pedidos](./github_img/telas/11_cadastro_pedido.png) |
| **Login**<br>![Login](./github_img/telas/3_login.png) | **Alteração de Produto**<br>![Alteração de produtos](./github_img/telas/8_alteracao_produto.png) | **Alteração de Pedido**<br>![Alteração de pedido](./github_img/telas/12_alterar_pedido.png) |
| **Dashboard Administrador**<br>![Dashboard Administrador](./github_img/telas/4_dashboard_administrador.png) | **Duplicar Produto**<br>![Duplicar produto](./github_img/telas/9_duplicar_produto.png) | **Pedido Cancelado**<br>![Alteração de pedido cancelado](./github_img/telas/13_alteracao_pedido_cancelado.png) |
| **Tela Inicial**<br>![Tela inicial](./github_img/telas/5_tela_inicial.png) | — | **Pedido Vendido**<br>![Alteração de pedido vendido](./github_img/telas/14_alteracao_pedido_vendido.png) |
| **Tela de Erro**<br>![Tela de erro](./github_img/telas/19_erro.png) | — | **Duplicar Pedido**<br>![Duplicar pedido](./github_img/telas/15_duplicar_pedido.png) |

### Perfil e Loja Virtual

| Área do Usuário | Alterar Cadastro | Vitrine Pública da Loja |
| :---: | :---: | :---: |
| ![Área do usuário](./github_img/telas/16_minha_area.png) | ![Alteração de dados de cadastro](./github_img/telas/17_alterar_cadastro.png) | ![Visualização pública de loja](./github_img/telas/18_view_loja.png) |

---

## Diagramas do sistema

| **Diagrama de Casos de Uso** | **Banco de Dados Conceitual** | **Banco de Dados Lógico** |
| :--- | :--- | :--- |
| ![Diagrama de casos de uso](./github_img/diagramas/diagrama_casos_uso.png) | ![Banco de Dados Conceitual](./github_img/diagramas/banco_dados_conceitual.png) | ![Banco de Dados Lógico](./github_img/diagramas/banco_dados_logico.png) 
