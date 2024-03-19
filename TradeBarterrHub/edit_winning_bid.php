<?php
// Include the database connection file
include('db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $auction_id = $_POST['auction_id'];
    $new_winning_bid_id = $_POST['new_winning_bid_id'];

    // Update winning_bid_id in the database
    $sql = "UPDATE auctions SET winning_bid_id = '$new_winning_bid_id' WHERE auction_id = $auction_id";

    if (mysqli_query($con, $sql)) {
        echo "Winning Bid ID updated successfully.";
    } else {
        echo "Error updating Winning Bid ID: " . mysqli_error($con);
    }
}

// Close the database connection
mysqli_close($con);
?>
