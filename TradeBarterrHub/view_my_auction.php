<?php
require 'db.php';
session_start();

$user_id = $_SESSION['user_id'] ?? '';

if (!empty($user_id)) {
    $stmt = $pdo->prepare("SELECT items.title AS item_title, items.description AS item_description, auctions.auction_id, auctions.status AS auction_status, auctions.winning_bid_id, auctions.image_url AS auction_image_url, bids.bid_id, users.username AS bidder_username, bids.bid_item_name, bids.bid_item_description, bids.image_url 
                           FROM auctions 
                           LEFT JOIN bids ON auctions.auction_id = bids.auction_id
                           JOIN items ON auctions.item_id = items.item_id 
                           LEFT JOIN users ON bids.bidder_id = users.user_id
                           WHERE items.user_id = ? 
                           ORDER BY auctions.auction_id, bids.bid_id");
    $stmt->execute([$user_id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $auctions = [];
    foreach ($results as $row) {
        $auction_id = $row['auction_id'];
        if (!isset($auctions[$auction_id])) {
            // Convert the local file path to a web-accessible URL for the auction image
            $auctionImagePath = $row['auction_image_url'];
            
            $auctions[$auction_id] = [
                'auction_id' => $row['auction_id'],
                'item_title' => $row['item_title'],
                'item_description' => $row['item_description'],
                'auction_image_url' => $row['image_url'], // Include the image URL for the auction
                'auction_status' => $row['auction_status'],
                'winning_bid_id' => $row['winning_bid_id'], // Include winning bid ID
                'bids' => []
            ];
        }
        
        // For expired auctions, add only the winning bid
        if ($row['auction_status'] == 0 && $row['winning_bid_id'] == $row['bid_id']) {
            $relativePath = str_replace('C:/xampp/htdocs/TradeBarterHub/uploads/', 'http://localhost/TradeBarterHub/uploads/', $row['image_url']);
            $auctions[$auction_id]['bids'][] = [
                'bid_id' => $row['bid_id'],
                'bidder_username' => $row['bidder_username'],
                'bid_item_name' => $row['bid_item_name'],
                'bid_item_description' => $row['bid_item_description'],
                'image_url' => $relativePath,
            ];
        } elseif ($row['auction_status'] == 1) {
            // For active auctions, add all bids
            if ($row['bid_id'] != null) { // Ensure there is a bid to add
                $relativePath = str_replace('C:/xampp/htdocs/TradeBarterHub/uploads/', 'http://localhost/TradeBarterHub/uploads/', $row['image_url']);
                $auctions[$auction_id]['bids'][] = [
                    'bid_id' => $row['bid_id'],
                    'bidder_username' => $row['bidder_username'],
                    'bid_item_name' => $row['bid_item_name'],
                    'bid_item_description' => $row['bid_item_description'],
                    'image_url' => $relativePath,
                ];
            }
        }
    }

    echo json_encode(array_values($auctions));
} else {
    echo "User not logged in";
}
?>
