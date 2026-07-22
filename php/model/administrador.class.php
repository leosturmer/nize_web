<?php 
class Administrador{
    private $id_admin;
    private $login;
    private $senha;
    private $nome;

    public function __construct(){

    }

    public function __get($attribute){
        return $this->$attribute;
    }

    public function __set($attribute, $value){
        $this->$attribute = $value;
    }
}
?>