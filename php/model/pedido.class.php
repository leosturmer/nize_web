<?php

class Pedido {
    private $id_pedido;
    private $id_usuario;
    private $data;
    private $valor_final;
    private $status;
    private $comentario;
    private $produtos;
    private $created_at;
    private $num_pedido;

    public function __construct(){

    }

    public function __get($attribute){
        return $this->$attribute;
    }

    public function __set($attribute, $value){
        $this->$attribute = $value;
    }

    public function __toString(){
        return "Pedido ID: " . $this->id_pedido . " - Total: R$ " . $this->valor_final;
    }
}