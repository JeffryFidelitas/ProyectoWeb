<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['name'];
    $correo_electronico = $_POST['email'];
    $mensaje = $_POST['message'];

    $sql = "INSERT INTO contacto (nombre, correo_electronico, mensaje) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $nombre, $correo_electronico, $mensaje);
        
        if ($stmt->execute()) {
            echo "Mensaje enviado con éxito.";
        } else {
            echo "Error al enviar el mensaje: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparacion de la consulta: " . $conn->error;
    }

    $conn->close();
}
?>


