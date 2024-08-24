<!DOCTYPE html>
<html>
<head>
    <title>OrgánicoCR</title>
    <meta charset="UTF-8">
    <link href="css/estilos.css" rel="stylesheet" type="text/css"/>
</head>
<body style="background-color: #F5EEDC; background-size: cover;">

    <?php
    session_start(); 
    $isLoggedIn = isset($_SESSION['usuario']);
    ?>

    <header>
        <h1>Orgánico CR</h1>
        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="nosotros">Nosotros</a></li>
                <li><a href="productos">Productos</a></li>
                <li><a href="servicios">Servicios</a></li>
                <li><a href="nosotros#contacto">Contacto</a></li>
            </ul>

            <div class="nav-buttons">
                <?php if ($isLoggedIn): ?>
                    <a class="btn btn-outline-light" href="logout.php">Cerrar Sesión</a>
                <?php else: ?>
                    <a class="btn btn-outline-light" href="ingresar.php">Iniciar Sesión</a>
                    <a class="btn btn-light" href="registro.php">Registrarte</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main>
        <section>
            <h2>Iniciar sesion</h2>
            <form method="post" action="procesar_ingresar.php">
                <label>Usuario:</label>
                <input type="text" name="usuario">
                <br>
                <label>Clave:</label>
                <input type="password" name="clave">
                <br>
                <button type="submit">Ingresar</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Biblioteca Aserrí. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
