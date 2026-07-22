<?php 
class Usuario{
    private $id_usuario;
    private $login;
    private $senha;
    private $nome;
    private $nome_loja;
    private $aceita_visualizacao;
    private $nome_visualizacao;
    private $telefone;
    
    private $loja;
    private $tipoUsuario;

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