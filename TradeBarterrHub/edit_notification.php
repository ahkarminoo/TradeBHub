<?php
// Include the database connection file
include('db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $notification_id = $_POST['notification_id'];

    // Check which field is being updated and retrieve the new value
    if (isset($_POST['new_message'])) {
        $new_value = $_POST['new_message'];
        $column = 'message';
    }

    // Update the specified field in the database
    $sql = "UPDATE notifications SET $column = '$new_value' WHERE notification_id = $notification_id";

    if (mysqli_query($con, $sql)) {
        echo ucfirst($column) . " updated successfully.";
    } else {
        echo "Error updating " . $column . ": " . mysqli_error($con);
    }
}

// Close the database connection
mysqli_close($con);
?>
