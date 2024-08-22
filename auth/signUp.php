<?php

function  registerUser($conn, $email, $password, $fullname, $username){
  $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users1 (usuario, clave, nombre, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss" , $username, $hash, $fullname, $email);
    $stmt->execute();
    $stmt->close();
    return ["status" => "success", "message" => "User registered successfully"];
}