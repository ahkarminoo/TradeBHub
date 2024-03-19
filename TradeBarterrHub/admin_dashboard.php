<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>

    
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand text-uppercase  " href="#">TradeBarterHub</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
 
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.html">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Others
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="faq">FAQ</a></li>
              <li><a class="dropdown-item" href="#">Notifications <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
              </svg></a></li>
              <li><hr class="dropdown-divider"></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<div class="container mt-5">
    <!-- Auctions Table -->
    <div id="auctions" class="row mt-4 mb-4">
        <div class="col-12">
            <h2>Auctions</h2>
            <div class="table-responsive">
                <?php
               
                include('db.php');

                // Query to retrieve all auctions
                $sql = "SELECT * FROM auctions";
                $result = mysqli_query($con, $sql);

                // Check if there are any auctions
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>
                    <tr>
                    <th>Auction ID</th>
                    <th>Item ID</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Winning Bid ID</th>
                    <th>Image URL</th>
                    <th>Action</th>
                    </tr>";

     
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['auction_id'] . "</td>";
                        echo "<td>" . $row['item_id'] . "</td>";
                        echo "<td>" . $row['start_time'] . "</td>";
                        echo "<td>" . $row['end_time'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['winning_bid_id'] . "</td>";
                        echo "<td>" . $row['image_url'] . "</td>";
                        echo "<td><a href='manage_auction.php?id=" . $row['auction_id'] . "'>Manage</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No auctions found.";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bids Table -->
    <div id="bids" class="row mt-4 mb-4">
            <div class="col-12">
                <h2>Bids</h2>
                <div class="table-responsive">
                    <?php
                    // Query to retrieve all bids
                    $sql = "SELECT * FROM bids";
                    $result = mysqli_query($con, $sql);

  
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table>
                        <tr>
                        <th>Bid ID</th>
                        <th>Auction ID</th>
                        <th>Bidder ID</th>
                        <th>Item Name</th>
                        <th>Item Description</th>
                        <th>Image URL</th>
                        <th>Action</th>
                        </tr>";

           
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['bid_id'] . "</td>";
                            echo "<td>" . $row['auction_id'] . "</td>";
                            echo "<td>" . $row['bidder_id'] . "</td>";
                            echo "<td>" . $row['bid_item_name'] . "</td>";
                            echo "<td>" . $row['bid_item_description'] . "</td>";
                            echo "<td>" . $row['image_url'] . "</td>";
                            echo "<td><a href='manage_bid.php?id=" . $row['bid_id'] . "'>Manage</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No bids found.";
                    }

                    mysqli_close($con);
                    ?>
                </div>
            </div>
    </div>

<!-- Users Table -->
    <div id="users" class="row mt-4 mb-4">
        <div class="col-12">
            <h2>Users</h2>
            <div class="table-responsive">
                <?php
           
                include('db.php');

                // Query to retrieve all users
                $sql = "SELECT * FROM users";
                $result = mysqli_query($con, $sql);

 
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>
                    <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Action</th>
                    </tr>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td><a href='manage_user.php?id=" . $row['user_id'] . "'>Manage</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No users found.";
                }

                // Close the database connection
                mysqli_close($con);
                ?>
            </div>
        </div>
    </div>


    <div id="items" class="row mt-4 mb-4">
        <div class="col-12">
            <h2>Items</h2>
            <div class="table-responsive">
                <?php
 
                include('db.php');

                $sql = "SELECT * FROM items";
                $result = mysqli_query($con, $sql);

     
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>
                    <tr>
                    <th>Item ID</th>
                    <th>User ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Image URL</th>
                    <th>Action</th>
                    </tr>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['item_id'] . "</td>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td>" . $row['image_url'] . "</td>";
                        echo "<td><a href='manage_item.php?id=" . $row['item_id'] . "'>Manage</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No items found.";
                }

                mysqli_close($con);
                ?>
            </div>
        </div>
    </div>

    <!-- Notifications Table -->
    <div id="notifications">
        <h2>Notifications</h2>
        <div class="table-responsive">
            <?php
  
            include('db.php');


            $sql = "SELECT * FROM notifications";
            $result = mysqli_query($con, $sql);


            if ($result && mysqli_num_rows($result) > 0) {
                echo "<table>
                <tr>
                <th>Notification ID</th>
                <th>User ID</th>
                <th>Message</th>
                <th>Read Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                </tr>";


                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['notification_id'] . "</td>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>" . $row['read_status'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>" . $row['updated_at'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No notifications found.";
            }

   
            mysqli_close($con);
            ?>
        </div>
    </div>
</div>

</body>
</html>
