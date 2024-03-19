<?php
// Include the database connection file
include('db.php');

// Check if user ID is provided in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Query to retrieve user details
    $sql = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($con, $sql);

    // Check if user exists
    if (mysqli_num_rows($result) == 1) {
        // Fetch user details
        $user = mysqli_fetch_assoc($result);

        // Display user details and provide options for managing the username, email, and password
        echo "<h2>Manage User</h2>";
        echo "<p>User ID: " . $user['user_id'] . "</p>";
        echo "<p>Username: " . $user['username'] . "</p>";
        echo "<p>Email: " . $user['email'] . "</p>";

        // Form for editing username
        echo "<h3>Edit Username</h3>";
        echo "<form action='edit_user.php' method='post'>";
        echo "<input type='hidden' name='user_id' value='" . $user['user_id'] . "'>";
        echo "<label for='new_username'>New Username:</label>";
        echo "<input type='text' name='new_username' id='new_username' placeholder='New Username'>";
        echo "<button type='submit'>Update Username</button>";
        echo "</form>";

        // Form for editing email
        echo "<h3>Edit Email</h3>";
        echo "<form action='edit_user.php' method='post'>";
        echo "<input type='hidden' name='user_id' value='" . $user['user_id'] . "'>";
        echo "<label for='new_email'>New Email:</label>";
        echo "<input type='email' name='new_email' id='new_email' placeholder='New Email'>";
        echo "<button type='submit'>Update Email</button>";
        echo "</form>";

        // Form for editing password
        echo "<h3>Edit Password</h3>";
        echo "<form action='edit_user.php' method='post'>";
        echo "<input type='hidden' name='user_id' value='" . $user['user_id'] . "'>";
        echo "<label for='new_password'>New Password:</label>";
        echo "<input type='password' name='new_password' id='new_password' placeholder='New Password'>";
        echo "<button type='submit'>Update Password</button>";
        echo "</form>";

    } else {
        echo "User not found.";
    }
} else {
    echo "User ID not provided.";
}

// Close the database connection
mysqli_close($con);
?>
