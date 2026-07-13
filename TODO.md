### No CSS

Ordem de páginas:

- index
- cadastro usuario
- login
- erro

visualizacao produtos
cadastro produtos
alteração produtos
clonar produto

visualizacao pedidos
cadastro pedidos
alteração pedido
alterçaão pedido cancelado
clonar pedido

minha area
alteração cadastro


#### COLOCAR NA DIV PRODUTOS
 - as novas divs do texto e imagem
    - fazer isso nos AJAX e outras telas
 - class="texto-produto"
 - class="product-img-btn"


##### Fazer a responsividade

- Substituir TODAS sidenav pela do tela_inicial (ver bem os class active)
- Adicionar o HEADER em todas as páginas

- FAzer o botão de menu ficar sempre fixo na parte superior
- Tem que ver como fazer isso


- Nas páginas que tem as views de produto, vai ter que virar 1 coluna
- O menu lateral tem que sumir quando ficar muito pequeno, aí tem que aparecer o logo do site em cima e o botão do menu
    -  Aí clica no botão do menu e ele fica na tela toda

- Fazer versão tablet
    - Essa aqui de repente dá só pra trocar a barra para ficar por cima do restante dos itens


- Fazer versão smartphone
    - esse vai ser foda
    
- Tem que ver os header do index, login, cadastro usuário, view_loja, gui_erro (?)
    - Ver os header como ficam, deixei um exemplo no gui_cadastro_usuario



## TESTAR TUDO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

### O QUE ESTÁ DANDO DE ERRO



#### Para o final:

- Botão de resetar senha?
    - tem que enviar email com link de resetar senha

- Ver se faço modo noturno? (não gostei, ver se acho alguma forma mais simples)

- Confirmar todas mensagens
- conferir todos os <title> das páginas

- Testar TUDO. Ver se é possível fazer isso de forma automatizada.
    - Ver a questão de sair de uma tela de pedido e voltar, se não está ficando salva a marcação.


### Na documentação:

- Requisito funcional é o que mexe no banco de dados
    - Casos de uso é colocar os principais

- Mudar as coisas de banco (diagramas)
- Ver as tabelas de use cases pra mudar tbm

-> Use cases tem que ver pq se o pedido não foi vendido, não pode ser cancelado; se o produto já foi cancelado, tem aviso de que foi cancelado e não pode mudar as informações dele além de data e comentários;
-> Ver se vou fazer possibilidade de duplicar produtos e pedidos;

Ok, então para a documentação eu vou ter que alterar as seguintes coisas:
- Agora é só PEDIDOS, sem vendas e encomendas
- Agora tem filtros nos pedidos e produtos (VER SE ISSO É USE CASE)
- Agora tem botão de CLONAR nos pedidos e produtos, que redireciona para telas de clonagem
- Inseri novas colunas nas tabelas: aceita_visualizacao (para pedidos e para o usuário) e uma tabela de nome_visualizacao para gerar o link de visualização da loja do usuário


#### PARA O DIA DA APRESENTAÇÃO:
- Copiar todos arquivos para um pendrive
- Levar um banco de dados pronto
- Levar as fotos dos produtos (!!!!)
- Levar os arquivos do banco de dados / PHP para poder configurar
- Ver de novo no Senac como configurar <code>php --ini</code>
