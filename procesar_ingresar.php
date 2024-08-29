<?php
session_start();
include("config/db/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"] ?? '';
    $clave = $_POST["clave"] ?? '';

    if (empty($usuario) || empty($clave)) {
        $_SESSION['message'] = "Por favor, ingrese ambos campos.";
        header('Location: ingresar.php');
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($clave, $row["password"])) {
            $_SESSION["usuario"] = $usuario;
            $_SESSION["role"] = $row["role"];
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['message'] = "Contraseña incorrecta.";
            header('Location: ingresar.php');
            exit();
        }
    } else {
        $_SESSION['message'] = "No existe el usuario.";
        header('Location: ingresar.php');
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
