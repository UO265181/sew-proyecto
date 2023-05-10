<?php


require_once 'conexionDB.php';
require_once 'validacion.php';

class Registrarse
{

    private function validarDatos($nombre, $email, $password)
    {

        $vNombre = Validacion::validarNombre($nombre);

        $vEmail = Validacion::validarNombre($email);

        $vPassword = Validacion::validarNombre($password);


        // TODO: mostrar cada error

        return $vNombre && $vEmail && $vPassword;
    }



    public function comprobarEmailNoRepetido($email)
    {
        
        $result = ConexionDB::obtenerUsuariosPorEmail($email);
        

        if (!is_null($result)) {
            if (empty($result)) {
                return true;
            } else {
                //TODO: email repe
                echo "email repe";
                return false;
            }
        } else {
            //TODO: error al consulta
            echo "error consulta email";
            return false;
        }


    }

    public function registrarUsuario($nombre, $email, $password)
    {

        $validacion = $this->validarDatos($nombre, $email, $password);

        if ($validacion) {

            $emailNoRepetido = $this->comprobarEmailNoRepetido($email);

            if ($emailNoRepetido) {

                
                $result = ConexionDB::insertarUsuario($nombre, $email, $password);
                

                if ($result === 1) {
                    //TODO: echo "Te has registrado como " . $nombre . ". Ahora puedes iniciar sesión.";
                    echo "Te has registrado como " . $nombre . ". Ahora puedes iniciar sesión.";

                } else {
                    //TODO: error al insertar
                    echo "Error al insertar";
                }
            } else {
                //TODO: no se puc con el email repe
                echo "no se sabe si email no es repe";
            }
        } else {
            //TODO: error en los datos introducidos
            echo "Datos mal";
        }
    }

}


$registrarse = new Registrarse();

$registrarse->registrarUsuario($_POST['nombre'], $_POST["email"], $_POST["password"]);


?>