#### No CSS:
- O botão CLONAR PRODUTO está muito largo
- alguns títulos não tão centralizados com o botão
- botão de excluir tá grande na tela de alterção de pedido

#### Nos diretórios:
- Mudar o nome dos arquivos e segmentar eles em pastas


### VER se ficou aquelas coisas que anotei na documentação

visualizar o valor do produto na data em que foi vendido
-> isso aqui então vai ter que ser assim:
    -> tela produto vendido -> se o produto está como VENDIDO, ele aparece botão de VISUALIZAR e não ALTERAR
    -> aí ele não pode ter a opção de REMOVER produto nem adicionar produtos ao pedido
    -> o máximo que ele pode fazer é ser transformado em CANCELADO ou ser clonado!!!!! 
    -> acho que é isso

## TESTAR TUDO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

### O QUE ESTÁ DANDO DE ERRADO
- Na visualização de pedidos, tem que puxar o valor do PRODUTO_PEDIDO para o valor_unitario, não pelo próprio PRODUTO
    - Tem que ver o Session['carrinho'], acho que vai ter que mudar isso
    - Em todas alterações de produto tem que buscar pelo preço do BANCO pedido_produto 
    - Tá tudo errado os valores e valor total e quantidade dos PEDIDOS
    - Aí tbm tem que colocar pra LIMPAR o carrinho & o session[produtods] toda vez que sair da página.





- Valor total do pedido está dando com 0 nos pedidos cancelados (?)



#### Para o final:

- Comparar senhas inseridas? colocar botão pra ver a senha digitada?

- Botão de resetar senha?
    - tem que enviar email com link de resetar senha

- Confirmar todas mensagens
- conferir todos os <title> das páginas

- Testar TUDO. Ver se é possível fazer isso de forma automatizada.


### Na documentação:

- Mudar as coisas de banco (diagramas)

-> Use cases tem que ver pq se o pedido não foi vendido, não pode ser cancelado; se o produto já foi cancelado, tem aviso de que foi cancelado e não pode mudar as informações dele além de data e comentários;
-> Ver se vou fazer possibilidade de duplicar produtos e pedidos;

Ok, então para a documentação eu vou ter que alterar as seguintes coisas:
- Agora tem botão de CLONAR nos pedidos e produtos, que redireciona para telas de clonagem
- Inseri novas colunas nas tabelas: aceita_visualizacao (para pedidos e para o usuário) e uma tabela de nome_visualizacao para gerar o link de visualização da loja do usuário


#### PARA O DIA DA APRESENTAÇÃO:
- Copiar todos arquivos para um pendrive
- Levar um banco de dados pronto
- Levar as fotos dos produtos (!!!!)
- Levar os arquivos do banco de dados / PHP para poder configurar
- Ver de novo no Senac como configurar <code>php --ini</code>
