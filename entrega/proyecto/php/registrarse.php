<?php
class Registrarse
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

    private function validarDatos($nombre, $email, $password)
    {

        if (empty($nombre)) {
            echo "El nombre es obligatorio.";
            return false;
        }

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

    private function insertarUsuario($nombre, $email, $password)
    {

        $consultaPre = $this->db->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?,?,?)");
        $consultaPre->bind_param('sss', $nombre, $email, $password);
        $consultaPre->execute();

        if ($consultaPre->error) {
            echo "Error en la consulta: " . $consultaPre->error;
        } else {
            echo "<p>Filas agregadas: " . $consultaPre->affected_rows . "</p>";
        }

        $consultaPre->close();

        $this->db->close();
    }

    private function notificarRegistro($nombre)
    {
        echo "Te has registrado como " . $nombre . ". Ahora puedes iniciar sesión.";
    }

    public function intentarRegistrarse($nombre, $email, $password)
    {

        $validacion = $this->validarDatos($nombre, $email, $password);

        if ($validacion) {
            $this->insertarUsuario($nombre, $email, $password);
            $this->notificarRegistro($nombre);
        } else {
            echo "Datos de registro no válidos";
        }


    }

}


$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

$registrarse = new Registrarse($servername, $username, $password, $database);

$registrarse->intentarRegistrarse($_POST['nombre'], $_POST["email"], $_POST["password"]);


?>