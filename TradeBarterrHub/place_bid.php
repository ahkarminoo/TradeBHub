<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];


$auctionId =$_POST['auction_id'] ?? $_GET['auction_id'] ?? '';

if (empty($auctionId)) {
    echo "Auction ID is required.";
    exit;
}


try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM auctions WHERE auction_id = ?");
    $stmt->execute([$auctionId]);
    $exists = $stmt->fetchColumn();
} catch (PDOException $e) {
    error_log("Error in query execution: " . $e->getMessage());
    exit('Query execution error.');
}



if (!$exists) {
    echo "Auction with ID $auctionId does not exist.";
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bid_item_name = $_POST['bid_item_name'] ?? '';
    $bid_item_description = $_POST['bid_item_description'] ?? '';


    // Validate input
    if (empty($bid_item_name)) {
        echo "Please provide bid item name, description, and auction ID.";
        exit();
    }
    if (empty($bid_item_description)){
        echo "Please provide item description";
        exit();
    }
    if (empty($auctionId)){
        echo "Please provide auction ID";
        exit();
    }

    if (!isset($_FILES['image_url']) || $_FILES['image_url']['error'] !== UPLOAD_ERR_OK) {
        if ($_FILES['image_url']['error'] === UPLOAD_ERR_NO_FILE) {
            echo "No file uploaded.";
        } else {
            echo "There was an upload error. Please try again.";
        }
        exit();
    }


 
    $upload_dir = 'C:/xampp/htdocs/TradeBarterHub/uploads/';

    if (!is_dir($upload_dir) && !mkdir($upload_dir, 0777, true)) {
        echo "Failed to create upload directory.";
        exit();
    }


    $filename = uniqid() . '-' . basename($_FILES['image_url']['name']);
    $target_file = $upload_dir . $filename;

    if (!move_uploaded_file($_FILES['image_url']['tmp_name'], $target_file)) {
        echo "Failed to upload image.";
        exit();
    }


    // Insert bid into the database
    $stmt = $pdo->prepare("INSERT INTO bids (auction_id, bidder_id, bid_item_name, bid_item_description, image_url) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt->execute([$auctionId, $user_id, $bid_item_name, $bid_item_description, $target_file])) {
        echo "An error occurred while placing your bid.";
        exit();
    }

    echo "Bid placed successfully!";
    header("Location: dashboard.php");
} else {
    echo "Invalid request method.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid on Item - TradeBarterHub</title>
    <link rel="stylesheet" href="place_bid.css">
</head>
<body>
  <header class="bid-header">
    <h1>TradeBarterHub</h1>
    <nav class="header-nav">
        <ul>
            
            <li><a href="dashboard.html">Dashboard</a></li>
            <li><a href="index.html">Logout</a></li> <!-- Assuming you have a logout.php script -->
            <li><a href="create-auction.html">Create Auction</a></li>
            <li><a href="view-auction.html">View My Auctions</a></li>
        </ul>
    </nav>
</header>
    <div class="bidding-container">
        <h1>Complete Your Bid
        </h1>
        <h2>
          (Put Your Item Info to Complete the Bid!)
        </h2>
        <form action="place_bid.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="auction_id" value="<?php echo htmlspecialchars($auctionId); ?>">
            <label for="bid_item_name">Bid Item Name:</label><br>
            <input type="text" id="bid_item_name" name="bid_item_name" required><br>
            <label for="bid_item_description">Bid Item Description:</label><br>
            <textarea id="bid_item_description" name="bid_item_description" required></textarea><br>

            <label for="image_url">Item Image:</label><br>
            <input type="file" id="image_url" name="image_url" accept="image/*" onchange="previewImage(event)" required><br>
    
            <img id="preview" src="" alt="Selected Image"><br>
            <button type="submit">Place Bid</button>
        </form>
        <script>
            function previewImage(event) {
                var input = event.target;
                var preview = document.getElementById('preview');
        
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
        
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                    };
        
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </div>
</body>
</html>
