<?php
// Iniciar la sesión solo si no ha sido iniciada previamente
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
    exit();
}

// Consulta para obtener todos los productos
$sql_productos = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.cantidad_disponible, p.foto, u.name AS productor 
                  FROM productos p 
                  JOIN usuarios u ON p.id_productor = u.id
                  WHERE p.cantidad_disponible > 1";

$result = $conn->query($sql_productos);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Orgánico CR</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
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
                        <a class="nav-link" href="../index.php" style="color: white;">Inicio</a>
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

<div class="container mt-5">
    <h2 class="text-center">Productos del Mercado Orgánico</h2>
    <p class="text-center">Nuestros productos son de agricultores costarricenses comprometidos con la producción sostenible y orgánica. Descubre la variedad de productos frescos y saludables que ofrecemos.</p>
    <a href="../carrito" id="carrito">🛒 Carrito</a>
    <div class="row" id="productos">
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4"> <!-- Separación entre tarjetas -->
            <div class="card shadow-sm">
                <!-- Cargar imagen como base64 -->
                <img src="<?php echo $row['foto']; ?>" class="card-img-top" alt="<?php echo $row['nombre']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                    <p class="card-text">Proveedor: <?php echo $row['productor']; ?></p>
                    <p class="card-text"><?php echo $row['descripcion']; ?></p>
                    <p class="card-text">Precio por kg: ₡<?php echo $row['precio']; ?></p>
                    <div class="d-flex flex-column">
                        <form class="mb-3">
                            <input type="hidden" name="id_producto" value="<?php echo $row['id']; ?>">
                            <div class="input-group mb-2">
                                <input type="number" name="cantidad" min="0.5" step="0.5" class="form-control" placeholder="Cantidad (kg)" required>
                            </div>
                        </form>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-block" onclick="agregar_al_carrito(this)">Agregar al carrito</button>
                        </div>
                        <?php if ($isLoggedIn && ($usuarioRol == 'admin' || $usuarioRol == 'productor')): ?>
                        <div class="btn-group mt-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#editarProductoModal" data-id="<?php echo $row['id']; ?>" data-nombre="<?php echo $row['nombre']; ?>" data-descripcion="<?php echo $row['descripcion']; ?>" data-precio="<?php echo $row['precio']; ?>" data-cantidad="<?php echo $row['cantidad_disponible']; ?>"><i class="fa fa-pencil"></i> Editar</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#eliminarProductoModal" data-id="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i> Eliminar</button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Botón flotante para agregar productos -->
    <?php if ($isLoggedIn && ($usuarioRol == 'admin' || $usuarioRol == 'productor')): ?>
    <button type="button" class="btn btn-success btn-floating" data-toggle="modal" data-target="#agregarProductoModal">
        <i class="fa fa-plus"></i>
    </button>
    <?php endif; ?>

    <!-- Modal para agregar producto -->
    <div class="modal fade" id="agregarProductoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarProductoModalLabel">Agregar Producto</h5>
                </div>
                <div class="modal-body">
                    <form id="formAgregarProducto" enctype="multipart/form-data">
                        <input type="hidden" name="accion" value="crear">
                        <div class="form-group">
                            <label for="nombreProducto">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombreProducto" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcionProducto">Descripción</label>
                            <textarea class="form-control" id="descripcionProducto" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="precioProducto">Precio</label>
                            <input type="number" class="form-control" id="precioProducto" name="precio" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidadProducto">Cantidad Disponible en KILOS</label>
                            <input type="number" class="form-control" id="cantidadProducto" name="cantidad_disponible" step="0.5" required>
                        </div>
                        <div class="form-group">
                            <label for="fotoProducto">Foto del Producto</label>
                            <input type="file" class="form-control-file" id="fotoProducto" name="foto" required>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="disponibleProducto" name="disponible" checked>
                            <label class="form-check-label" for="disponibleProducto">Disponible</label>
                        </div>
                        <button type="submit" class="btn btn-success">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar producto -->
    <div class="modal fade" id="editarProductoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Producto</h5>
                </div>
                <div class="modal-body">
                    <form id="formEditarProducto" enctype="multipart/form-data">
                        <input type="hidden" name="accion" value="actualizar">
                        <input type="hidden" name="id" id="editarIdProducto">
                        <div class="form-group">
                            <label for="editarNombreProducto">Nombre del Producto</label>
                            <input type="text" class="form-control" id="editarNombreProducto" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="editarDescripcionProducto">Descripción</label>
                            <textarea class="form-control" id="editarDescripcionProducto" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editarPrecioProducto">Precio</label>
                            <input type="number" class="form-control" id="editarPrecioProducto" name="precio" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="editarCantidadProducto">Cantidad Disponible en KILOS</label>
                            <input type="number" class="form-control" id="editarCantidadProducto" name="cantidad_disponible" step="0.5" required>
                        </div>
                        <div class="form-group">
                            <label for="editarFotoProducto">Foto del Producto</label>
                            <input type="file" class="form-control-file" id="editarFotoProducto" name="foto">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="editarDisponibleProducto" name="disponible">
                            <label class="form-check-label" for="editarDisponibleProducto">Disponible</label>
                        </div>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para eliminar producto -->
    <div class="modal fade" id="eliminarProductoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Producto</h5>
                </div>
                <div class="modal-body">
                    <form id="formEliminarProducto">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id" id="eliminarIdProducto">
                        <p>¿Estás seguro de que deseas eliminar este producto?</p>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>

<footer> 
        &copy; 2024 Orgánico CR. Todos los derechos reservados. 
</footer>

<script>
    // Cargar datos en el modal de edición
    $('#editarProductoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');
        var descripcion = button.data('descripcion');
        var precio = button.data('precio');
        var cantidad = button.data('cantidad');
        var modal = $(this);
        modal.find('input[name="id"]').val(id);
        modal.find('input[name="nombre"]').val(nombre);
        modal.find('textarea[name="descripcion"]').val(descripcion);
        modal.find('input[name="precio"]').val(precio);
        modal.find('input[name="cantidad_disponible"]').val(cantidad);
    });

    // Cargar datos en el modal de eliminación
    $('#eliminarProductoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        modal.find('input[name="id"]').val(id);
    });

    // Enviar formulario de agregar producto
    $('#formAgregarProducto').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'accionProducto.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert(response);
                location.reload();
            }
        });
    });

    // Enviar formulario de editar producto
    $('#formEditarProducto').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'accionProducto.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert(response);
                location.reload();
            }
        });
    });

    // Enviar formulario de eliminar producto
    $('#formEliminarProducto').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'accionProducto.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                alert(response);
                location.reload();
            }
        });
    });
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
