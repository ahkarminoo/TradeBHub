<?php
require 'db.php'; // Ensure database connection

$auction_id = isset($_POST['auction_id']) ? $_POST['auction_id'] : null;
$winning_bid_id = isset($_POST['winning_bid_id']) ? $_POST['winning_bid_id'] : null;

if ($auction_id !== null && $winning_bid_id !== null) {
    $query = "UPDATE auctions SET status = 0, winning_bid_id = ? WHERE auction_id = ?";
    $stmt = $pdo->prepare($query);

    if ($stmt) {
        $stmt->bindValue(1, $winning_bid_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $auction_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Winning bid updated successfully. Auction closed.";
        } else {
            echo "Error updating winning bid.";
        }
    } else {
        echo "Error preparing statement.";
    }
} else {
    echo "Received auction_id: Not set\nAuction ID: undefined\nWinning Bid ID: " . $winning_bid_id;
}
?>
