Para funcionar o banco:

- Baixar arquivo do **sqlite-tools-win-x64-3530200.zip** [https://sqlite.org/download.html](https://sqlite.org/download.html);
- Ir em VARIÁVEIS DE AMBIENTE DO USUÁRIO, em PATH e adicionar o caminho para a pasta do SQLite3 (ex: C:\xampp\sqlite);
- No CMD, dar **php --ini**, copiar o caminho que aparece e dar **code <caminho copiado>** para abrir no VS Code;
  - No VS Code, dar CTRL + F e pesquisar por sqlite e ativar o PDO sqlite e o sqlite3;


Para abrir:

- Ir na pasta onde está salvo o projeto e abrir o CMD;
- Dar o comando **php -S localhost:8000 ** 

--------------------------------------------

-- CÓDIGO BANCO: 



-- 1. CRIAÇÃO DO BANCO DE DADOS (Opcional, caso ainda não tenha criado no phpMyAdmin)

USE nize_database;

-- 2. CRIAÇÃO DAS TABELAS

    CREATE TABLE IF NOT EXISTS usuario (
            id_usuario INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            login TEXT NOT NULL UNIQUE,
            senha TEXT NOT NULL, 
            nome TEXT NOT NULL,
            nome_loja TEXT NULL,
            aceita_visualizacao INTEGER NULL,
            nome_visualizacao VARCHAR (50)
    );

    CREATE TABLE IF NOT EXISTS produtos (
            id_produto INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            id_usuario INTEGER NOT NULL,
            nome TEXT NOT NULL,
            valor_unitario REAL NOT NULL,
            quantidade INTEGER NULL,
            imagem TEXT NULL,
            aceita_encomenda INTEGER NULL,
            descricao TEXT NULL,
            valor_custo REAL NULL,
            aceita_visualizacao INTEGER NULL,
            FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario)
    );

    CREATE TABLE IF NOT EXISTS pedidos (
            id_pedido INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            id_usuario INTEGER NOT NULL,
            data TEXT NOT NULL,
            valor_final REAL NOT NULL,
            status TEXT NOT NULL,
            comentario TEXT NULL,
            FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario)
    );

    CREATE TABLE IF NOT EXISTS pedido_produto (
        id_pedido INTEGER NOT NULL,
        id_produto INTEGER NOT NULL,
        quantidade INTEGER NOT NULL,
        valor_unitario REAL NOT NULL,
        FOREIGN KEY (id_pedido) REFERENCES pedidos (id_pedido),
        FOREIGN KEY (id_produto) REFERENCES produtos (id_produto)
    );

-- 3. CRIAÇÃO DAS VIEWS

CREATE VIEW IF NOT EXISTS view_produtos AS
    SELECT id_usuario, id_produto, nome, quantidade, valor_unitario, valor_custo, aceita_encomenda, descricao, imagem
    FROM produtos;

CREATE VIEW IF NOT EXISTS view_pedidos AS 
    SELECT v.id_usuario, v.id_pedido, p.nome, vp.quantidade, v.data, vp.valor_unitario, v.valor_final, v.status, v.comentario
    FROM pedidos v
    INNER JOIN pedido_produto vp ON v.id_pedido = vp.id_pedido
    INNER JOIN produtos p ON vp.id_produto = p.id_produto;


-- Criação de usuário teste

INSERT INTO usuario (nome, nome_loja, login, senha) VALUES ('Leo', 'Loja do Leo', 'leo@leo.com', 'leo123');
