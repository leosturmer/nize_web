<?php
require_once '../persistence/conexaoBanco.class.php';
require_once '../model/produto.class.php';

class ProdutoDAO{
    private $conexao;

    public function __construct() {
        $this-> conexao = ConexaoBanco::getInstancia();
    }

    public function cadastrarProduto(Produto $p) : bool {
        try {
            $sql = $this->conexao->prepare(
                "INSERT INTO produtos (
                id_usuario, nome, quantidade, valor_unitario, valor_custo, imagem, aceita_encomenda, descricao
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
                );

            return $sql->execute([$p->id_usuario, $p->nome, $p->quantidade, $p->valor_unitario, $p->valor_custo, $p->imagem, $p->aceita_encomenda, $p->descricao]);
            
        } catch (Exception $e){
            $_SESSION['msg'] = "<p class='error-msg'> Erro ao cadastrar produto. Tente novamente. </p>";

            header("location:../view/gui_produtos.php");
            exit;
        }

    }

    public function alterarProduto($produtoModificado){
        try {
            $sql = "
            UPDATE produtos SET 
            nome = :nome, 
            valor_unitario = :valor_unitario, 
            quantidade = :quantidade, 
            imagem = :imagem, 
            aceita_encomenda = :aceita_encomenda, 
            descricao = :descricao, 
            valor_custo = :valor_custo
            WHERE id_produto = :id_produto
            AND id_usuario = :id_usuario;
            ";

            $sql = ConexaoBanco::getInstancia()->prepare($sql);

            $sql->bindValue(":nome", $produtoModificado->nome);
            $sql->bindValue(":valor_unitario", $produtoModificado->valor_unitario);
            $sql->bindValue(":quantidade", $produtoModificado->quantidade);
            $sql->bindValue(":imagem", $produtoModificado->imagem);
            $sql->bindValue(":aceita_encomenda", $produtoModificado->aceita_encomenda);
            $sql->bindValue(":descricao", $produtoModificado->descricao);
            $sql->bindValue(":valor_custo", $produtoModificado->valor_custo);
            $sql->bindValue(":id_produto", $produtoModificado->id_produto);
            $sql->bindValue(":id_usuario", $produtoModificado->id_usuario);

            return $sql->execute();

        } catch (PDOException $e) {
            echo "Erro ao alterar: " . $e->getMessage();
            exit;
        }
    }

    public function excluirProduto($id){
        try {
            $sql = ConexaoBanco::getInstancia()->prepare("DELETE FROM produtos WHERE id_produto = :id");
            
            $sql->bindValue(":id", $id);

            return $sql->execute();

        } catch (PDOException $e) {
            echo "Erro ao excluir: " . $e->getMessage();
        }
    }

    public function listarTodosProdutos($id_usuario) : array {
        try{
            $sql = $this->conexao->prepare("SELECT * FROM produtos WHERE id_usuario = :id_usuario ORDER BY nome ASC");
            $sql->bindValue(":id_usuario", $id_usuario);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e){
            $_SESSION['msg'] = "Erro ao listar produtos";
            header("location:../view/gui_visualizacao_produtos.php");
            exit;
        }
    }

    public function buscarPorId($id){
        try {
            $sql = $this->conexao->prepare("SELECT * FROM produtos WHERE id_produto = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            return $sql->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $_SESSION['msg'] = "<p class='error-msg'>Erro ao buscar ID: " . $e->getMessage() . "</p>"; 
        }
    }

    public function buscarProdutoFiltro($pesquisa, $estoqueProduto, $encomendaProduto, $id_usuario) {
        try {
            $busca = "%" . $pesquisa . "%";

            $sqlStr = "SELECT id_produto, nome, valor_unitario, quantidade, valor_custo, imagem, aceita_encomenda, descricao 
                        FROM produtos
                        WHERE id_usuario = :id_usuario";

            if (!empty($pesquisa)){
                $sqlStr .= " AND (nome LIKE :busca OR descricao LIKE :busca2)";
            }

            if ($estoqueProduto === 'com-estoque'){
                $sqlStr .= " AND quantidade > 0";
            } else if ($estoqueProduto === 'sem-estoque') {
                $sqlStr .= " AND quantidade = 0";
            }

            if ($encomendaProduto === 'com-encomenda'){
                $sqlStr .= " AND aceita_encomenda = 1";
            } else if ($encomendaProduto === 'sem-encomenda') {
                $sqlStr .= " AND aceita_encomenda = 0";
            }

            $sqlStr .= " ORDER BY nome ASC;";

            $sql = $this->conexao->prepare($sqlStr);

            $sql->bindValue(":id_usuario", $id_usuario);

            if (!empty($pesquisa)){
                $sql->bindValue(":busca", $busca);
                $sql->bindValue(":busca2", $busca);
            }

            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e){
            echo $e;
            exit;
        }
    }

    
 

}
