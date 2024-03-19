<?php

include('db.php');


if (isset($_GET['id'])) {
    $item_id = $_GET['id'];

    // Query to retrieve item details
    $sql = "SELECT * FROM items WHERE item_id = $item_id";
    $result = mysqli_query($con, $sql);

    // Check if item exists
    if (mysqli_num_rows($result) == 1) {
        // Fetch item details
        $item = mysqli_fetch_assoc($result);

        // Display item details and provide options for CRUD operations
        echo "<h2>Manage Item</h2>";
        echo "<p>Item ID: " . $item['item_id'] . "</p>";
        echo "<p>User ID: " . $item['user_id'] . "</p>";
        echo "<p>Title: " . $item['title'] . "</p>";
        echo "<p>Description: " . $item['description'] . "</p>";
        echo "<p>Created At: " . $item['created_at'] . "</p>";
        echo "<p>Image URL: " . $item['image_url'] . "</p>";

        // Form for editing title
        echo "<h3>Edit Title</h3>";
        echo "<form action='edit_item.php' method='post'>";
        echo "<input type='hidden' name='item_id' value='" . $item['item_id'] . "'>";
        echo "<label for='new_title'>New Title:</label>";
        echo "<input type='text' name='new_title' id='new_title' placeholder='New Title'>";
        echo "<button type='submit'>Update Title</button>";
        echo "</form>";

        // Form for editing description
        echo "<h3>Edit Description</h3>";
        echo "<form action='edit_item.php' method='post'>";
        echo "<input type='hidden' name='item_id' value='" . $item['item_id'] . "'>";
        echo "<label for='new_description'>New Description:</label>";
        echo "<input type='text' name='new_description' id='new_description' placeholder='New Description'>";
        echo "<button type='submit'>Update Description</button>";
        echo "</form>";

        // Form for editing image URL
        echo "<h3>Edit Image URL</h3>";
        echo "<form action='edit_item.php' method='post'>";
        echo "<input type='hidden' name='item_id' value='" . $item['item_id'] . "'>";
        echo "<label for='new_image_url'>New Image URL:</label>";
        echo "<input type='url' name='new_image_url' id='new_image_url' placeholder='New Image URL'>";
        echo "<button type='submit'>Update Image URL</button>";
        echo "</form>";

    } else {
        echo "Item not found.";
    }
} else {
    echo "Item ID not provided.";
}

// Close the database connection
mysqli_close($con);
?>
