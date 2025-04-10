<!DOCTYPE html>
<html>
<head>
    <title>GrowSync</title>
    <meta charset="UTF-8">
    <link href="css/estilos.css" rel="stylesheet" type="text/css"/>
</head>
<body style="background-color: #F5EEDC; background-size: cover;">

   

    <header>
        <h1>Vivero La Reina</h1>
        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="index_category">Nosotros</a></li>
                <li><a href="productos">Productos</a></li>
                <li><a href="servicios">Servicios</a></li>
                <li><a href="nosotros#contacto">Contacto</a></li>              
            </ul>

            <div class="nav-buttons">
                <?php if ($isLoggedIn): ?>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <a class="btn btn-outline-light" href="administrador/admin_dashboard.php">Admin Dashboard</a>
                    <?php endif; ?>
                    <a class="btn btn-outline-light mx-2" href="perfil">Perfil</a>
                    <a class="btn btn-outline-light" href="logout.php">Cerrar Sesión</a>
                <?php else: ?>
                    <a class="btn btn-outline-light" href="ingresar.php">Iniciar Sesión</a>
                    <a class="btn btn-light" href="index_category.php">Registrarte</a>
                    <?php endif; ?>
            </div>
        </nav>
    </header>

    <main>
        <section class="nosotros" style="background: url('images/150.jpg') fixed; background-size: cover;">
            <h2>Bienvenidos a nuestro vivero</h2>
        </section>
        <section id="catalogo" style="background: url('images/15.jpg')">
            <h2 style="text-align: left;">Noticias</h2>
            <div class="service-container">
                <div class="service-box">
                    <img src="./images/102.jpg" alt="Salud">
                    <h3>Plantas ornamentales</h3>
                    <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque</p> 
                </div>
                <div class="service-box">
                    <img src="./images/103.jpg" alt="Medio Ambiente">
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
            <h3 style="color: transparent;">Rich</h3>
        </section>
    </main>

    <footer> 
        &copy; 2024 Vivero la Reina S.A. Todos los derechos reservados. 
    </footer>

</body>
</html>
