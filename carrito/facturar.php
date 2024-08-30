<?php
    session_start();
    include("../config/db/db.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['usuario'])) {
        $total = 0;
        $detalles = '';

        $sql = "SELECT c.cantidad, p.cantidad_disponible
            FROM carrito c
            JOIN productos p ON c.id_producto = p.id
            WHERE c.id_usuario = " . $_SESSION["usuario_id"];
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            if ($row['cantidad'] > $row['cantidad_disponible']) {
                echo "Error, no hay suficientes existencias de '" . $row['nombre'] . "' (Pediste '" . $row['cantidad'] . "' y hay '" . $row['cantidad_disponible'] . "')";
                exit;
            }
        }

        $sql = "SELECT p.nombre, c.cantidad, p.precio, p.cantidad_disponible, p.id
            FROM carrito c
            JOIN productos p ON c.id_producto = p.id
            WHERE c.id_usuario = " . $_SESSION["usuario_id"];

        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $sql = "UPDATE productos SET cantidad_disponible = cantidad_disponible - " . $row['cantidad'] . " WHERE id=" . $row['id'];
            if ($conn->query($sql) === TRUE) {
                $detalles = $detalles . $row['nombre'] . ' (' . $row['cantidad'] . ') x ' . $row['precio'] . ' = ' . floatval($row['precio']) * floatval($row['cantidad']) . '<br>';
                $total = $total + floatval($row['precio']) * floatval($row['cantidad']);
            }
            else {
                echo 'Error: ' . $conn->error;
                exit;
            }
        }

        $sql = "INSERT INTO facturas (total, tarjeta, direccion, detalles, id_usuario)
            VALUES(" . $total . ", " . $_POST['tarjeta'] . ", '" . $_POST['direccion'] . "', '" . $detalles . "', " . $_SESSION["usuario_id"] . ")";
        
        if ($conn->query($sql) === TRUE) {
            $sql = "DELETE FROM carrito WHERE id_usuario = " . $_SESSION["usuario_id"];
            if ($conn->query($sql) === TRUE) {
                echo 'ok';
            }
            else {
                echo 'Error: ' . $conn->error;
                exit;
            }
        }
        else {
            echo 'Error: ' . $conn->error;
            exit;
        }
    }
?>