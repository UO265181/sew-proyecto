<?php
require_once 'conexionDB.php';
require_once 'validacion.php';

class Registrarse
{

    private $errorNombre = "";
    private $errorEmail = "";
    private $errorPassword = "";
    private $fallos = "";

    private function validarDatos($nombre, $email, $password)
    {

        $vNombre = Validacion::validarNombre($nombre);

        $vEmail = Validacion::validarEmail($email);

        $vPassword = Validacion::validarPassword($password);

        if(!$vNombre) {
            $this->errorNombre = "El nombre no puede estar vacío";
        }
        if(!$vEmail) {
            $this->errorEmail = "El email no puede estar vacío y ha de tener un formato válido";
        }
        if(!$vPassword) {
            $this->errorPassword = "La contraseña no puede estar vacía";
        }

        return $vNombre && $vEmail && $vPassword;
    }



    public function comprobarEmailNoRepetido($email)
    {

        $result = ConexionDB::obtenerUsuariosPorEmail($email);


        if (!is_null($result)) {
            if (empty($result)) {
                return true;
            } else {
                $this->fallos .= "Ya existe un usuario con ese email. ";
                return false;
            }
        } else {
            $this->fallos .= "Error al consultar si ese email ya existe. ";
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
                    //TODO: redirect
                } else {
                    $this->fallos .= "Error al insertar al usuario en la base de datos. ";
                }
            } else {
                $this->fallos .= "No se ha podido verificar que el email no exista. ";
            }
        } else {
            $this->fallos .= "Datos del formulario no válidos. ";
        }
    }

    public function imprimirFormulario()
    {
        echo "
<form method='post' action='reservas.php' name='fRegistrarse'>
    <p>Nombre</p>
    <p><input type='text' name='nombre' /><span>&nbsp;" . $this->errorNombre . "</span></p>
    <p>Email</p>
    <p><input type='text' name='email' /><span>&nbsp;" . $this->errorEmail . "</span></p>
    <p>Contraseña</p>
    <p><input type='text' name='password' /><span>&nbsp;" . $this->errorPassword . "</span></p>
    <input type='submit' value='Registrarse' name='registrarse'/>
</form>
";
     if($this->fallos!="") {
        echo "<p><span> El registro no ha sido posible: " . $this->fallos. "</span></p>";
     }
    }

}

?>