<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="author" content="UO265181">
    <meta name="description" content="Información del Concejo de Cabranes">
    <meta name="keywords" content="Cabranes, cultura, turismo">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="index.html">
    <link rel="icon" type="image/svg" href="../multimedia/escudo.svg">
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <link rel="stylesheet" type="text/css" href="../estilo/layout.css">
    <title>Concejo de Cabranes</title>
</head>


<body>

    <header>
        <h1>Concejo de Cabranes</h1>
    </header>

    <nav>
		<h2>Índice</h2>
		<ul>
			<li><a title="Enlace a la página principal" href="../index.html">Inicio</a></li>
			<li><a title="Enlace a Gastronomía" href="../gastronomia.html">Gastronomía</a></li>
			<li><a title="Enlace a Rutas" href="../rutas.html">Rutas</a></li>
			<li><a title="Enlace a Meteorología" href="../meteorologia.html">Meteorología</a></li>
			<li><a title="Enlace a Juego" href="../juego.html">Juego</a></li>
			<li><a title="Enlace a Reservas" href="reservas.php">Reservas</a></li>
		</ul>
	</nav>


    <main>

        <?php

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        require_once 'vista.php';

        $vista = new Vista();
        $vista->recibirPOST();
        $vista->mostrarVista();

        ?>

    </main>


    <footer>
        <address><a href="mailto:UO265181@uniovi.es">Alberto Fernández Gutiérrez</a></address>

    </footer>

</body>




</html>