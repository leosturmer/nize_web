<?php
class ConexaoBanco extends PDO {
    private static $instancia = null;

    public function __construct($dsn, $user, $pass){
        parent::__construct($dsn, $user, $pass);
    }

    public static function getInstancia(){
        if(!isset(self::$instancia)){
            try {
                self::$instancia = new ConexaoBanco("mysql:host=localhost; dbname=nize_database","root", "");
            }catch (Exception $e){
                header("location:../view/general/erro.php?msg=Erro ao conectar com o banco de dados.");
                exit;
            }// fecha o try catch
        }//fecha o if
        return self::$instancia;
    }// fecha o método getInstancia
}// Fecha a classe

// SQLite3

// class ConexaoBanco extends PDO {
//     private static $instancia = null;

//     public function __construct($dsn, $user, $pass) {
//         parent::__construct($dsn, $user, $pass);
//     }

//     public static function getInstancia() {
//         if (!isset(self::$instancia)) {
//             try {
//                 // Defina as credenciais do seu servidor MySQL online
//                 $host = 'localhost'; // Ou o host fornecido pela hospedagem
//                 $dbname = 'nize_database';
//                 $user = 'usuario_banco';
//                 $pass = 'senha_banco';

//                 $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

//                 self::$instancia = new ConexaoBanco($dsn, $user, $pass);
//                 self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//                 self::$instancia->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//             } catch (PDOException $e) {
//                 $msg_erro = urlencode("Erro ao conectar com o banco de dados MySQL.");
//                 header("location:../view/general/erro.php?msg=" . $msg_erro);
//                 exit;
//             }
//         }
//         return self::$instancia;
//     }
// } -->