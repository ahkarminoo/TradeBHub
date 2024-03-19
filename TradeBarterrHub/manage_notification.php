<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Notification</title>
</head>
<body>

<?php
// Include the database connection file
include('db.php');

// Check if notification ID is provided in the URL
if (isset($_GET['id'])) {
    $notification_id = $_GET['id'];

    // Query to retrieve notification details
    $sql = "SELECT * FROM notifications WHERE notification_id = $notification_id";
    $result = mysqli_query($con, $sql);

    // Check if notification exists
    if (mysqli_num_rows($result) == 1) {
        // Fetch notification details
        $notification = mysqli_fetch_assoc($result);

        // Display notification details and provide options for CRUD operations
        echo "<h2>Manage Notification</h2>";
        echo "<p>Notification ID: " . $notification['notification_id'] . "</p>";
        echo "<p>Message: " . $notification['message'] . "</p>";

        // Form for editing message
        echo "<h3>Edit Message</h3>";
        echo "<form action='edit_notification.php' method='post'>";
        echo "<input type='hidden' name='notification_id' value='" . $notification['notification_id'] . "'>";
        echo "<label for='new_message'>New Message:</label>";
        echo "<input type='text' name='new_message' id='new_message' placeholder='New Message'>";
        echo "<button type='submit'>Update Message</button>";
        echo "</form>";

    } else {
        echo "Notification not found.";
    }
} else {
    echo "Notification ID not provided.";
}

// Close the database connection
mysqli_close($con);
?>

</body>
</html>
