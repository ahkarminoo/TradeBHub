<?php
// Include the database connection file
include('db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $item_id = $_POST['item_id'];

    // Check which field is being updated and retrieve the new value
    if (isset($_POST['new_title'])) {
        $new_value = $_POST['new_title'];
        $column = 'title';
    } elseif (isset($_POST['new_description'])) {
        $new_value = $_POST['new_description'];
        $column = 'description';
    } elseif (isset($_POST['new_image_url'])) {
        $new_value = $_POST['new_image_url'];
        $column = 'image_url';
    }

    // Update the specified field in the database
    $sql = "UPDATE items SET $column = '$new_value' WHERE item_id = $item_id";

    if (mysqli_query($con, $sql)) {
        echo ucfirst($column) . " updated successfully.";
    } else {
        echo "Error updating " . $column . ": " . mysqli_error($con);
    }
}

// Close the database connection
mysqli_close($con);
?>
