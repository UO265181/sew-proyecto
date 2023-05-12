<?php
require_once 'conexionDB.php';
require_once 'validacion.php';

class Reservas
{

    private $reservas;
    private $fallosReservas = "";




    public function obtenerReservas()
    {
        $this->reservas = ConexionDB::obtenerReservasPorIdusuario($_SESSION["user_id"]);
        if ($this->reservas === null) {
            $this->fallosReservas .= "Error al obtener las reservas.";
        } else if (empty($this->reservas)) {
            $this->fallosReservas .= "Aún no has realizado ninguna reserva. ";
        }
    }
    



    public function imprimirReservas()
    {

        if ($this->fallosReservas != "") {
            echo "<p><span> No se han podido obtener las reservas: " . $this->fallosReservas . "</span></p>";
        } else {
            echo '<table><thead><tr>';
            echo '<th>Reserva</th><th>Nombre</th><th>Precio</th><th>Fecha</th><th>Hora</th>';
            echo '</tr></thead>';
            echo '<tbody>';

            foreach ($this->reservas as $reserva) {
                $recurso = ConexionDB::obtenerRecursosPorId($reserva["id_recurso"]);
                $recurso = $recurso[0];
                $aforo = ConexionDB::obtenerAforosPorId($reserva["id_aforo"]);
                $aforo = $aforo[0];

                echo '<tr><td>' . $reserva['id'] . '</td>
                <td>' . $recurso['nombre'] . '</td>
                <td>' . $recurso['precio'] . '</td>
                <td>' . $aforo['fecha_inicio'] . '</td>
                <td>' . $aforo['hora_inicio'] . '</td>
                </tr>';
            }

            echo '</tbody>';
            echo '</table>';

        }
    }



}

?>