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

    public function obtenerRecursos()
    {
        $this->recursos = ConexionDB::obtenerRecursos();
        if ($this->recursos === null) {
            $fallosRecursos .= "Error al obtener los recursos.";
        } else if (empty($this->recursos)) {
            $fallosRecursos .= "No hay ningún recurso disponible. ";
        }
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
            echo "<p><span> La identificación no ha sido posible: " . $this->fallosReservar . "</span></p>";
        }
    }

}


?>