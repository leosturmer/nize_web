<?php 
class Validacao {

    public static function testarNome($value){
        if ($value){
            $value = trim($value);
            return $value;
        }
    }

    public static function validarEmail($value){
        if ($value) {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }
    }

    public static function converterMinuscula($value){
        return strtolower(trim($value));
    }

    public static function validarSenha(string $senha):bool {
        $senha = ($senha);
        // Mínimo 8 caracteres, 1 maiúscula, 1 minúscula e 1 número
        $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/';
        return (bool) preg_match($regex, $senha);
    }

}


?>