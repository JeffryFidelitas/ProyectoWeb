<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrgánicoCR - Registro</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/estilos.css" rel="stylesheet" type="text/css" />
    <style>
       
    </style>
</head>
<body>
    <?php
    session_start(); 

    if (isset($_SESSION['message'])) {
        echo "<p class='message'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']); 
    }
    ?>

    <header>
        <h1>Orgánico CR</h1>
        <nav>
            <ul>
                <li><a href="./">Inicio</a></li>
                <li><a href="nosotros">Nosotros</a></li>
                <li><a href="productos">Productos</a></li>
                <li><a href="servicios">Servicios</a></li>
                <li><a href="nosotros#contacto">Contacto</a></li>
            </ul>
            <div class="nav-buttons">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a class="btn btn-outline-light" href="logout.php">Cerrar Sesión</a>
                <?php else: ?>
                    <a class="btn btn-outline-light" href="ingresar.php">Iniciar Sesión</a>
                    <a class="btn btn-light" href="registro.php">Registrarte</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Registro en Orgánico CR</h1>
                <form action="procesar_registro.php" method="POST">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" id="email" name="email" class="form-control" required />
                        <label class="form-label" for="email">Correo Electrónico</label>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" id="password" name="password" class="form-control" required />
                        <label class="form-label" for="password">Contraseña</label>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="name" name="name" class="form-control" required />
                        <label class="form-label" for="name">Nombre Completo</label>
                    </div>


                    <div data-mdb-input-init class="form-outline mb-4">
                        <label for="role" class="form-label">Selecciona tu rol</label>
                        <select id="role" name="role" class="form-control" required>
                            <option value="user">Comprador</option>
                            <option value="productor">Productor</option>
                        </select>
                    </div>

                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Registrarse</button>

                    <div class="text-center">
                        <p>¿Ya tienes una cuenta? <a href="login/ingresar.php">Iniciar Sesión</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
</body>
</html>
