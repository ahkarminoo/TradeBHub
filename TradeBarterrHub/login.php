<?php
require 'db.php';
session_start();
 
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
 
if (!empty($username) && !empty($password)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
 
    if ($user && password_verify($password, $user['password'])) {
        // Login successful, set session variables
        $_SESSION['user_id'] = $user['user_id'];
        // Redirect to the dashboard or another page
        header("Location: dashboard.php");
        exit();
    } else {
        // Redirect back with an error message
        header("Location: index.html?error=invalidcredentials");
        exit();
    }
    
} else {
    echo "Please fill all fields!";
}
?>