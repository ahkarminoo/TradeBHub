<?php
// Include the database connection file
include('db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $auction_id = $_POST['auction_id'];
    $new_end_time = $_POST['new_end_time'];

    // Update end_time in the database
    $sql = "UPDATE auctions SET end_time = '$new_end_time' WHERE auction_id = $auction_id";

    if (mysqli_query($con, $sql)) {
        echo "End Time updated successfully.";
    } else {
        echo "Error updating End Time: " . mysqli_error($con);
    }
}

// Close the database connection
mysqli_close($con);
?>
