<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Origin: *'); 

require 'config/db/connection.php'; 
require 'auth/signUp.php';

$conn = connectDB();


$input = file_get_contents('php://input');
$data = json_decode($input, true);


if (!isset($data['email']) || !isset($data['password']) || !isset($data['fullname']) || !isset($data['username']))  {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$email = $conn->real_escape_string($data['email']);
$password = $conn->real_escape_string($data['password']);
$fullname = $conn->real_escape_string($data['fullname']);
$username = $conn->real_escape_string($data['username']);

$response = registerUser($conn, $email, $password, $fullname, $username);

if ($response['status'] === 'success') {
    echo json_encode(["status" => "success", "message" => "User registered successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => $response['message']]);
}
$conn->close();
?>



