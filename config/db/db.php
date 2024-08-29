<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = ""; //Cambien esto segun sus contraseñas
$database = "organicocr";

$conn = new mysqli($servername, $username, $password, $database, 3307); //Cambien el puerto según lo que use su compu

// Verificar la conexión y que no salga en pantalla 
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    header("Location: error_page.php");
    exit();
}

