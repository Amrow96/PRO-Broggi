<?php

namespace App\Utils;

class Utilidad{

    public static function errorMessage($e){
        if(!empty($e->errorInfo[1])){
            switch ($e->errorInfo[1]){
                case 1062:
                    $mensaje = "Registro duplicado";
                    break;
                case 1451:
                    $mensaje = "Registro con elementos relacionados";
                    break;
                default:
                    $mensaje = $e->errorInfo[1] . " - " . $e->errorInfo[2];
                    break;
            }
        }
        else{
            switch($e->getCode()){
                case 1044:
                    $mensaje = "Usuario y/o password incorrecto";
                    break;
                case 1049:
                    $mensaje = "Base de datos desconocidas";
                    break;
                case 2002:
                    $mensaje = "No se encuentra el servidor";
                    break;
                case 1044:
                    $mensaje = $e->getCode() . " - " . $e->getMessage();
                    break;
            }
        }
        return $mensaje;
    }
}