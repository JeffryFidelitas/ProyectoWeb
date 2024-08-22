<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Origin: *'); 

require 'config/db/connection.php'; 
require 'auth/dblogin.php'; 


session_start();


$conn = connectDB();


$input = file_get_contents('php://input');
$data = json_decode($input, true);


if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$email = $conn->real_escape_string($data['email']);
$password = $conn->real_escape_string($data['password']);


$response = authenticateUser($conn, $email, $password);

if ($response['status'] === 'success') {

    $_SESSION['user_email'] = $email; 
}

echo json_encode($response);

$conn->close();
?>