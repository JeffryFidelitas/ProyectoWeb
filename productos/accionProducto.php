<?php
session_start();

// Verificar si el usuario está autenticado
$isLoggedIn = isset($_SESSION['usuario']);
$usuarioId = $_SESSION['usuario_id'] ?? null; // Aquí obtenemos el id del usuario
$accion = $_POST['accion'] ?? '';

include("../config/db/db.php");

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
        $disponible = isset($_POST['disponible']) ? 1 : 0;
    
        // Manejo de imagen y conversión a base64
        $foto_base64 = '';
        if (!empty($_FILES['foto']['tmp_name'])) {
            $foto_info = getimagesize($_FILES['foto']['tmp_name']);
            $foto_tipo = $foto_info['mime'];
            $foto_contenido = file_get_contents($_FILES['foto']['tmp_name']);
            $foto_base64 = 'data:' . $foto_tipo . ';base64,' . base64_encode($foto_contenido);
        } else {
            die(json_encode(["estado" => "error", "mensaje" => "No se ha proporcionado una imagen."]));
        }
    
        $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad_disponible, foto, disponible, id_productor) 
                VALUES ('$nombre', '$descripcion', '$precio', '$cantidad_disponible', '$foto_base64', '$disponible', '$_SESSION[usuario_id]')";
    
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["estado" => "éxito", "mensaje" => "Producto agregado correctamente."]);
        } else {
            echo json_encode(["estado" => "error", "mensaje" => "Error al agregar el producto: " . $conn->error]);
        }
        break;
    

        case 'actualizar':
            $id_producto = $_POST['id'];
            $nombre = $_POST['nombre'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $precio = $_POST['precio'] ?? null;
            $cantidad_disponible = $_POST['cantidad_disponible'] ?? null;
            $disponible = isset($_POST['disponible']) ? 1 : 0;
    
            // Verificar si se subió una nueva imagen
            if (!empty($_FILES['foto']['name'])) {
                $foto = file_get_contents($_FILES['foto']['tmp_name']);
                $foto_base64 = base64_encode($foto);
    
                $sql = "UPDATE productos SET 
                        nombre = IFNULL('$nombre', nombre), 
                        descripcion = IFNULL('$descripcion', descripcion), 
                        precio = IFNULL('$precio', precio), 
                        cantidad_disponible = IFNULL('$cantidad_disponible', cantidad_disponible), 
                        disponible = '$disponible',
                        foto = '$foto_base64' 
                        WHERE id = '$id_producto'";
            } else {
                $sql = "UPDATE productos SET 
                        nombre = IFNULL('$nombre', nombre), 
                        descripcion = IFNULL('$descripcion', descripcion), 
                        precio = IFNULL('$precio', precio), 
                        cantidad_disponible = IFNULL('$cantidad_disponible', cantidad_disponible), 
                        disponible = '$disponible'
                        WHERE id = '$id_producto'";
            }
    
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["estado" => "éxito", "mensaje" => "Producto actualizado correctamente."]);
            } else {
                echo json_encode(["estado" => "error", "mensaje" => "Error al actualizar el producto: " . $conn->error]);
            }
            break;
    
        case 'eliminar':
            $id_producto = $_POST['id'];
    
            $sql = "DELETE FROM productos WHERE id = '$id_producto'";
    
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["estado" => "éxito", "mensaje" => "Producto eliminado correctamente."]);
            } else {
                echo json_encode(["estado" => "error", "mensaje" => "Error al eliminar el producto: " . $conn->error]);
            }
            break;
    
        default:
            echo json_encode(["estado" => "error", "mensaje" => "Acción no válida."]);
            break;
    }
    
    $conn->close();
