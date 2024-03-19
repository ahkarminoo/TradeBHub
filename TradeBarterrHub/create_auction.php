<?php
require 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.html");
    exit();
}

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $start_time = $_POST['start_time'] ?? '';
    $end_time = $_POST['end_time'] ?? '';

$upload_dir = "/TradeBarterHub/uploads/"; 
$server_upload_dir = "C:/xampp/htdocs/TradeBarterHub/uploads/"; 

$image_urls = [];

if (!empty($_FILES['upload_photos']['name'][0])) {
    foreach ($_FILES['upload_photos']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['upload_photos']['name'][$key]);
        $target_path = $server_upload_dir . $file_name;

        if (move_uploaded_file($tmp_name, $target_path)) {
            $image_urls[] = 'http://localhost' . $upload_dir . $file_name; 
        } else {
            echo "Failed to upload file: " . $_FILES['upload_photos']['name'][$key];
        }
    }
}

    // Insert new item into the items table
    if (!empty($title) && !empty($description) && !empty($start_time) && !empty($end_time)) {
        $stmt = $pdo->prepare("INSERT INTO items (user_id, title, description, image_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $description, implode(',', $image_urls)]);

        // Retrieve the ID of the inserted item
        $item_id = $pdo->lastInsertId();

        // Insert a new auction into the auctions table
        $stmt = $pdo->prepare("INSERT INTO auctions (item_id, start_time, end_time , image_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$item_id, $start_time, $end_time, implode(',', $image_urls)]);

        echo "Auction created successfully!";
        header("Location: dashboard.php");
    } else {
        echo "Please fill in all required fields (title, description, start time, and end time).";
    }
}
?>
