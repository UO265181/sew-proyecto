<?php

require_once 'conexionDB.php';
require_once 'validacion.php';

class Identificarse
{

    private $errorEmail = "";
    private $errorPassword = "";
    private $fallos = "";
    private function validarDatos($email, $password)
    {

        $vEmail = Validacion::validarEmail($email);

        $vPassword = Validacion::validarPassword($password);

        if(!$vEmail) {
            $this->errorEmail = "El email no puede estar vacío y ha de tener un formato válido";
        }
        if(!$vPassword) {
            $this->errorPassword = "La contraseña no puede estar vacía";
        }

        return $vEmail && $vPassword;
    }


    public function iniciarSesion($email, $password)
    {

        $validacion = $this->validarDatos($email, $password);

        if ($validacion) {
            
            $result = ConexionDB::obtenerUsuariosPorEmailYPassword($email, $password);
            
            if ($result!==null) {
                if (count($result) === 1) {
                    $_SESSION["user_id"] = $result[0]["id"];
                    $_SESSION["username"] = $result[0]["nombre"];
                } else {
                    $this->fallos .= "Los datos introducidos no coinciden con ningún usuario. ";
                }
            } else {
                $this->fallos .= "Error al realizar la consulta. ";
            }
        } else {
            $this->fallos .= "Datos del formulario no válidos. ";
        }


    }


    public function imprimirFormulario()
    {
        echo "
<form method='post' action='reservas.php' name='fIdentificarse'>
    <p>Email</p>
    <p><input type='text' name='email' /><span>&nbsp;" . $this->errorEmail . "</span></p>
    <p>Contraseña</p>
    <p><input type='text' name='password' /><span>&nbsp;" . $this->errorPassword . "</span></p>
    <input type='submit' value='Identificarse' name='identificarse'/>
</form>
";
     if($this->fallos!="") {
        echo "<p><span> La identificación no ha sido posible: " . $this->fallos. "</span></p>";
     }
    }

}


?>