<?php
require_once '../persistence/conexaoBanco.class.php';
require_once '../model/produto.class.php';
require_once '../model/pedido.class.php';

class PedidoDAO{
    private $conexao;

    public function __construct() {
        $this->conexao = ConexaoBanco::getInstancia();
    }

    public function cadastrarPedido(Pedido $pedido, $darBaixaEstoque){
        if (empty($_SESSION['carrinho'])) {
            $_SESSION['msg'] = "<p class='error-msg'>Nenhum produto adicionado ao pedido</p>";
            header("Location: ../view/gui_cadastro_pedidos.php");
            exit;
        }

        try {
            $this->conexao->beginTransaction();

            $sql_pedido = "INSERT INTO pedidos (id_usuario, status, data, comentario, valor_final) VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->conexao->prepare($sql_pedido);
            $stmt->execute([$pedido->id_usuario, $pedido->status, $pedido->data, $pedido->comentario, $pedido->valor_final]);

            $id_pedido = $this->conexao->lastInsertId();

            
            $sql_produto = "INSERT INTO pedido_produto (id_pedido, id_produto, quantidade, valor_unitario) VALUES (?, ?, ?, ?)";
            
            $stmt_produto = $this->conexao->prepare($sql_produto);
            
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade){
                $pegar_valor_unitario = $this->conexao->prepare("SELECT valor_unitario FROM produtos WHERE id_produto = ? AND id_usuario = ?");
                $pegar_valor_unitario->execute([$id_produto, $pedido->id_usuario]);

                $valor_unitario =  $pegar_valor_unitario->fetchColumn();

               
                $stmt_produto->execute([$id_pedido, $id_produto, $quantidade, $valor_unitario]);

                if ($darBaixaEstoque === 1) {
                    $sql_subtrai = $this->conexao->prepare("UPDATE produtos 
                        SET quantidade = quantidade - ? 
                        WHERE id_produto = ? AND quantidade >= ?");
                    $sql_subtrai->execute([$quantidade, $id_produto, $quantidade]);
                    
                    if ($sql_subtrai->rowCount() === 0) {
                        $_SESSION['msg'] = "<p class='error-msg'>Estoque insuficiente para um ou mais produtos.</p>";
                        header("Location: ../view/gui_cadastro_pedidos.php");
                        exit;
                    }
                }

            }

            $this->conexao->commit();
            return true;

            } catch (Exception $e) {
            $this->conexao->rollBack();
            echo "Erro ao cadastrar.";
            exit;
        }
    }

