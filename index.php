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
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a class="btn btn-outline-light" href="index">Admin Dashboard</a>
        <?php endif; ?>
        <a class="btn btn-outline-light" href="logout.php">Cerrar Sesión</a>
    <?php else: ?>
        <a class="btn btn-outline-light" href="ingresar.php">Iniciar Sesión</a>
        <a class="btn btn-light" href="registro.php">Registrarte</a>
    <?php endif; ?>
</div>

        </nav>
    </header>

    <main>
        <section class="nosotros" style="background: url('images/150.jpg') fixed; background-size: cover; background-color: #F5EEDC;">
            <h2>Bienvenidos a nuestra tienda de productos orgánicos</h2>
        </section>
        <section id="catalogo" style="background: url('images/15.jpg') fixed; background-size: cover; background-color: #8abf76;">
            <h2 style="text-align: left;">Importancia de los Productos Orgánicos</h2>
            <div class="service-container">
                <div class="service-box">
                    <img src="./images/157.jpg" alt="Salud">
                    <h3>Salud</h3>
                    <p>Los productos orgánicos se cultivan sin el uso de pesticidas sintéticos y fertilizantes químicos.</p> 
                </div>
                <div class="service-box">
                    <img src="./images/152.png" alt="Medio Ambiente">
                    <h3>Medio Ambiente</h3>
                    <p>La ausencia de pesticidas químicos favorece la biodiversidad permitiendo que una variedad de organismos beneficiosos prosperen.</p>
                </div>
                <div class="service-box">
                    <img src="./images/156.jpg" alt="Economía">
                    <h3>Economía</h3>
                    <p>Comprar productos orgánicos a menudo significa apoyar a los agricultores locales que utilizan prácticas sostenibles.</p>
                </div>
            </div>
        </section>
        <section id="services" style="background: url('images/150.jpg') fixed; background-size: cover; background-color: #8abf76;">
            <h3>Rich</h3>
        </section>
    </main>

    <footer> 
        &copy; 2024 Orgánico CR. Todos los derechos reservados. 
    </footer>

</body>
</html>
