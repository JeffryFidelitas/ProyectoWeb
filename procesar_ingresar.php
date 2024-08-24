<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");
echo "DB included<br>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<br>";
    $usuario = $_POST["usuario"] ?? '';
    $clave = $_POST["clave"] ?? '';
    echo "User: $usuario<br>";

    if (empty($usuario) || empty($clave)) {
        die("error");
    }

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $usuario);
    echo "<br>";

    $stmt->execute();
    echo "<br>";

    $result = $stmt->get_result();
    echo "<br>";

    if ($result->num_rows > 0) {
        echo "<br>";
        $row = $result->fetch_assoc();
        if (password_verify($clave, $row["password"])) {
            echo "verified<br>";
            session_start();
            $_SESSION["usuario"] = $usuario;
            $_SESSION["role"] = $row["role"];
            echo "Session iniciada <br>";
        } else {
            echo "Contrasena incorrecta<br>";
        }
    } else {
        echo "No existe el usuario<br>";
    }

    $stmt->close();
    $conn->close();
}
?>
