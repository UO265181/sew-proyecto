<?php

class ConexionDB
{

    private static $servername, $username, $password, $database, $db;

    public function __construct()
    {
        self::$servername = "localhost";
        self::$username = "root";
        self::$password = "";
        self::$database = "test";
    }

    public static function cerrarConexion()
    {
        self::$db->close();
    }

    public static function abrirConexion()
    {
        self::$db = new mysqli(self::$servername, self::$username, self::$password, self::$database);
        if (self::$db->connect_error) {
            echo "ERROR de conexión:" . self::$db->connect_error;
        }
    }


    public static function insertarUsuario($nombre, $email, $password)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?,?,?)");
        $consultaPre->bind_param('sss', $nombre, $email, $password);
        return ConexionDB::realizarConsultaInsertar($consultaPre);
    }

    public static function insertarAforo($id_recurso, $fecha_inicio, $fecha_final, $hora_inicio, $hora_final)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("INSERT INTO aforos (id_recurso, fecha_inicio, fecha_final, hora_inicio, hora_final) VALUES (?,?,?,?,?)");
        $consultaPre->bind_param('issss', $id_recurso, $fecha_inicio, $fecha_final, $hora_inicio, $hora_final);
        return ConexionDB::realizarConsultaInsertar($consultaPre);
    }

    public static function insertarReserva($id_aforo, $id_usuario, $id_recurso)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("INSERT INTO reservas (id_aforo, id_usuario, id_recurso) VALUES (?,?,?)");
        $consultaPre->bind_param('iii', $nombre, $email, $password);
        return ConexionDB::realizarConsultaInsertar($consultaPre);
    }


    public static function obtenerUsuariosPorEmailPassword($email, $password)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM usuarios WHERE email = ? AND password = ?");
        $consultaPre->bind_param('ss', $email, $password);
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }

    public static function obtenerUsuariosPorEmail($email)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $consultaPre->bind_param('s', $email);
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }

    public static function obtenerRecursos()
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM recursos");
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }

    public static function obtenerRecursosPorNombre($nombre)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM recursos WHERE nombre = ?");
        $consultaPre->bind_param('s', $nombre);
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }

    public static function obtenerPresupuestos()
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM presupuestos");
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }

    public static function obtenerAforosPorIdrecursoFechaHora($idRecurso, $fecha, $hora)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM aforos WHERE id_recurso = ? AND fecha_inicio = ? AND hora_inicio = ?");
        $consultaPre->bind_param('sss', $idRecurso, $fecha, $hora);
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }

    
    public static function aumentarAforoActual($idAforo, $aforoActual) {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("UPDATE aforos SET aforoActual = ? WHERE id = ?");
        $consultaPre->bind_param('ii', $aforoActual, $idAforo);
        return ConexionDB::realizarConsultaInsertar($consultaPre);
    }


    private static function realizarConsultaObtener($consultaPre)
    {
        $consultaPre->execute();

        $resultado = array();

        if ($consultaPre->error) {
            $resultado = $consultaPre->error;
        } else {
            $result = $consultaPre->get_result();
            while ($fila = $result->fetch_assoc()) {
                $resultado[] = $fila;
            }
        }

        $consultaPre->close();
        ConexionDB::cerrarConexion();
        return $resultado;
    }


    private static function realizarConsultaInsertar($consultaPre)
    {
        $consultaPre->execute();

        $resultado = null;

        if ($consultaPre->error) {
            $resultado = $consultaPre->error;
        } else {
            $resultado = $consultaPre->affected_rows;
        }

        $consultaPre->close();
        ConexionDB::cerrarConexion();
        return $resultado;
    }



}



$conexion = new ConexionDB();

?>