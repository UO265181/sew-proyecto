<?php

require_once 'conexionDB.php';

class RecursosObject
{

    private $recursos;
    private $fallosRecursos = "";



    public function obtenerRecursos()
    {
        $this->recursos = ConexionDB::obtenerRecursos();
        if ($this->recursos === null) {
            $this->fallosRecursos .= "Error al obtener los recursos.";
        } else if (empty($this->recursos)) {
            $this->fallosRecursos .= "No hay ningún recurso disponible. ";
        }
    }



    public function imprimirRecursos()
    {

        if ($this->fallosRecursos != "") {
            echo "<p><span> No se han podido obtener los recursos: " . $this->fallosRecursos . "</span></p>";
        } else {
            echo '<table> <caption> Recursos </caption><thead><tr>';
            echo '<th>Nombre</th><th>Precio</th><th>Disponibilidad</th><th>Duración</th><th>Descripción</th>';
            echo '</tr></thead>';
            echo '<tbody>';

            foreach ($this->recursos as $recurso) {
                echo '<tr><td>' . $recurso['nombre'] . '</td>
                <td>' . $recurso['precio'] . '€' .'</td>
                <td>' . str_replace(';', ', ', $recurso['horas']) .'</td>
                <td>' . $recurso['duracion'] . ' horas' .'</td>
                <td>' . $recurso['descripcion'] .   '</td>
                </tr>';
            }

            echo '</tbody>';
            echo '</table>';

        }
    }


}


?>