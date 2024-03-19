<?php
require 'db.php';

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!empty($username) && !empty($email) && !empty($password)) {
   
    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $result = $stmt->fetch();
    $count = $result['count'];

    if ($count > 0) {
        echo "Username '$username' is already taken. Please choose a different username.";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);


        header("Location: index.html");
        exit();
    }
} else {
    echo "Please fill all fields!";
}
?>
