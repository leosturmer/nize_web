### Ideias não são essenciais:

-------- Fazer a visualização de produtos como link

--- Ver como gerar pelo ID um número aleatório para o link e/ou ver se vai pela NOME do usuário/loja

---- Para isso, colocar no MINHA ÁREA um botão de "disponibilizar produtos para visualização"
---- Nos produtos, colocar este botão também
---- Tem que colocar nas tabelas de produto & fazer uma tabela/view de visualização de produto com os produtos que tem marcado o "disponibilizar para visualização"

-------- Pode ter botão de duplicar pedido e/ou duplicar produto (?)
--- Tem que clicar nele na respectiva tela de ALTERAÇÃO
--- Ele tem que ir pra uma tela de CADASTRO de produto, trocando o produto do carrinho pra um PRODUTO NOVO
--- Tem que fazer as validações de cadastro de produto novo, não de alteração



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

