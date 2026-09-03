CREATE DATABASE IF NOT EXISTS nize_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 1. SELEÇÃO DO BANCO DE DADOS
USE nize_database;

-- 2. CRIAÇÃO DAS TABELAS

CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    nome_loja VARCHAR(255) NULL,
    aceita_visualizacao INT NULL,
    nome_visualizacao VARCHAR(50) UNIQUE,
    telefone VARCHAR(20) NULL,
    tipo_usuario INT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nome VARCHAR(255) NOT NULL,
    valor_unitario DECIMAL(10,2) NOT NULL,
    quantidade INT NULL,
    imagem TEXT NULL,
    aceita_encomenda INT NULL,
    descricao TEXT NULL,
    comentario TEXT NULL,
    valor_custo DECIMAL(10,2) NULL,
    aceita_visualizacao INT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produtos_usuario FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    num_pedido INT NULL,
    data DATETIME NOT NULL,
    valor_final DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) NOT NULL,
    comentario TEXT NULL,
    mensagem_cliente TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pedidos_usuario FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS pedido_produto (
    id_pedido INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    valor_unitario DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_pedidoproduto_pedido FOREIGN KEY (id_pedido) REFERENCES pedidos (id_pedido) ON DELETE CASCADE,
    CONSTRAINT fk_pedidoproduto_produto FOREIGN KEY (id_produto) REFERENCES produtos (id_produto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. CRIAÇÃO DAS VIEWS

CREATE OR REPLACE VIEW view_produtos AS
SELECT 
    id_usuario, 
    id_produto, 
    nome, 
    quantidade, 
    valor_unitario, 
    valor_custo, 
    aceita_encomenda, 
    comentario, 
    descricao, 
    imagem
FROM produtos;

CREATE OR REPLACE VIEW view_pedidos AS
SELECT 
    v.id_usuario, 
    v.id_pedido, 
    v.num_pedido, 
    p.nome, 
    vp.quantidade, 
    v.data, 
    vp.valor_unitario, 
    v.valor_final, 
    v.status, 
    v.comentario, 
    v.mensagem_cliente
FROM pedidos v
INNER JOIN pedido_produto vp ON v.id_pedido = vp.id_pedido
INNER JOIN produtos p ON vp.id_produto = p.id_produto;

-- 4. TRIGGER PARA NÚMERO DO PEDIDO POR USUÁRIO

DELIMITER //

CREATE TRIGGER gerar_num_pedido_por_usuario
BEFORE INSERT ON pedidos
FOR EACH ROW
BEGIN
    IF NEW.num_pedido IS NULL OR NEW.num_pedido = 0 THEN
        SET NEW.num_pedido = (
            SELECT COALESCE(MAX(num_pedido), 0) + 1
            FROM pedidos
            WHERE id_usuario = NEW.id_usuario
        );
    END IF;
END;
//

DELIMITER ;
