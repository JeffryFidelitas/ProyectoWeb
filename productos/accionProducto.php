<?php
session_start();
include("../config/db/db.php");

$isLoggedIn = isset($_SESSION['usuario_id']);
$usuarioId = $_SESSION['usuario_id'] ?? null;
$accion = $_POST['accion'] ?? '';

if (!$isLoggedIn || !$usuarioId) {
    $_SESSION['mensaje'] = 'Debes iniciar sesión o crear una cuenta para acceder a esta página.';
    header('Location: ../ingresar.php');
    exit();
}

switch ($accion) {
    case 'crear':
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $cantidad_disponible = $_POST['cantidad_disponible'];
        $activo = isset($_POST['activo']) ? 1 : 0;

        if (!empty($_FILES['foto']['tmp_name'])) {
            $foto_info = getimagesize($_FILES['foto']['tmp_name']);
            $foto_tipo = $foto_info['mime'];
            $foto_contenido = file_get_contents($_FILES['foto']['tmp_name']);
            $foto_base64 = 'data:' . $foto_tipo . ';base64,' . base64_encode($foto_contenido);
        } else {
            $_SESSION['mensaje'] = "No se ha proporcionado una imagen.";
        }

        $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad_disponible, foto, activo, id_productor) 
                VALUES ('$nombre', '$descripcion', '$precio', '$cantidad_disponible', '$foto_base64', '$activo', '$usuarioId')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['mensaje'] = "Producto agregado correctamente.";
        } else {
            $_SESSION['mensaje'] = "Error al agregar el producto: " . $conn->error;
        }
        break;

    case 'actualizar':
        $id_producto = $_POST['id'];
        $nombre = $_POST['nombre'] ?? null;
        $descripcion = $_POST['descripcion'] ?? null;
        $precio = $_POST['precio'] ?? null;
        $cantidad_disponible = $_POST['cantidad_disponible'] ?? null;
        $activo = isset($_POST['activo']) ? 1 : 0;

        if (!empty($_FILES['foto']['tmp_name'])) {
            $foto_info = getimagesize($_FILES['foto']['tmp_name']);
            $foto_tipo = $foto_info['mime'];
            $foto_contenido = file_get_contents($_FILES['foto']['tmp_name']);
            $foto_base64 = 'data:' . $foto_tipo . ';base64,' . base64_encode($foto_contenido);

            $sql = "UPDATE productos SET 
                    nombre = IFNULL('$nombre', nombre), 
                    descripcion = IFNULL('$descripcion', descripcion), 
                    precio = IFNULL('$precio', precio), 
                    cantidad_disponible = IFNULL('$cantidad_disponible', cantidad_disponible), 
                    activo = '$activo',
                    foto = '$foto_base64' 
                    WHERE id = '$id_producto'";
        } else {
            $sql = "UPDATE productos SET 
                    nombre = IFNULL('$nombre', nombre), 
                    descripcion = IFNULL('$descripcion', descripcion), 
                    precio = IFNULL('$precio', precio), 
                    cantidad_disponible = IFNULL('$cantidad_disponible', cantidad_disponible), 
                    activo = '$activo'
                    WHERE id = '$id_producto'";
        }

        if ($conn->query($sql) === TRUE) {
            $_SESSION['mensaje'] = "Producto actualizado correctamente.";
        } else {
            $_SESSION['mensaje'] = "Error al actualizar el producto: " . $conn->error;
        }
        break;

    case 'eliminar':
        $id_producto = $_POST['id'];

        $sql = "DELETE FROM productos WHERE id = '$id_producto'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['mensaje'] = "Producto eliminado correctamente.";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar el producto: " . $conn->error;
        }
        break;

    default:
        $_SESSION['mensaje'] = "Acción no válida.";
        break;
}

$conn->close();
exit();
