<?php
    session_start();
    include("../config/db/db.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['usuario'])) {
        if (isset($_POST['id'])) {
            $sql = "DELETE FROM carrito WHERE id = " . $_POST['id'] . ' AND id_usuario = ' . $_SESSION["usuario_id"];
        }
        else { // No hay id, entonces lo que el usuario quiere es limpiar todo el carrito
            $sql = "DELETE FROM carrito WHERE id_usuario = " . $_SESSION["usuario_id"];
        }
        if ($conn->query($sql) === TRUE) {
            echo 'ok';
        }
        else {
            echo 'Error: ' . $conn->error;
        }
    }
?>