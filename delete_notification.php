<?php
// Establish database connection
$conn = new mysqli("localhost", "syftware_amis", "amis2024/..", "syftware_lddt");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if notification ID is provided
if (isset($_POST['id'])) {
    // Sanitize input to prevent SQL injection
    $notificationId = $conn->real_escape_string($_POST['id']);

    // Prepare SQL statement to delete notification
    $sql = "DELETE FROM notifications WHERE id = '$notificationId'";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo 'success'; // Return success if deletion is successful
    } else {
        echo 'error'; // Return error if deletion fails
    }
} else {
    echo 'error'; // Return error if notification ID is not provided
}

// Close database connection
$conn->close();
?>
