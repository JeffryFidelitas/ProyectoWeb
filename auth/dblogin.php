<?php
function authenticateUser($conn, $email, $password) {
   
    $stmt = $conn->prepare("SELECT clave FROM users1 WHERE email = ?");
    
   
    $stmt->bind_param("s", $email);
    
   
    $stmt->execute();
    
   
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['clave'];

     
        if (password_verify($password, $stored_password)) {
            return ["status" => "success", "message" => "Login successful"];
        } else {
            return ["status" => "error", "message" => "Invalid credentials"];
        }
    } else {
        return ["status" => "error", "message" => "User not found"];
    }
}
?>