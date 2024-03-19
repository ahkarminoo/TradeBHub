<?php
require 'db.php';
session_start();
 

if (!isset($_SESSION['user_id'])) {

    header("Location: login.html");
    exit();
}
 
$user_id = $_SESSION['user_id'];
 

$stmt = $pdo->prepare("SELECT auctions.*, items.title AS item_title,
                       items.description AS item_description, 
                       items.image_url FROM auctions INNER JOIN items ON auctions.item_id = items.item_id WHERE items.user_id != ? AND auctions.status = 1");
$stmt->execute([$user_id]);
$auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT username, email FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("SELECT username, email FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE user_id = ?");
    $stmt->execute([$new_username, $new_email, $user_id]);


    header("Location: dashboard.php");
    exit();
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TradeBarterHub</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

 </head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand text-uppercase  " href="#">TradeBarterHub</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
 
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.html">Logout</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="create_auction.html">Create Auction</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="view_my_auction.html">View My Auctions</a>
        </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
              </svg>  Profile
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#view-profile-modal">View Profile</a></li>
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#update-profile-modal">Update Profile</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
 
    <!-- View Profile Modal -->
    <div class="modal fade" id="view-profile-modal" tabindex="-1" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="viewProfileModalLabel">View Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="view-username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                <label for="view-username">Username</label>
            </div>
            <div class="form-floating">
                <input type="email" class="form-control" id="view-email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                <label for="view-email">Email address</label>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="update-profile-modal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="update-profile-form" method="POST">
            <div class="form-floating mb-3">
            <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>">
              <label for="update-username">Username</label>
            </div>
            <div class="form-floating">
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>">
              <label for="update-email">Email address</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="update-profile-form" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div id="auctionCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <!-- Carousel Items -->
                    <div class="carousel-item active">
                      <img src="ir_startframe__c5rzvbueg3ee_large.jpg" class="d-block w-100 c-img" alt="...">
                      <div class="carousel-caption top-0 mt-4">
                        <h1 class="display-1 fw-bolder text-uppercase fs-2 mt-5 ">Hello, User <?php echo htmlspecialchars($user['username']); ?>! This is your dashboard.</h1>
                        <p class="fs-5 mt-5">
                        Here are the auctions created by other users:
                        </p>
                      </div>
                    </div>
                </div>
                
            </div>
    </div>

    <div class="container mt-3">
    <div class="row justify-content-center">
        <h2 class="text-center my-5">Auctions</h2>
        <?php if (!empty($auctions)): ?>
            <?php foreach ($auctions as $auction): ?>
                <div class="col-lg-4 mb-4"> <!-- Adjust the column size as needed -->
                    <div class="card h-100"> <!-- Ensure equal height for all cards -->
                        <img src="<?php echo htmlspecialchars($auction['image_url']); ?>" class="card-img-top" width="400" height="200" alt="<?php echo htmlspecialchars($auction['item_title']); ?>">
                        <div class="card-body d-flex flex-column"> <!-- Use flex-column for card body alignment -->
                            <h5 class="card-title"><?php echo htmlspecialchars($auction['item_title']); ?></h5>
                            <p class="card-text">Description: <?php echo htmlspecialchars($auction['item_description']); ?></p>
                            <p class="card-text">Start Time: <?php echo htmlspecialchars($auction['start_time']); ?></p>
                            <p class="card-text">End Time: <?php echo htmlspecialchars($auction['end_time']); ?></p>
                            <a href="place_bid.php?auction_id=<?php echo htmlspecialchars($auction['auction_id']); ?>" class="btn btn-primary mt-auto">Place a Bid</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No auctions found.</p>
        <?php endif; ?>
    </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <footer class="bg-dark mt-5 py-4">
    <div class="container text-light text-end">
      <small class="text-white-50">
        &copy; 2024 TradeBarterHub. All rights reserved
      </small>
    </div>
  </footer>
</body>
</html>
 