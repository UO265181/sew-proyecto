<?php
require_once 'conexionDB.php';
require_once 'validacion.php';

class Usuarios
{

    private $errorNombreReg = "";
    private $errorEmailReg = "";
    private $errorPasswordReg = "";
    private $fallosReg = "";


    private $errorEmailId = "";
    private $errorPasswordId = "";
    private $fallosId = "";

    private function validarDatosRegistro($nombre, $email, $password)
    {

        $vNombre = Validacion::validarNombre($nombre);

        $vEmail = Validacion::validarEmail($email);

        $vPassword = Validacion::validarPassword($password);

        if (!$vNombre) {
            $this->errorNombreReg = "El nombre no puede estar vacío";
        }
        if (!$vEmail) {
            $this->errorEmailReg = "El email no puede estar vacío y ha de tener un formato válido";
        }
        if (!$vPassword) {
            $this->errorPasswordReg = "La contraseña no puede estar vacía";
        }

        return $vNombre && $vEmail && $vPassword;
    }

    private function validarDatosIdentificarse($email, $password)
    {

        $vEmail = Validacion::validarEmail($email);

        $vPassword = Validacion::validarPassword($password);

        if (!$vEmail) {
            $this->errorEmailId = "El email no puede estar vacío y ha de tener un formato válido";
        }
        if (!$vPassword) {
            $this->errorPasswordId = "La contraseña no puede estar vacía";
        }

        return $vEmail && $vPassword;
    }




    public function comprobarEmailNoRepetido($email)
    {

        $result = ConexionDB::obtenerUsuariosPorEmail($email);


        if (!is_null($result)) {
            if (empty($result)) {
                return true;
            } else {
                $this->fallosReg .= "Ya existe un usuario con ese email. ";
                return false;
            }
        } else {
            $this->fallosReg .= "Error al consultar si ese email ya existe. ";
            return false;
        }


    }

    public function registrarUsuario($nombre, $email, $password)
    {

        $validacion = $this->validarDatosRegistro($nombre, $email, $password);

        if ($validacion) {

            $emailNoRepetido = $this->comprobarEmailNoRepetido($email);

            if ($emailNoRepetido) {


                $result = ConexionDB::insertarUsuario($nombre, $email, $password);


                if ($result === 1) {
                    //TODO: echo "Te has registrado como " . $nombre . ". Ahora puedes iniciar sesión.";
                    echo "Te has registrado como " . $nombre . ". Ahora puedes iniciar sesión.";
                    //TODO: redirect
                } else {
                    $this->fallosReg .= "Error al insertar al usuario en la base de datos. ";
                }
            } else {
                $this->fallosReg .= "No se ha podido verificar que el email no exista. ";
            }
        } else {
            $this->fallosReg .= "Datos del formulario no válidos. ";
        }
    }




    public function identificarUsuario($email, $password)
    {

        $validacion = $this->validarDatosIdentificarse($email, $password);

        if ($validacion) {

            $result = ConexionDB::obtenerUsuariosPorEmailYPassword($email, $password);

            if ($result !== null) {
                if (count($result) === 1) {
                    $_SESSION["user_id"] = $result[0]["id"];
                    $_SESSION["username"] = $result[0]["nombre"];
                } else {
                    $this->fallosId .= "Los datos introducidos no coinciden con ningún usuario. ";
                }
            } else {
                $this->fallosId .= "Error al realizar la consulta. ";
            }
        } else {
            $this->fallosId .= "Datos del formulario no válidos. ";
        }


    }


    public function imprimirFormularioDeIdentificarse()
    {
        echo "
<form method='post' action='reservas.php'>
    <p>Email</p>
    <p><input type='text' name='email' /><span>&nbsp;" . $this->errorEmailId . "</span></p>
    <p>Contraseña</p>
    <p><input type='text' name='password' /><span>&nbsp;" . $this->errorPasswordId . "</span></p>
    <input type='submit' value='Identificarse' name='identificarse'/>
</form>
";
        if ($this->fallosId != "") {
            echo "<p><span> La identificación no ha sido posible: " . $this->fallosId . "</span></p>";
        }
    }

    public function imprimirFormularioDeRegistro()
    {
        echo "
<form method='post' action='reservas.php'>
    <p>Nombre</p>
    <p><input type='text' name='nombre' /><span>&nbsp;" . $this->errorNombreReg . "</span></p>
    <p>Email</p>
    <p><input type='text' name='email' /><span>&nbsp;" . $this->errorEmailReg . "</span></p>
    <p>Contraseña</p>
    <p><input type='text' name='password' /><span>&nbsp;" . $this->errorPasswordReg . "</span></p>
    <input type='submit' value='Registrarse' name='registrarse'/>
</form>
";
        if ($this->fallosReg != "") {
            echo "<p><span> El registro no ha sido posible: " . $this->fallosReg . "</span></p>";
        }
    }


}

?>