<?php
// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the ID is provided
    if (isset($_POST['id'])) {
        // Establish database connection
        $conn = new mysqli("localhost", "syftware_amis", "amis2024/..", "syftware_lddt");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the update statement
        $stmt = $conn->prepare("UPDATE users SET full_name=?, amount_in_default=?, date_of_default=?, gender=? WHERE id=?");
        $stmt->bind_param("ssssi", $fullName, $amount, $date, $gender, $id);

        // Set parameters from the POST data
        $id = $_POST['id'];
        $fullName = $_POST['full_name'];
        $amount = $_POST['amount_in_default'];
        $date = $_POST['date_of_default'];
        $gender = $_POST['gender'];

        // Execute the update statement
        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the statement and the connection
        $stmt->close();
        $conn->close();
    } else {
        echo "ID not provided";
    }
} else {
    echo "Invalid request";
}
?>
