<?php

require_once 'conexionDB.php';

class Recursos
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
            echo '<table><thead><tr>';
            echo '<th>Nombre</th><th>Tipo</th><th>Precio</th><th>Descripción</th><th>Duración</th>';
            echo '</tr></thead>';
            echo '<tbody>';

            foreach ($this->recursos as $recurso) {
                echo '<tr><td>' . $recurso['nombre'] . '</td>
                <td>' . $recurso['tipo'] . '</td>
                <td>' . $recurso['precio'] . '€' .'</td>
                <td>' . $recurso['descripcion'] .  ' horas' . '</td>
                <td>' . $recurso['duracion'] . '</td>
                </tr>';
            }

            echo '</tbody>';
            echo '</table>';

        }
    }


}


?>