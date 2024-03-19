<?php
$status = $_GET['status'] ?? '';

if ($status == 'success') {
    echo '<p>Winning bid has been selected. The auction is now marked as not active.</p>';
    echo '<a href="dashboard.php">Back to Auctions</a>';
} else {
    // Handle error or invalid access
    echo '<p>An error occurred. Please try again.</p>';
}
