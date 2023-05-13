<?php
require_once 'conexionDB.php';
require_once 'validacion.php';

class Reservas
{

    private $reservas;
    private $fallosReservas = "";
    private $fallosReservar = "";
    private $errorNombre = "";
    private $errorHora = "";
    private $errorFecha = "";

    public function validarRecurso($nombre, $fecha, $hora)
    {

        $vNombre = Validacion::validarNombre($nombre);

        $vFecha = Validacion::validarFecha($fecha);

        $vHora = Validacion::validarPassword($hora);

        if (!$vNombre) {
            $this->errorNombre = "El nombre no puede estar vacío";
        }
        if (!$vFecha) {
            $this->errorFecha = "La fecha no puede estar vacía";
        }
        if (!$vHora) {
            $this->errorHora = "La hora no puede estar vacía";
        }

        return $vNombre && $vFecha && $vHora;
    }


    public function obtenerReservas()
    {
        $this->reservas = ConexionDB::obtenerReservasPorIdusuario($_SESSION["user_id"]);
        if ($this->reservas === null) {
            $this->fallosReservas .= "Error al obtener las reservas.";
        } else if (empty($this->reservas)) {
            $this->fallosReservas .= "Aún no has realizado ninguna reserva. ";
        }
    }

    private function comprobarAforoYReservar($aforo, $recurso)
    {
        $aforoMax = intval($recurso["aforo_maximo"]);
        $aforoAct = intval($aforo["aforo_actual"]);

        if ($aforoAct < $aforoMax) {
            // Hay hueco, se reserva y se aumenta el aforo
            $id_reserva = ConexionDB::insertarReserva($aforo["id"], $_SESSION["user_id"], $recurso["id"]);
            if($id_reserva!==null && $id_reserva !== 0) {
                $aforoAct++;
                $aumentarAforo = ConexionDB::aumentarAforoActual($aforo["id"], $aforoAct);
            } else {
                $this->fallosReservar .= "Error al crear la reserva en la base de datos: " . $id_reserva;
            }
        } else {
            // No hay hueco, no se puede reservar
            $this->fallosReservar .= "Lo sentimos, el aforo del recurso está completo para esa hora y día. ";
        }
    }

    public function reservarRecurso($nombre, $fecha, $hora)
    {
        if (isset($_SESSION["user_id"])) {
            $validacion = $this->validarRecurso($nombre, $fecha, $hora);
            if ($validacion) {
                $recurso = ConexionDB::obtenerRecursosPorNombre($nombre);
                if ($recurso !== null) {
                    if (count($recurso) === 1) {
                        $recurso = $recurso[0];

                        // El recurso existe, se intenta realizar una reserva

                        // Comprobar aforo
                        $aforo = ConexionDB::obtenerAforosPorIdrecursoFechaHora($recurso["id"], $fecha, $hora);
                        if ($aforo !== null) {
                            if (count($aforo) === 0) {
                                // No hay nadie inscrito a esa hora aún, se crea el aforo y la reserva

                                // Se crea el aforo
                                $fechaHoraInicial = new DateTime($fecha . ' ' . $hora);
                                $fechaHoraFinal = $this->calcularFechaHoraFinal($recurso["duracion"], $fechaHoraInicial);
                                $id_aforoInsertado = ConexionDB::insertarAforo($recurso["id"], $fecha, $fechaHoraFinal->format('Y-m-d'), $hora, $fechaHoraFinal->format('H:i:s'));

                                // Se recupera
                                $aforo = ConexionDB::obtenerAforosPorIdrecursoFechaHora($recurso["id"], $fecha, $hora);
                                if ($aforo !== null) {
                                    if (count($aforo) === 1) {
                                        $this->comprobarAforoYReservar($aforo[0],$recurso);
                                    } else {
                                        $this->fallosReservar .= "Error al obtener el aforo creado para el recurso. ";
                                    }
                                } else {
                                    $this->fallosReservar .= "Error al realizar la consulta de obtener el aforo creado para el recurso. ";
                                }
                            } else {
                                // El aforo existe, comprobar que no esté lleno
                                $this->comprobarAforoYReservar($aforo[0],$recurso);
                            }
                        } else {
                            $this->fallosReservar .= "Error al realizar la consulta del aforo del recurso. ";
                        }
                    } else {
                        $this->fallosReservar .= "No existe ningún recurso con ese nombre. ";
                    }
                } else {
                    $this->fallosReservar .= "Error al realizar la consulta del recurso. ";
                }
            } else {
                $this->fallosReservar .= "Datos del formulario no válidos. ";
            }
        } else {
            $fallosReservar .= "No se puede realizar una reserva sin identificarse. ";
        }
    }


    private function calcularFechaHoraFinal($duracion, $fechaHoraInicial)
    {
        $duracion = intval($duracion);
        $fechaHoraFinal = $fechaHoraInicial->modify("+{$duracion} hours");
        return $fechaHoraFinal;
    }


    public function imprimirFormularioDeReserva()
    {
        echo "
<form method='post' action='reservas.php'>
    <p>Nombre del recurso turístico</p>
    <p><input type='text' name='nombre' /><span>&nbsp;" . $this->errorNombre . "</span></p>
    <p>Fecha</p>
    <input type='date' name='fecha'><span>&nbsp;" . $this->errorFecha . "</span></p>
    <p>Hora</label>
    <input type='time' name='hora'><span>&nbsp;" . $this->errorHora . "</span></p>
    <input type='submit' value='Reservar' name='reservar'/>
</form>
";
        if ($this->fallosReservar != "") {
            echo "<p><span> La reserva no ha sido posible: " . $this->fallosReservar . "</span></p>";
        }
    }




    public function imprimirReservas()
    {

        if ($this->fallosReservas != "") {
            echo "<p><span> No se han podido obtener las reservas: " . $this->fallosReservas . "</span></p>";
        } else {
            echo '<table><thead><tr>';
            echo '<th>Reserva</th><th>Nombre</th><th>Precio</th><th>Fecha Inicio</th><th>Hora Inicio</th><th>Fecha Final</th><th>Hora Final</th>';
            echo '</tr></thead>';
            echo '<tbody>';

            foreach ($this->reservas as $reserva) {
                $recurso = ConexionDB::obtenerRecursosPorId($reserva["id_recurso"]);
                $recurso = $recurso[0];
                $aforo = ConexionDB::obtenerAforosPorId($reserva["id_aforo"]);
                $aforo = $aforo[0];

                echo '<tr><td>' . $reserva['id'] . '</td>
                <td>' . $recurso['nombre'] . '</td>
                <td>' . $recurso['precio'] . '€' .'</td>
                <td>' . $aforo['fecha_inicio'] . '</td>
                <td>' . $aforo['hora_inicio'] . '</td>
                <td>' . $aforo['fecha_final'] . '</td>
                <td>' . $aforo['hora_final'] . '</td>
                </tr>';
            }

            echo '</tbody>';
            echo '</table>';

        }
    }



}

?>