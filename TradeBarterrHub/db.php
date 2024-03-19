<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "b";
$port = 3307; // Assuming this is the correct port for your MySQL server

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname: " . $e->getMessage());
}
$con = mysqli_connect("localhost", "root", "", "b",3307);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
