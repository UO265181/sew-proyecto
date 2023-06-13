<?php
require_once 'usuariosObject.php';
require_once 'reservasObject.php';
require_once 'recursosObject.php';
require_once 'presupuestosObject.php';

class Vista
{

    private static $usuarios, $reservas, $recursos, $presupuestos;


    public function __construct()
    {
        self::$usuarios = new UsuariosObject();
        self::$reservas = new ReservasObject();
        self::$recursos = new RecursosObject();
        self::$presupuestos = new PresupuestosObject();
    }

    public function recibirPOST()
    {

        if (isset($_POST['registrarse'])) {
            self::$usuarios->registrarUsuario($_POST['nombre'], $_POST["email"], $_POST["password"]);
        }
        if (isset($_POST['identificarse'])) {
            self::$usuarios->identificarUsuario($_POST["email"], $_POST["password"]);
        }
        if (isset($_POST['reservar'])) {
            self::$reservas->reservarRecurso($_POST["nombre"], $_POST["fecha"], $_POST["hora"]);
        }
        if (isset($_POST['generarPresupuesto'])) {
            self::$presupuestos->generarPresupuesto();
        }
    }


    public function mostrarVista() {
        if (!isset($_SESSION['user_id'])) {
            $this->mostrarVistaNoIdentificado();
        } else {
            $this->mostrarVistaIdentificado();
        }
    }

    private function mostrarVistaNoIdentificado()
    {
        echo "<section>";
        echo "<h2>Información</h2>";
        echo "<p>Bienvenido a la página de reservas. Para poder realizar una reserva primero deberás registrarse. Una vez que te hayas registrado podrás identificarte y empezar a resevar tus recursos turísticos de Cabranes favoritos.</p>";
        echo "</section>";

        // Registro
        echo "<section>";
        echo "<h2>Registrarse</h2>";
        self::$usuarios->imprimirFormularioDeRegistro();
        echo "</section>";

        // Ident
        echo "<section>";
        echo "<h2>Identificarse</h2>";
        self::$usuarios->imprimirFormularioDeIdentificarse();
        echo "</section>";
    }




    private function mostrarVistaIdentificado()
    {
        echo "<section>";
        echo "<h2>Información</h2>";
        echo "<p>¡Bienvenido " . $_SESSION["username"] . "! Puedes realizar reservas y ver tu presupuesto más abajo.</p>";
        echo "<p>Para realizar una reserva deberás utilizar la tabla de recursos turísiticos. Para rellenar el formulario necesitarás el nombre del recurso y la fecha en la que quieres reservar. Ten en cuenta que la hora de reserva ha de coincidir con la disponibilidad del recurso, para ello fijate en la columna de disponibilidad del recurso que quieras reservar.</p>";
        echo "</section>";

        echo "<section>";
        echo "<h2>Recursos Tutísticos</h2>";
        echo "<section>";
        echo "<h3>Tabla de recursos</h3>";
        self::$recursos->obtenerRecursos();
        self::$recursos->imprimirRecursos();
        echo "</section>";
        echo "</section>";

        echo "<section>";
        echo "<h2>Reservas</h2>";
        echo "<section>";
        echo "<h3>Formulario de reserva</h3>";
        self::$reservas->imprimirFormularioDeReserva();
        echo "</section>";
        echo "<section>";
        echo "<h3>Reservas realizadas</h3>";
        self::$reservas->obtenerReservas();
        self::$reservas->imprimirReservas();
        echo "</section>";
        echo "</section>";

        echo "<section>";
        echo "<h2>Presupuesto</h2>";
        self::$presupuestos->imprimirBotonDeGenerarPresupuesto();
        echo "</section>";
    }
}

?>