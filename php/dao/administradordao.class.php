<?php
require_once '../persistence/conexaoBanco.class.php';
require_once '../model/administrador.class.php';

class AdministradorDAO {
    private $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBanco::getInstancia();
    }


    public function buscarEmail($email): array
    {
        try {
            $sql_email = $this->conexao->prepare("SELECT login, senha FROM usuario WHERE login = ?");
            $sql_email->execute([$email]);
            return $sql_email->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar.";
            exit;
        }
    }




}