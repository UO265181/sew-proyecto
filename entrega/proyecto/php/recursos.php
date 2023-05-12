<?php

require_once 'conexionDB.php';

class Recursos
{

    private $recursos;
    private $errorNombre = "";
    private $errorHora = "";
    private $errorFecha = "";
    private $fallosRecursos = "";
    private $fallosReservar = "";

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

    public function obtenerRecursos()
    {
        $this->recursos = ConexionDB::obtenerRecursos();
        if ($this->recursos === null) {
            $this->fallosRecursos .= "Error al obtener los recursos.";
        } else if (empty($this->recursos)) {
            $this->fallosRecursos .= "No hay ningún recurso disponible. ";
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

                        // El recurso existe se intenta realizar una reserva
                        // Se formatea fecha y hora
                        $fecha = new DateTime($fecha);
                        $fecha = $fecha->format('Y-m-d');
                        $hora = new DateTime($hora);
                        $hora = $hora->format('H:i:s');
                        $fechaHoraInicial = new DateTime($fecha . ' ' . $hora);

                        // Comprobar aforo
                        $aforo = ConexionDB::obtenerAforosPorIdrecursoFechaHora($recurso["id"], $fecha, $hora);
                        if ($aforo !== null) {
                            if (count($aforo) === 0) {
                                // No hay nadie inscrito a esa hora aún, se crea el aforo y la reserva

                                // Se crea el aforo
                                $fechaHoraFinal = $this->calcularFechaHoraFinal($recurso["duracion"], $fechaHoraInicial);
                                $aforoInsertado = ConexionDB::insertarAforo($recurso["id"], $fecha, $fechaHoraFinal->format('Y-m-d'), $hora, $fechaHoraFinal->format('H:i:s'));

                                // Se recupera
                                $aforo = ConexionDB::obtenerAforosPorIdrecursoFechaHora($recurso["id"], $fecha, $hora);

                                if ($aforo !== null) {
                                    if (count($aforo) === 1) {
                                        $aforo = $aforo[0];
                                        // Se crea la reserva
                                        $reserva = ConexionDB::insertarReserva($aforo["id"], $_SESSION["user_id"], $recurso["id"]);
                                        if ($reserva === 1) {
                                            // Se aumenta el aforo
                                            $aforoAct = $aforo["aforo_actual"];
                                            $aforoAct++;
                                            $aumentarAforo = ConexionDB::aumentarAforoActual($aforo["id"], $aforoAct);
                                        } else {
                                            $this->fallosReservar .= "Error al crear la reserva en la base de datos: ". $reserva;
                                        }
                                    } else {
                                        $this->fallosReservar .= "Error al obtener el aforo creado para el recurso. ";
                                    }
                                } else {
                                    $this->fallosReservar .= "Error al realizar la consulta de obtener el aforo creado para el recurso. ";
                                }
                            } else {
                                // El aforo existe, comprobar que no esté lleno
                                $aforo = $aforo[0];
                                $aforoMax = intval($recurso["aforo_maximo"]);
                                $aforoAct = intval($aforo["aforo_actual"]);

                                if ($aforoAct < $aforoMax) {
                                    // Hay hueco, se reserva y se aumenta el aforo
                                    $reserva = ConexionDB::insertarReserva($aforo["id"], $_SESSION["user_id"], $recurso["id"]);
                                    if ($reserva === 1) {
                                        $aforoAct++;
                                        $aumentarAforo = ConexionDB::aumentarAforoActual($aforo["id"], $aforoAct);
                                    } else {
                                        $this->fallosReservar .= "Error al crear la reserva en la base de datos: ". $reserva;
                                    }
                                } else {
                                    // No hay hueco, no se puede reservar
                                    $this->fallosReservar .= "Lo sentimos, el aforo del recurso está completo para esa hora y día. ";
                                }
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


    public function imprimirRecursos()
    {

        if ($this->fallosRecursos != "") {
            echo "<p><span> No se han podido obtener los recursos: " . $this->fallosRecursos . "</span></p>";
        } else {
            echo '<table><thead><tr>';
            echo '<th>Nombre</th><th>Tipo</th><th>Precio</th><th>Descripción</th><th>Duración (horas)</th>';
            echo '</tr></thead>';
            echo '<tbody>';

            foreach ($this->recursos as $recurso) {
                echo '<tr><td>' . $recurso['nombre'] . '</td>
                <td>' . $recurso['tipo'] . '</td>
                <td>' . $recurso['precio'] . '</td>
                <td>' . $recurso['descripcion'] . '</td>
                <td>' . $recurso['duracion'] . '</td>
                </tr>';
            }

            echo '</tbody>';
            echo '</table>';

        }
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

}


?>