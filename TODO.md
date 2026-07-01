#### Outras coisas para fazer
- Páginas para alterar CSS ainda:

    - Telas de cadastro/alteração de pedido: 
        - Posso tentar colocar lado a lado, na esquerda os produtos do pedido e na direita o box com as informações do total do pedido, prazo, etc.

    - alterar cadastro
        - Ver o checkbox de aceita visualização da loja 

    - Fazer a validação pra, se a pessoa tirar o status "vendido" e o checkbox sumir, não vai pegar o checkbox


- Ajustar os CSS dos SELECTS num geral das telas de produtos e pedidos

    - View loja 
        - talvez colocar botão de whatsapp, mas aí vai ter que colcoar o número com DDD e DDI


### O QUE ESTÁ DANDO DE ERRO

- 

## TESTAR TUDO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

#### Para o final:

- Se eu for colocar botão de WhatsApp na view 
    - Precisa colocar o telefone no banco de dados
    - tem que alterar o arquivo de criação do banco
    - tem que colocar filtro para ver se o telefone está correto
    - tem que colocar opção se quer ou não o botão do whatsapp
    - se quiser, tem que colocar um if echo na tela de visualização da loja

- Ver se faço modo noturno?
- Colocar acessibilidade?

- Confirmar todas mensagens
- conferir todos os <title> das páginas

- Testar TUDO. Ver se é possível fazer isso de forma automatizada.
    - Ver a questão de sair de uma tela de pedido e voltar, se não está ficando salva a marcação.


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


#### PARA O DIA DA APRESENTAÇÃO:
- Copiar todos arquivos para um pendrive
- Levar um banco de dados pronto
- Levar as fotos dos produtos (!!!!)
- Levar os arquivos do banco de dados / PHP para poder configurar
- Ver de novo no Senac como configurar <code>php --ini</code>
