<?php

require_once 'conexionDB.php';
require_once 'validacion.php';

class IniciarSesion
{

    private function validarDatos($email, $password)
    {

        $vEmail = Validacion::validarNombre($email);

        $vPassword = Validacion::validarNombre($password);

        // TODO: mostrar cada error

        return $vEmail && $vPassword;
    }


    public function iniciarSesion($email, $password)
    {

        $validacion = $this->validarDatos($email, $password);

        if ($validacion) {
            
            $result = ConexionDB::obtenerUsuariosPorEmailYPassword($email, $password);
            
            if ($result != null) {
                if (count($result) === 1) {

                    $_SESSION["user_id"] = $result[0]["id"];
                    $_SESSION["username"] = $result[0]["nombre"];

                    //TODO:echo "¡Bienvenido " . $_SESSION["username"] . "!";
                    echo "¡Bienvenido " . $_SESSION["username"] . "!";
                } else {
                    //TODO: datos no coinciden con ningun usuario
                }
            } else {
                //TODO: error al consulta
            }
        } else {
            //TODO: echo "Datos de inicio de sesión no válidos";
        }


    }

}


$iniciarSesion = new IniciarSesion();

$iniciarSesion->iniciarSesion($_POST["email"], $_POST["password"]);


?>