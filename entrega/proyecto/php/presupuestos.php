<?php

require_once 'conexionDB.php';

class Presupuestos
{

    private $recursos;
    private $fallosGenerarPresupuesto = "";


    public function imprimirBotonDeGenerarPresupuesto()
    {
        echo "<form method='POST'>
                <input type='submit' name='generarPresupuesto' value='Generar Presupuesto'>
            </form>";
        if ($this->fallosGenerarPresupuesto != "") {
            echo "<p><span> La reserva no ha sido posible: " . $this->fallosGenerarPresupuesto . "</span></p>";
        }
    }

    private function crearArchivoPresupuesto($reservas)
    {



        $usuario = ConexionDB::obtenerUsuariosPorId($_SESSION["user_id"])[0];
        $acumulado = 0;

        $txtPresupuesto = '';
        $txtPresupuesto .= '-----.-----.-----.-----.-----.'. PHP_EOL;
        $txtPresupuesto .= PHP_EOL;
        $txtPresupuesto .= 'Usuario:'. PHP_EOL;
        $txtPresupuesto .= $usuario["nombre"] . PHP_EOL;
        $txtPresupuesto .= PHP_EOL;
        $txtPresupuesto .= 'Presupuesto:'.PHP_EOL;
        $txtPresupuesto .= '.--__-----.-----__--.'.PHP_EOL;

        foreach ($reservas as $reserva) {
            $recurso = ConexionDB::obtenerRecursosPorId($reserva["id_recurso"]);
            $recurso = $recurso[0];
            $aforo = ConexionDB::obtenerAforosPorId($reserva["id_aforo"]);
            $aforo = $aforo[0];
            $acumulado += $recurso['precio'];

            $txtPresupuesto .= '.--__-----.'.PHP_EOL;
            $txtPresupuesto .= 'Nombre: ' . $recurso['nombre'] .PHP_EOL;
            $txtPresupuesto .= 'Tipo: ' . $recurso['tipo'] .PHP_EOL;
            $txtPresupuesto .= 'Descripción: ' . $recurso['descripcion'] .PHP_EOL;
            $txtPresupuesto .= 'Precio: ' . $recurso['precio'] .PHP_EOL;
            $txtPresupuesto .= 'Duración: ' . $recurso['duracion'] .PHP_EOL;
            $txtPresupuesto .= 'Fecha de inicio: ' . $aforo['fecha_inicio'] .PHP_EOL;
            $txtPresupuesto .= 'Hora de inicio: ' . $aforo['hora_inicio'] .PHP_EOL;
            $txtPresupuesto .= 'Fecha de fin: ' . $aforo['fecha_final'] .PHP_EOL;
            $txtPresupuesto .= 'Hora de fin: ' . $aforo['hora_final'] .PHP_EOL;
            $txtPresupuesto .= '.--__-----.'.PHP_EOL;
        }
        $txtPresupuesto .=  PHP_EOL;
        $txtPresupuesto .= 'Precio total:'.PHP_EOL;
        $txtPresupuesto .= $acumulado .PHP_EOL;
        $txtPresupuesto .= 'Presupuesto generado a las ' . date('H:i:s') . ' del ' . date('Y-m-d') .PHP_EOL;
        $txtPresupuesto .= '.--__-----.-----__--.'.PHP_EOL;
        $txtPresupuesto .= 'UO265181'.PHP_EOL;
        $txtPresupuesto .= '-----.-----.-----.-----.-----.';


        $rutaArchivo = '../../presupuesto.txt';
        file_put_contents($rutaArchivo, $txtPresupuesto);
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="' . basename($rutaArchivo) . '"');
        header('Content-Length: ' . filesize($rutaArchivo));

        ob_clean();
        readfile($rutaArchivo);
        unlink($rutaArchivo);
        exit();
    }



    public function generarPresupuesto()
    {

        if (isset($_SESSION["user_id"])) {

            $reservas = ConexionDB::obtenerReservasPorIdusuario($_SESSION["user_id"]);

            if (count($reservas) > 0) {
                $this->crearArchivoPresupuesto($reservas);
            } else {
                //TODO:
            }






        } else {
            $fallosGenerarPresupuesto .= "No se puede realizar una reserva sin identificarse. ";
        }
    }


}


?>