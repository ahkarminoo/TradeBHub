<?php
// Include the database connection file
include('db.php');

// Check if auction ID is provided in the URL
if (isset($_GET['id'])) {
    $auction_id = $_GET['id'];

    // Query to retrieve auction details
    $sql = "SELECT * FROM auctions WHERE auction_id = $auction_id";
    $result = mysqli_query($con, $sql);

    // Check if auction exists
    if (mysqli_num_rows($result) == 1) {
        // Fetch auction details
        $auction = mysqli_fetch_assoc($result);

        // Display auction details and provide options for CRUD operations
        echo "<h2>Manage Auction</h2>";
        echo "<p>Auction ID: " . $auction['auction_id'] . "</p>";
        echo "<p>Item ID: " . $auction['item_id'] . "</p>";
        
        // Form for editing end_time
        echo "<h3>Edit End Time</h3>";
        echo "<form action='edit_end_time.php' method='post'>";
        echo "<input type='hidden' name='auction_id' value='" . $auction['auction_id'] . "'>";
        echo "<label for='new_end_time'>New End Time:</label>";
        echo "<input type='datetime-local' name='new_end_time' id='new_end_time' required>";
        echo "<button type='submit'>Update End Time</button>";
        echo "</form>";

        // Form for editing winning_bid_id
        echo "<h3>Edit Winning Bid ID</h3>";
        echo "<form action='edit_winning_bid.php' method='post'>";
        echo "<input type='hidden' name='auction_id' value='" . $auction['auction_id'] . "'>";
        echo "<label for='new_winning_bid_id'>New Winning Bid ID:</label>";
        echo "<input type='text' name='new_winning_bid_id' id='new_winning_bid_id' placeholder='New Winning Bid ID'>";
        echo "<button type='submit'>Update Winning Bid</button>";
        echo "</form>";

        // Form for editing image URL
        echo "<h3>Edit Image URL</h3>";
        echo "<form action='edit_image_url.php' method='post'>";
        echo "<input type='hidden' name='auction_id' value='" . $auction['auction_id'] . "'>";
        echo "<label for='new_image_url'>New Image URL:</label>";
        echo "<input type='url' name='new_image_url' id='new_image_url' placeholder='New Image URL'>";
        echo "<button type='submit'>Update Image URL</button>";
        echo "</form>";
        
    } else {
        echo "Auction not found.";
    }
} else {
    echo "Auction ID not provided.";
}

// Close the database connection
mysqli_close($con);
?>
