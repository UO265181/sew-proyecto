<?php

class IniciarSesion
{

    private $db;

    public function __construct($servername, $username, $password, $database)
    {
        $this->db = new mysqli($servername, $username, $password, $database);
        if ($this->db->connect_error) {
            exit("<h2>ERROR de conexión:" . $this->db->connect_error . "</h2>");
        } else {
            echo "<h2>Conexión establecida</h2>";
        }
    }

    private function validarDatos($email, $password)
    {
        if (empty($email)) {
            echo "El email es obligatorio.";
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "El email no tiene un formato válido.";
            return false;
        }

        if (empty($password)) {
            echo "La contraseña es obligatoria.";
            return false;
        }

        return true;
    }

    private function obtenerUsuario($email, $password)
    {

        $consultaPre = $this->db->prepare("SELECT * FROM usuarios WHERE email = ? AND password = ?");
        $consultaPre->bind_param('ss', $email, $password);
        $consultaPre->execute();

        $resultado = $consultaPre->get_result();
        $fila = null;
        if ($resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
        } 

        $consultaPre->close();
        $this->db->close();

        return $fila;
    }

    private function iniciarSesion($usuario)
    {
        $_SESSION["user_id"] = $usuario["id"];
        $_SESSION["username"] = $usuario["nombre"];
    }

    public function intentarIniciarSesion($email, $password)
    {

        $validacion = $this->validarDatos($email, $password);

        if ($validacion) {
            $usuario = $this->obtenerUsuario($email, $password);

            if ($usuario) {
                $this->iniciarSesion($usuario);
                echo "¡Bienvenido " . $_SESSION["username"] . "!";
            }else {
                echo "Datos de inicio de sesión incorrectos";
            }
        } else {
            echo "Datos de inicio de sesión no válidos";
        }


    }

}


$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

$iniciarSesion = new IniciarSesion($servername, $username, $password, $database);

$iniciarSesion->intentarIniciarSesion($_POST["email"], $_POST["password"]);


?>