<?php
// Include the database connection file
include('db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $bid_id = $_POST['bid_id'];

    // Check if new item name is provided and update it
    if(isset($_POST['new_item_name'])) {
        $new_item_name = $_POST['new_item_name'];
        $sql = "UPDATE bids SET bid_item_name = '$new_item_name' WHERE bid_id = $bid_id";
        if (mysqli_query($con, $sql)) {
            echo "Item Name updated successfully.";
        } else {
            echo "Error updating Item Name: " . mysqli_error($con);
        }
    }

    // Check if new item description is provided and update it
    if(isset($_POST['new_item_description'])) {
        $new_item_description = $_POST['new_item_description'];
        $sql = "UPDATE bids SET bid_item_description = '$new_item_description' WHERE bid_id = $bid_id";
        if (mysqli_query($con, $sql)) {
            echo "Item Description updated successfully.";
        } else {
            echo "Error updating Item Description: " . mysqli_error($con);
        }
    }

    // Check if new image URL is provided and update it
    if(isset($_POST['new_image_url'])) {
        $new_image_url = $_POST['new_image_url'];
        $sql = "UPDATE bids SET image_url = '$new_image_url' WHERE bid_id = $bid_id";
        if (mysqli_query($con, $sql)) {
            echo "Image URL updated successfully.";
        } else {
            echo "Error updating Image URL: " . mysqli_error($con);
        }
    }
}

// Close the database connection
mysqli_close($con);
?>
