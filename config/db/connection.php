<?php
function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "123456c";
    $dbname = "proyecto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
    }

    return $conn;
}
?>