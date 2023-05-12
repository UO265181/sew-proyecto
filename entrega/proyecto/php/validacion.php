<?php

class Validacion
{

    public static function validarEmail($email)
    {
        if (empty($email)) {
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public static function validarPassword($password)
    {
        if (empty($password)) {
            return false;
        }
        return true;
    }

    public static function validarNombre($nombre)
    {
        if (empty($nombre)) {
            return false;
        }
        return true;
    }

    public static function validarFecha($fecha)
    {
        if (empty($fecha)) {
            return false;
        }
        return true;
    }

    public static function validarHora($fecha)
    {
        if (empty($fecha)) {
            return false;
        }
        return true;
    }



}