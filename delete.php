<?php
// Establish database connection
$conn = new mysqli("localhost", "syftware_amis", "amis2024/..", "syftware_lddt");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $sql = "DELETE FROM loanees WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
