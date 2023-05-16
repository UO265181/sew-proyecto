<?php

class ConexionDB
{

    private static $servername, $username, $password, $database, $db;

    public function __construct()
    {
        self::$servername = "localhost";
        self::$username = "sewAdmin";
        self::$password = "sewAdmin+01";
        self::$database = "cabranes";
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

    // RESERVAS ----------------------------------
    public static function insertarReserva($id_aforo, $id_usuario, $id_recurso)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("INSERT INTO reservas (id_aforo, id_usuario, id_recurso) VALUES (?,?,?)");
        $consultaPre->bind_param('iii', $id_aforo, $id_usuario, $id_recurso);
        return ConexionDB::realizarConsultaInsertar($consultaPre);
    }
    public static function obtenerReservasPorIdusuario($id_usuario)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM reservas WHERE id_usuario = ?");
        $consultaPre->bind_param('i', $id_usuario);
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }
    
    // USUARIOS ----------------------------------
    public static function insertarUsuario($nombre, $email, $password)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?,?,?)");
        $consultaPre->bind_param('sss', $nombre, $email, $password);
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
    public static function obtenerUsuariosPorId($id)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $consultaPre->bind_param('i', $id);
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }


    // RECURSOS ----------------------------------
    public static function obtenerRecursos()
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM recursos");
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }
    public static function obtenerRecursosPorId($id)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM recursos WHERE id = ?");
        $consultaPre->bind_param('i', $id);
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }
    public static function obtenerRecursosPorNombre($nombre)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM recursos WHERE nombre = ?");
        $consultaPre->bind_param('s', $nombre);
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }

    // PRESUPUESTOS ----------------------------------
    public static function obtenerPresupuestos()
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM presupuestos");
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }
    public static function insertarPresupuesto($id_usuario)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("INSERT INTO presupuestos (id_usuario) VALUES (?)");
        $consultaPre->bind_param('i', $id_usuario);
        return ConexionDB::realizarConsultaInsertar($consultaPre);
    }

    // PRESUPUESTOSRESERVAS ----------------------------------
    public static function insertarPresupuestosReservas($id_presupuesto, $id_reserva)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("INSERT INTO presupuestosreservas (id_presupuesto, id_reserva) VALUES (?, ?)");
        $consultaPre->bind_param('ii', $id_presupuesto, $id_reserva);
        return ConexionDB::realizarConsultaInsertar($consultaPre);
    }

    // AFOROS ----------------------------------
    public static function obtenerAforosPorId($id)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM aforos WHERE id = ?");
        $consultaPre->bind_param('i', $id);
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }
    public static function obtenerAforosPorIdrecursoFechaHora($idRecurso, $fecha, $hora)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("SELECT * FROM aforos WHERE id_recurso = ? AND fecha_inicio = ? AND hora_inicio = ?");
        $consultaPre->bind_param('iss', $idRecurso, $fecha, $hora);
        return ConexionDB::realizarConsultaObtener($consultaPre);
    }
    public static function aumentarAforoActual($idAforo, $aforoActual) {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("UPDATE aforos SET aforo_actual = ? WHERE id = ?");
        $consultaPre->bind_param('ii', $aforoActual, $idAforo);
        return ConexionDB::realizarConsultaInsertar($consultaPre);
    }
    public static function insertarAforo($id_recurso, $fecha_inicio, $fecha_final, $hora_inicio, $hora_final)
    {
        ConexionDB::abrirConexion();
        $consultaPre = self::$db->prepare("INSERT INTO aforos (id_recurso, fecha_inicio, fecha_final, hora_inicio, hora_final) VALUES (?,?,?,?,?)");
        $consultaPre->bind_param('issss', $id_recurso, $fecha_inicio, $fecha_final, $hora_inicio, $hora_final);
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
            $resultado = $consultaPre->insert_id;
        }

        $consultaPre->close();
        ConexionDB::cerrarConexion();
        return $resultado;
    }



}



$conexion = new ConexionDB();

?>