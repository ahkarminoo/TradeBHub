<?php
$error = $_GET['error'] ?? '';

if ($error == 'auction_inactive') {
    echo '<p>This auction is no longer active and cannot have a winning bid selected.</p>';
} else {
    // Handle other errors or invalid access
    echo '<p>An error occurred. Please try again.</p>';
}

echo '<a href="view_my_auction.html">Back to Auctions</a>';
