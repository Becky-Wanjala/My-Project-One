<?php
// Database connection
$conn = new mysqli("localhost", "syftware_amis", "amis2024/..", "syftware_lddt");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID number and geolocation from form submission
$id_number = $_POST['id_number'];
$user_location = $_POST['user_location'];

// Initialize response object
$response = array();

// Query the database to check if the ID exists and loan status
$sql = "SELECT * FROM loanees WHERE id_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User found, check loan status
    $row = $result->fetch_assoc();
    if ($row['loan_status'] == 'defaulted' || $row['loan_status'] == 'pending') {
        // If defaulted or pending loan exists
        $response['exists'] = true;
        $response['loan_status'] = true;

        // Send notification to the database
        $message = "A Loanee with ID number $id_number is planning to relocate. Location: $user_location. Please take action.";
        $sql_insert_notification = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $stmt_insert_notification = $conn->prepare($sql_insert_notification);
        $stmt_insert_notification->bind_param("is", $row['id'], $message);
        if ($stmt_insert_notification->execute()) {
            // Notification sent successfully
            $response['notification_sent'] = true;
        } else {
            // Error sending notification
            $response['notification_sent'] = false;
            $response['error_message'] = "Error sending notification: " . $conn->error;
        }
        $stmt_insert_notification->close();
    } else {
        // No defaulted or pending loan found
        $response['exists'] = true;
        $response['loan_status'] = false;

        // Send notification to the database with a different message
        $message = "Loan status for ID number $id_number has been cleared or has no pending or defaulted loan. Location: $user_location.";
        $sql_insert_notification = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $stmt_insert_notification = $conn->prepare($sql_insert_notification);
        $stmt_insert_notification->bind_param("is", $row['id'], $message);
        if ($stmt_insert_notification->execute()) {
            // Notification sent successfully
            $response['notification_sent'] = true;
        } else {
            // Error sending notification
            $response['notification_sent'] = false;
            $response['error_message'] = "Error sending notification: " . $conn->error;
        }
        $stmt_insert_notification->close();
    }
} else {
    // No user found with the entered ID
    $response['exists'] = false;

    // Send notification to the database with a different message
    $message = "Loan status for ID number $id_number has not been listed or has no pending or defaulted loan. Location: $user_location.";
    $sql_insert_notification = "INSERT INTO notifications (message) VALUES (?)";
    $stmt_insert_notification = $conn->prepare($sql_insert_notification);
    $stmt_insert_notification->bind_param("s", $message);
    if ($stmt_insert_notification->execute()) {
        // Notification sent successfully
        $response['notification_sent'] = true;
    } else {
        // Error sending notification
        $response['notification_sent'] = false;
        $response['error_message'] = "Error sending notification: " . $conn->error;
    }
    $stmt_insert_notification->close();
}

// Close statement and connection
$stmt->close();
$conn->close();

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
