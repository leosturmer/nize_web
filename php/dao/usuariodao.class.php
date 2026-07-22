<?php
require_once '../persistence/conexaoBanco.class.php';
require_once '../model/usuario.class.php';

class UsuarioDAO
{
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

    public function buscarId(string $nome_visualizacao)
    {
        try {
            $sql = $this->conexao->prepare("SELECT id_usuario FROM usuario WHERE nome_visualizacao = :nome_visualizacao");
            $sql->bindVAlue(":nome_visualizacao", $nome_visualizacao);
            $sql->execute();
            return $sql->fetchColumn();
            
        } catch (PDOException $e) {
            echo "Erro ao buscar.";
            exit;
        }
    }

    public function buscarNomeView($nomeView)
    {
        try {
            $sql = $this->conexao->prepare("SELECT nome_visualizacao FROM usuario WHERE nome_visualizacao = ?");
            $sql->execute([$nomeView]);
            return $sql->fetchColumn();
        } catch (PDOException $e) {
            echo "Erro ao buscar" . $e->getMessage();
            exit;
        }
    }

    public function buscarAceitaView($id_usuario)
    {
        try {
            $sql = $this->conexao->prepare("SELECT aceita_visualizacao FROM usuario WHERE id_usuario = ?");
            $sql->execute([$id_usuario]);
            return $sql->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar.";
            exit;
        }
    }

    public function buscarNomeLoja($id_usuario)
    {
        try {
            $sql = $this->conexao->prepare("SELECT nome_loja FROM usuario WHERE id_usuario = ?");
            $sql->execute([$id_usuario]);
            return $sql->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar.";
            exit;
        }
    }

    public function buscarTelefone($id_usuario)
    {
        try {
            $sql = $this->conexao->prepare("SELECT telefone FROM usuario WHERE id_usuario = ?");
            $sql->execute([$id_usuario]);
            return $sql->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar.";
            exit;
        }
    }

    public function cadastrarUsuario(Usuario $usuario)
    {
        try {
            $sql = $this->conexao->prepare(
                "INSERT INTO usuario (login, nome, nome_loja, senha)
            VALUES (?, ?, ?, ?)"
            );

            return $sql->execute([$usuario->login, $usuario->nome, $usuario->nome_loja, $usuario->senha]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                echo "Erro ao cadastrar.";
                return false;
            }
        }
    }

    public function alterarDados($usuarioModificado): bool
    {
        try {
            $sql = "
            UPDATE usuario SET
            nome = :nome,
            nome_loja = :nome_loja,
            login = :login,
            aceita_visualizacao = :aceita_visualizacao,
            nome_visualizacao = :nome_visualizacao,
            telefone = :telefone
            WHERE id_usuario = :id_usuario;
            ";

            $sql = ConexaoBanco::getInstancia()->prepare($sql);

            $sql->bindValue(":nome", $usuarioModificado->nome);
            $sql->bindValue(":nome_loja", $usuarioModificado->nome_loja);
            $sql->bindValue(":login", $usuarioModificado->login);
            $sql->bindValue(":id_usuario", $usuarioModificado->id_usuario);
            $sql->bindValue(":aceita_visualizacao", $usuarioModificado->aceita_visualizacao);
            $sql->bindValue(":nome_visualizacao", $usuarioModificado->nome_visualizacao);
            $sql->bindValue(":telefone", $usuarioModificado->telefone);

            return $sql->execute();
        } catch (PDOException $e) {
            echo "Erro ao alterar.";
            exit;
        }
    }

    public function excluirUsuario($id)
    {
        try {
            $sql_usuario = ConexaoBanco::getInstancia()->prepare("DELETE FROM usuario WHERE id_usuario = :id;");
            $sql_produtos = ConexaoBanco::getInstancia()->prepare("DELETE FROM produtos WHERE id_usuario = :id2;");
            $sql_pedidos = ConexaoBanco::getInstancia()->prepare("DELETE FROM pedidos WHERE id_usuario = :id3;");

            $sql_usuario->bindValue(":id", $id);
            $sql_produtos->bindValue(":id2", $id);
            $sql_pedidos->bindValue(":id3", $id);

            $sql_usuario->execute();
            $sql_produtos->execute();
            $sql_pedidos->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erro ao excluir";
        }
    }

    // Tela de administrador

    public function buscarUsuarios() {
        try {
            $sql = $this->conexao->prepare("SELECT id_usuario, login, nome, tipo_usuario FROM usuario");
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar.";
            exit;
        }
    }

}
