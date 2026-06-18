<!-- class ConexaoBanco extends PDO {
    private static $instancia = null;

    public function __construct($dsn, $user, $pass){
        parent::__construct($dsn, $user, $pass);
    }

    public static function getInstancia(){
        if(!isset(self::$instancia)){
            try {
                self::$instancia = new ConexaoBanco("mysql:host=localhost; dbname=nize_database","root", "");
            }catch (Exception $e){
                header("location:../view/gui_erro.php?=Erro ao conectar com o banco de dados.");
                exit;
            }// fecha o try catch
        }//fecha o if
        return self::$instancia;
    }// fecha o método getInstancia
}// Fecha a classe -->

<!-- SQLite3 -->

<?php

class ConexaoBanco extends PDO {
    // Armazena a instância única da conexão
    private static $instancia = null;

    public $database;
    public $server;
    public $username = null;
    public $password = null;

    // Construtor herdado do PDO
    public function __construct($dsn, $user, $pass) {
        parent::__construct($dsn, $user, $pass);
    }

    /**
     * Método Singleton que garante apenas uma conexão ativa com o SQLite3
     */
    public static function getInstancia() {
        if (!isset(self::$instancia)) {
            try {
                // __DIR__ garante o caminho absoluto até a pasta atual (persistence)
                // O banco de dados 'nize_database.db' será criado/lido nesta mesma pasta
                $caminhoBanco = __DIR__ . '/nize_database.db';
                $dsn = "sqlite:" . $caminhoBanco;

                // Cria a conexão com o SQLite (sem usuário e sem senha)
                self::$instancia = new ConexaoBanco($dsn, null, null);

                // Configura o PDO para lançar exceções em caso de erros no SQLite
                self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Define o retorno padrão de consultas como array associativo
                self::$instancia->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                // Em caso de erro (ex: pasta sem permissão de escrita), redireciona para a tela de erro
                // urlencode protege a mensagem para trafegar com segurança na URL
                $msg_erro = urlencode("Erro ao conectar com o banco SQLite: " . $e->getMessage());
                header("location:../view/gui_erro.php?msg=" . $msg_erro);
                exit;
            }
        }
        return self::$instancia;
    }
}