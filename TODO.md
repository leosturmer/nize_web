### Página de visualização de loja

- Gerar um link de visualização da loja
    - Para isso, a loja tem que ter selecionado o "ACEITA VISUALIZAÇÃO" na tela da minha área
    - Pode ter um link redirecionando quando colocar algum produto
    - Pra fazer isso, o movimento vai ter que ser: 
    
    1) adicionar o checkbox na tela de minha área e salvar no banco pela DAO. 
    2) Adicionar o nome_visualizacao para gerar o link com o nome da loja 
    3) if (aceita_visualizacao) aí tem um link /loja/nome_visuzliacao 
    4) tendo isso, a tela de visualizacao da loja tem que puxar todos os produtos do ID do vendedor 
    5) mas os produtos tem que estar marcados com o aceita_visualizacao em si
    6) Ou seja, tem que alterar as páginas de cadastro e alteração de produtos, bem como a de visualização de produtos para mostrar pro vendedor se o produto aceita ser exposto ou não


#### Outras coisas para fazer

--- Fazer a GUI ERRO.

## TESTAR TUDO

#### Para o final:

- Confirmar todas mensagens
- conferir todos os <title> das páginas
- Remover os getmessage()


### Na documentação:

- Mudar as coisas de banco (diagramas)
- Ver as tabelas de use cases pra mudar tbm

-> Use cases tem que ver pq se o pedido não foi vendido, não pode ser cancelado; se o produto já foi cancelado, tem aviso de que foi cancelado e não pode mudar as informações dele além de data e comentários;
-> Ver se vou fazer possibilidade de duplicar produtos e pedidos;

Ok, então para a documentação eu vou ter que alterar as seguintes coisas:
- Agora é só PEDIDOS, sem vendas e encomendas
- Agora tem filtros nos pedidos e produtos (VER SE ISSO É USE CASE)
- Agora tem botão de CLONAR nos pedidos e produtos, que redireciona para telas de clonagem
- Inseri novas colunas nas tabelas: aceita_visualizacao (para pedidos e para o usuário) e uma tabela de nome_visualizacao para gerar o link de visualização da loja do usuário

