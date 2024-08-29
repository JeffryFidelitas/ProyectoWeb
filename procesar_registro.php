<?php
session_start(); 
include("config/db/db.php");

$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$role = $_POST['role'];

if (empty($email) || empty($password) || empty($name)) {
    $_SESSION['message'] = "Todos los campos son obligatorios.";
    header("Location: registro.php");
    exit();
}

$sql_check = "SELECT * FROM usuarios WHERE email = '$email'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    $_SESSION['message'] = "El correo electrónico ya está registrado.";
    header("Location: registro.php");
    exit();
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO usuarios (email, password, name, role) VALUES ('$email', '$hashed_password', '$name', '$role')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "Registro exitoso. Puedes iniciar sesión ahora.";
    header("Location: registro.php");
    exit();
} else {
    $_SESSION['message'] = "Error: " . $conn->error;
    header("Location: registro.php");
    exit();
}

$conn->close();
