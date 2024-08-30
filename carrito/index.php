<?php
session_start();
include("../config/db/db.php");

// Verificar si el usuario está autenticado
$isLoggedIn = isset($_SESSION['usuario']);
$usuarioRol = $_SESSION['role'] ?? '';
$accion = $_POST['accion'] ?? '';
$mensaje = $_SESSION['mensaje'] ?? ''; // Obtener mensaje

if (!$isLoggedIn) {
    $_SESSION['mensaje'] = 'Debes iniciar sesión para acceder a esta página.';
    header('Location: ../ingresar.php');
}

$sql = "SELECT c.id, p.nombre, pr.name, c.cantidad, p.precio
FROM carrito c
JOIN productos p ON c.id_producto = p.id
JOIN usuarios pr ON p.id_productor = pr.id
WHERE c.id_usuario = " . $_SESSION["usuario_id"];

$result = $conn->query($sql);
$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Orgánico CR</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./script.js"></script>
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
        <h2 class="text-center">Carrito</h2> 
        <section id="carrito" style="background-color: #8abf76;">
            <div id="carrito-container">
                <?php if ($result->num_rows > 0): ?>
                <table id="carrito-table" class="table">
                    <thead>
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Proveedor</th>
                            <th scope="col">Cantidad (kg)</th>
                            <th scope="col">Precio / Kilo</th>
                            <th scope="col">Precio Total</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <?php $total += floatval($row['precio']) * floatval($row['cantidad']);?>
                        <tr>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['cantidad']; ?></td>
                            <td><?php echo $row['precio']; ?></td>
                            <td><?php echo floatval($row['precio']) * floatval($row['cantidad']); ?></td>
                            <td><button onclick="eliminar(<?php echo $row['id']; ?>)";>🗑 Eliminar</button></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <div id="acciones-carrito">
                    <h1>Total: <span id="total"><?php echo $total; ?></span></h1>
                    <button onclick="limpiar();">Limpiar</button>
                    <button data-toggle="modal" data-target="#facturarModal">Facturar</button>
                </div>
                <?php else: ?>
                <h1>No hay productos en el carrito</h1>
                <?php endif;?>
            </div>
            
        </section>
    </div>

    <div class="modal fade" id="facturarModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span><b>Total: </b><?php echo $total; ?></span><br></h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="direccion">Dirección: </label><br>
                            <textarea name="direccion" id="direccion-facturar" style="width: 100%"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tarjeta">Número de Tarjeta: </label><br>
                            <input type="text" name="tarjeta" id="tarjeta-facturar"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="facturar();">Comprar</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Orgánico CR. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>

    
</body>
</html>
