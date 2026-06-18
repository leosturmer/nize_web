<?php 

class Produto {
    private $id_produto;
    private $nome;
    private $quantidade;
    private $valor_unitario;
    private $valor_custo;
    private $imagem;
    private $aceita_encomenda;
    private $descricao;

    // public function __construct(){
    // }

    public function __get($attribute){
        return $this->$attribute;
    }

    public function __set($attribute, $value){
        $this->$attribute = $value;
    }

    public function __toString(){
        return "Produto: $this->nome, Quantidade: $this->quantidade, Valor unitário: $this->valor_unitario"; 
    }

}

?>