    public function alterarPedido(Pedido $pedido, $darBaixaEstoque, $estornarEstoque){
        if (empty($_SESSION['carrinho'])) {
            $_SESSION['msg'] = "<p class='error-msg'>Nenhum produto adicionado ao pedido.</p>";
            header("Location: ../view/gui_visualizacao_pedidos.php");
            exit;
        }

        try {
            $this->conexao->beginTransaction();

            $sql = $this->conexao->prepare("UPDATE pedidos SET 
                data = :data, status = :status, comentario = :comentario, valor_final = :valor_final 
                WHERE id_pedido = :id_pedido AND id_usuario = :id_usuario");
            
            $sql->bindValue(":data", $pedido->data);
            $sql->bindValue(":status", $pedido->status);
            $sql->bindValue(":comentario", $pedido->comentario);
            $sql->bindValue(":valor_final", $pedido->valor_final);
            $sql->bindValue(":id_pedido", $pedido->id_pedido);
            $sql->bindValue(":id_usuario", $pedido->id_usuario);
            $sql->execute();

            if ($darBaixaEstoque === 1) {
                foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                    $sql_subtrai = $this->conexao->prepare("UPDATE produtos 
                        SET quantidade = quantidade - ? 
                        WHERE id_produto = ? AND quantidade >= ?");
                    $sql_subtrai->execute([$quantidade, $id_produto, $quantidade]);
                    
                    if ($sql_subtrai->rowCount() === 0) {
                            $_SESSION['msg'] = "<p class='error-msg'>Estoque insuficiente para um ou mais produtos.</p>";
                            header("Location: ../view/gui_alteracao_pedidos.php?id=$pedido->id_pedido");
                            exit;

                    }
                }
            } 
            else if ($estornarEstoque === 1) {
                foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                    $sql_soma = $this->conexao->prepare("UPDATE produtos 
                        SET quantidade = quantidade + ? 
                        WHERE id_produto = ?");
                    $sql_soma->execute([$quantidade, $id_produto]);
                }
            }

            $delete_relacao = $this->conexao->prepare("DELETE FROM pedido_produto WHERE id_pedido = ?");
            $delete_relacao->execute([$pedido->id_pedido]);

            $sql_produto = "INSERT INTO pedido_produto (id_pedido, id_produto, quantidade, valor_unitario) VALUES (?, ?, ?, ?)";
            $stmt_produto = $this->conexao->prepare($sql_produto);

            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                $stmt_preco = $this->conexao->prepare("SELECT valor_unitario FROM produtos WHERE id_produto = ?");
                $stmt_preco->execute([$id_produto]);
                $prod = $stmt_preco->fetch(PDO::FETCH_ASSOC);
                $valor_unitario = $prod ? $prod['valor_unitario'] : 0;

                $stmt_produto->execute([$pedido->id_pedido, $id_produto, $quantidade, $valor_unitario]);
            }

            $this->conexao->commit();
            return true;
        }
        catch (Exception $e){
            $this->conexao->rollBack();
            echo "Erro ao alterar encomenda.";
            exit;
        }

    }

    public function removerQuantidade($id_produto, $id_pedido){
        try {
            $sql = $this->conexao->prepare("DELETE FROM pedido_produto WHERE id_produto = ? AND id_pedido = ?");
            $sql->execute([$id_produto, $id_pedido]);
        } catch (Exception $e) {
            echo "Erro ao remover produto do pedido.";
            exit;
        }

    }

    public function listarTodosPedidos($id_usuario){
        try {
            $sql = $this->conexao->prepare(
                "SELECT id_pedido, data, nome, quantidade, comentario, status, valor_unitario, valor_final
                    FROM view_pedidos 
                    WHERE id_usuario = :id_usuario
                    ORDER BY id_pedido DESC");
            $sql->bindValue(":id_usuario", $id_usuario);
            $sql->execute();
            $selectAll = $sql->fetchAll(PDO::FETCH_ASSOC);

            $pedidosDict = [];
            foreach ($selectAll as $linha) {
                $id_pedido = $linha['id_pedido'];

                if (!isset($pedidosDict[$id_pedido])) {
                    $pedidosDict[$id_pedido] = [
                        'produtos'   => [],
                        'data'      => $linha['data'],
                        'comentario' => $linha['comentario'],
                        'status'     => $linha['status'],
                        'valor_final'     => $linha['valor_final']
                    ];
                }

                $pedidosDict[$id_pedido]['produtos'][] = [
                    'nome'       => $linha['nome'],
                    'quantidade' => $linha['quantidade'],
                    'valor_unitario' => $linha['valor_unitario']
                ];
            }
            return $pedidosDict;
        } catch (Exception $e) {
            echo "Erro ao listar pedidos.";
            return [];
        }
    }

    public function buscarPedidoFiltro($pesquisa, $data, $status, $ordenar, $id_usuario){
        try {
            $busca = "%" . $pesquisa . "%";

            $sqlStr = "SELECT id_pedido, data, nome, quantidade, comentario, status, valor_unitario, valor_final
            FROM view_pedidos
            WHERE id_usuario = :id_usuario";

            if (!empty($pesquisa)) {
                $sqlStr .= " AND (comentario LIKE :busca 
                OR nome LIKE :busca2 
                OR id_pedido LIKE :busca3
                )";
            }

            if (!empty($data)) {
                $sqlStr .= " AND DATE(data) = :data_pedido";
            }

            if (!empty($status)) {
                $sqlStr .= " AND status = :status_pedido";
            }

            if (!empty($ordenar)){
                if ($ordenar === "numero-asc") { 
                    $sqlStr .= " ORDER BY id_pedido ASC";
                } else if ($ordenar === "numero-desc") { 
                    $sqlStr .= " ORDER BY id_pedido DESC";
                } else if ($ordenar === "data-asc") {
                    $sqlStr .= " ORDER BY data ASC";
                } else if ($ordenar === "data-desc") {
                    $sqlStr .= " ORDER BY data DESC";
                }
                
            } else {
                $sqlStr .= " ORDER BY id_pedido DESC;";

            }

            $sql = $this->conexao->prepare($sqlStr);

            $sql->bindValue(":id_usuario", $id_usuario);


            if (!empty($pesquisa)) {
                $sql->bindValue(":busca", $busca);
                $sql->bindValue(":busca2", $busca);
                $sql->bindValue(":busca3", ltrim($pesquisa, "0"));
            }

            if (!empty($data)) {
                $sql->bindValue(":data_pedido", $data);
            }

            if (!empty($status)) {
                $sql->bindValue(":status_pedido", $status);
            }

            $sql->execute();

            $selectAll = $sql->fetchAll(PDO::FETCH_ASSOC);

            $pedidosDict = [];
            foreach ($selectAll as $linha) {
                $id_pedido = $linha['id_pedido'];

                if (!isset($pedidosDict[$id_pedido])) {
                    $pedidosDict[$id_pedido] = [
                        'produtos'   => [],
                        'data'      => $linha['data'],
                        'comentario' => $linha['comentario'],
                        'status'     => $linha['status'],
                        'valor_final'     => $linha['valor_final']
                    ];
                }

                $pedidosDict[$id_pedido]['produtos'][] = [
                    'nome'       => $linha['nome'],
                    'quantidade' => $linha['quantidade'],
                    'valor_unitario' => $linha['valor_unitario']
                ];
            }
            return $pedidosDict;

        } catch (Exception $e){
            echo $e;
            header("location:../view/gui_erro.php?msg=Erro ao realizar a busca avançada.");
            exit;
        }
    }
    
