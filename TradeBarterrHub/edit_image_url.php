<?php
// Include the database connection file
include('db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $auction_id = $_POST['auction_id'];
    $new_image_url = $_POST['new_image_url'];

    // Update image_url in the database
    $sql = "UPDATE auctions SET image_url = '$new_image_url' WHERE auction_id = $auction_id";

    if (mysqli_query($con, $sql)) {
        echo "Image URL updated successfully.";
    } else {
        echo "Error updating Image URL: " . mysqli_error($con);
    }
}

// Close the database connection
mysqli_close($con);
?>
