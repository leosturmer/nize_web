<?php
class Validacao
{

    public static function testarNome($value)
    {
        if ($value) {
            $value = trim($value);
            return $value;
        }
    }

    public static function validarEmail($value)
    {
        if ($value) {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }
    }

    public static function converterMinuscula($value)
    {
        return strtolower(trim($value));
    }

    public static function validarSenha(string $senha): bool
    {
        $senha = ($senha);
        // Mínimo 8 caracteres, 1 maiúscula, 1 minúscula e 1 número
        $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/';
        return (bool) preg_match($regex, $senha);
    }

    public static function validarTelefone($telefone)
    {
        // Remove tudo que não for número ou sinal de +
        $telefoneLimpo = preg_replace("/[^0-9+]/", "", $telefone);

        // Regex para: DDI opcional (+55 ou 0055), DDD (2 dígitos válidos) e número (8 ou 9 dígitos)
        $regex = '/^(?:\+?(?:55)?)\s?\(?([1-9][0-9])\)?\s?(9?[2-9][0-9]{3}-?[0-9]{4})$/';

        if (preg_match($regex, $telefoneLimpo)) {
            return true; // Telefone válido
        }
        return false; // Formato inválido
    }
}
