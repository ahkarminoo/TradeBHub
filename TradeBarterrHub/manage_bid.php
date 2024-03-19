<?php
// Include the database connection file
include('db.php');

// Check if bid ID is provided in the URL
if (isset($_GET['id'])) {
    $bid_id = $_GET['id'];

    // Query to retrieve bid details
    $sql = "SELECT * FROM bids WHERE bid_id = $bid_id";
    $result = mysqli_query($con, $sql);

    // Check if bid exists
    if (mysqli_num_rows($result) == 1) {
        // Fetch bid details
        $bid = mysqli_fetch_assoc($result);

        // Display bid details and provide options for managing the item name, description, and image URL
        echo "<h2>Manage Bid</h2>";
        echo "<p>Bid ID: " . $bid['bid_id'] . "</p>";
        echo "<p>Auction ID: " . $bid['auction_id'] . "</p>";
        echo "<p>Bidder ID: " . $bid['bidder_id'] . "</p>";

        // Form for editing item name
        echo "<h3>Edit Item Name</h3>";
        echo "<form action='edit_bid.php' method='post'>";
        echo "<input type='hidden' name='bid_id' value='" . $bid['bid_id'] . "'>";
        echo "<label for='new_item_name'>New Item Name:</label>";
        echo "<input type='text' name='new_item_name' id='new_item_name' placeholder='New Item Name'>";
        echo "<button type='submit'>Update Item Name</button>";
        echo "</form>";

        // Form for editing item description
        echo "<h3>Edit Item Description</h3>";
        echo "<form action='edit_bid.php' method='post'>";
        echo "<input type='hidden' name='bid_id' value='" . $bid['bid_id'] . "'>";
        echo "<label for='new_item_description'>New Item Description:</label>";
        echo "<input type='text' name='new_item_description' id='new_item_description' placeholder='New Item Description'>";
        echo "<button type='submit'>Update Item Description</button>";
        echo "</form>";

        // Form for editing image URL
        echo "<h3>Edit Image URL</h3>";
        echo "<form action='edit_bid.php' method='post'>";
        echo "<input type='hidden' name='bid_id' value='" . $bid['bid_id'] . "'>";
        echo "<label for='new_image_url'>New Image URL:</label>";
        echo "<input type='url' name='new_image_url' id='new_image_url' placeholder='New Image URL'>";
        echo "<button type='submit'>Update Image URL</button>";
        echo "</form>";

    } else {
        echo "Bid not found.";
    }
} else {
    echo "Bid ID not provided.";
}

// Close the database connection
mysqli_close($con);
?>
