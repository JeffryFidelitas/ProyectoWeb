<?php
    session_start();
    include("../config/db/db.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['usuario'])) {
        $sql = "SELECT cantidad_disponible FROM productos WHERE id=" . $_POST['id'];
        $result = mysqli_query($conn, $sql);
        $disponible = $result->fetch_assoc()['cantidad_disponible'];
        if ($disponible >= $_POST['cantidad']) {
            $sql = "INSERT INTO carrito (cantidad, id_producto, id_usuario) VALUES (" . $_POST['cantidad'] . ", " . $_POST['id'] . ", " . $_SESSION["usuario_id"]. ")";
            if ($conn->query($sql) === TRUE) {
                echo 'ok';
            }
            else {
                echo 'Error: ' . $conn->error;
            }
        }
        else {
            echo 'Error: No hay suficientes kilos de producto (Hay ' . $disponible . 'kg disponibles)';
        }
    }
?>