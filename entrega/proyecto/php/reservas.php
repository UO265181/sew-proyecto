<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="author" content="UO265181">
    <meta name="description" content="Información del Concejo de Cabranes">
    <meta name="keywords" content="Cabranes, cultura, turismo">
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
        <div>
            <h2>Índice</h2>
            <ul>
                <li><a title="Enlace a la página principal" target="_self" href="../index.html">Inicio</a></li>
                <li><a title="Enlace a Gastronomía" target="_self" href="../gastronomia.html">Gastronomía</a></li>
                <li><a title="Enlace a Rutas" target="_self" href="../rutas.html">Rutas</a></li>
                <li><a title="Enlace a Meteorología" target="_self" href="../meteorologia.html">Meteorología</a></li>
                <li><a title="Enlace a Juego" target="_self" href="../juego.html">Juego</a></li>
                <li><a title="Enlace a Reservas" target="_self" href="php/reservas.php">Reservas</a></li>
            </ul>
        </div>
    </nav>


    <main>

        <?php


        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Recibo los POST
        require_once 'registrarse.php';
        $registrarse = new Registrarse();
        if (isset($_POST['registrarse'])) {
            $registrarse->registrarUsuario($_POST['nombre'], $_POST["email"], $_POST["password"]);
        }

        
        require_once 'identificarse.php';
        $identificarse = new Identificarse();
        if (isset($_POST['identificarse'])) {
            $identificarse->iniciarSesion($_POST["email"], $_POST["password"]);
        }


        // Usuario no identificado
        if (!isset($_SESSION['user_id'])) {




            echo "<h2>Información</h2>";
            echo "<section>";
            echo "<p>Bienvenido a la página de reservas. Para poder realizar una reserva primero deberás registrarse. Una vez que te hayas registrado podrás identificarte y empezar a resevar tus recursos turísticos de Cabranes favoritos.</p>";


            // Registro
            require_once 'registrarse.php';
            echo "<section>";
            echo "<h2>Registrarse</h2>";
            $registrarse->imprimirFormulario();
            echo "</section>";


            // Ident
            echo "<section>";
            echo "<h2>Identificarse</h2>";
            $identificarse->imprimirFormulario();
            echo "</section>";

            echo "</section>";

        } else {
            // Usuario identificado
            echo "<section>";
            echo "<h2>Información</h2>";

            echo "<p>¡Bienvenido " . $_SESSION["username"] . "! Puedes realizar reservas y ver tu presupuesto más abajo.</p>";
        }




        ?>

    </main>


    <footer>
        <address><a href="mailto:UO265181@uniovi.es">Alberto Fernández Gutiérrez</a></address>

    </footer>

</body>




</html>