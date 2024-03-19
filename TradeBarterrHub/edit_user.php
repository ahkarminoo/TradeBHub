<?php

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST['user_id'];

    if(isset($_POST['new_username'])) {
        $new_username = $_POST['new_username'];
        $sql = "UPDATE users SET username = '$new_username' WHERE user_id = $user_id";
        if (mysqli_query($con, $sql)) {
            echo "Username updated successfully.";
        } else {
            echo "Error updating Username: " . mysqli_error($con);
        }
    }

    if(isset($_POST['new_email'])) {
        $new_email = $_POST['new_email'];
        $sql = "UPDATE users SET email = '$new_email' WHERE user_id = $user_id";
        if (mysqli_query($con, $sql)) {
            echo "Email updated successfully.";
        } else {
            echo "Error updating Email: " . mysqli_error($con);
        }
    }
}

mysqli_close($con);
?>