    public function buscarPedidoID($id_pedido){
        try {
            $sql = $this->conexao->prepare("SELECT id_pedido, data, comentario, status, valor_final
                    FROM view_pedidos WHERE id_pedido = :id_pedido");
            $sql->bindValue(":id_pedido", $id_pedido);
            $sql->execute();
            $select = $sql->fetch(PDO::FETCH_ASSOC);

            if (!$select) {
                return []; 
            }

            $encomendasDict = [
                'id_pedido' => $select['id_pedido'],
                'data'        => $select['data'],
                'comentario'   => $select['comentario'],
                'status'       => $select['status'],
                'valor_final' => $select['valor_final'],
                'produtos'     => []
            ];

            $sql_produtos = $this->conexao->prepare("SELECT id_produto, quantidade, valor_unitario FROM pedido_produto WHERE id_pedido = :id_pedido");
            $sql_produtos->bindValue(":id_pedido", $id_pedido);
            $sql_produtos->execute();
            $selectProdutos = $sql_produtos->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($selectProdutos as $linhas){
                $encomendasDict['produtos'][] = [
                    'id_produto' => $linhas['id_produto'],
                    'quantidade' => $linhas['quantidade'],
                    'valor_unitario' => $linhas['valor_unitario']
                ];
            }

            return $encomendasDict;
        } catch (Exception $e) {
            echo "Erro ao buscar pedido.";
        }

    }

    public function excluirPedido($id_pedido){
        try {
            $sql = $this->conexao->prepare("DELETE FROM pedidos WHERE id_pedido = :id_pedido");
            $sql_relacao = $this->conexao->prepare("DELETE FROM pedido_produto WHERE id_pedido = :id_pedido");

            $sql->bindValue(":id_pedido", $id_pedido);
            $sql_relacao->bindValue(":id_pedido", $id_pedido);

            return $sql->execute() && $sql_relacao->execute();
        } catch (Exception $e) {
            echo "Erro ao excluir.";
        }
    }

}