<?php
    session_start(); 
    $isLoggedIn = isset($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Orgánico CR</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header class="header" style="background-color: #2c5f2c;">
        <nav class="navbar navbar-expand-lg" style="background-color: #2c5f2c;">
            <div class="container-fluid">
                <a class="navbar-brand" href="../" style="color: white;">Orgánico CR</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../" style="color: white;">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../nosotros" style="color: white;">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../productos" style="color: white;">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../servicios" style="color: white;">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../nosotros#contacto" style="color: white;">Contacto</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <?php if ($isLoggedIn): ?>
                            <a class="btn btn-outline-light mx-2" href="../perfil">Perfil</a>
                            <a class="btn btn-light mx-2" href="../logout.php">Cerrar Sesión</a>
                        <?php else: ?>
                            <a class="btn btn-outline-light mx-2" href="../ingresar.php">Iniciar Sesión</a>
                            <a class="btn btn-light mx-2" href="../registro.php">Registrarte</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <div class="container mt-5" style="max-width: 80vmax;">
        <h2 class="text-center">Servicios</h2>
        <p class="text-center">En Orgánico CR ofrecemos multiples servicios para clientes individuales y empresas.</p>     
        <section id="servicios" style="background: url('images/15.jpg')    fixed; background-size: cover;   background-color: #8abf76;">
            <div class="service-container" style="flex-wrap: nowrap;">
                <div class="service-box">
                    <img src="../images/158.jpg" >
                    <h3>Venta a Compañias</h3>
                    <p>Ofrecemos precios competitivos para compañias que desean adquirir una gran cantidad de productos.</p> 
                </div>
                <div class="service-box">
                    <img src="../images/159.jpg" >
                    <h3>Descuentos</h3>
                    <p>Contamos con los mejores descuentos y promociones en la industria.</p>
                </div>
                <div class="service-box">
                    <img src="../images/160.jpg" >
                    <h3>Venta a Individuos</h3>
                    <p>Los clientes individuales también cuentan con la misma gran atención y bajos precios que nos caracterizan</p>
                </div>
            </div>
        </section>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Orgánico CR. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>

    
</body>
</html>
