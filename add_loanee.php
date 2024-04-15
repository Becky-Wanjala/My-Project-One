<?php
// Database connection
$conn = new mysqli("localhost", "syftware_amis", "amis2024/..", "syftware_lddt");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user details from form submission
$id_number = $_POST['id_number'];
$full_name = $_POST['full_name'];
$amount_in_default = $_POST['amount_in_default'];
$date_of_default = $_POST['date_of_default'];
$gender = $_POST['gender'];
$loan_status = $_POST['loan_status'];

// Insert user details into the database
$sql = "INSERT INTO loanees (id_number, full_name, amount_in_default, date_of_default, gender, loan_status) VALUES ('$id_number', '$full_name', '$amount_in_default', '$date_of_default', '$gender', '$loan_status')";
if ($conn->query($sql) === TRUE) {
    // Success message for SweetAlert
    echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
    echo "<script>
            window.onload = function() {
                swal({
                    title: 'Success',
                    text: 'Record added successfully.',
                    icon: 'success',
                    button: 'OK',
                }).then(function() {
                    window.location.href = 'Loanee_list.php';
                });
            };
          </script>";
} else {
    // Error message for SweetAlert
    echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
    echo "<script>
            window.onload = function() {
                swal({
                    title: 'Error',
                    text: 'An error occurred. Please try again later.',
                    icon: 'error',
                    button: 'OK',
                }).then(function() {
                    window.location.href = 'admin.php';
                });
            };
          </script>";
}

$conn->close();
?>
