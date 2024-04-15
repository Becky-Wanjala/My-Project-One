<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        /* Additional custom styles can be added here */
        body {
            padding: 20px;
            background-color: #333; /* Dark background */
        }

        .container {
            background-color: #fff; /* White box background */
            border-radius: 10px; /* Rounded corners */
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Box shadow */
        }

        .card {
            margin-top: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }

        .print-button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Notifications -->
        <div class="mt-5">
            <h2>Notifications</h2>

            <!-- Live search bar -->
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search by ID number..." />

            <!-- Print button -->
            <button id="printButton" class="btn btn-primary print-button">Print</button>

            <div class="card">
                <div class="card-body" id="notificationList">
                    <!-- Display notifications here -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Action</th> <!-- Added delete action column -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Establish database connection
                                $conn = new mysqli("localhost", "syftware_amis", "amis2024/..", "syftware_lddt");

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Fetch notifications from the database and display
                                $sql = "SELECT * FROM notifications ORDER BY created_at DESC";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr class='notification' data-id='{$row['id']}'>";
                                        echo "<td>{$row['message']}</td>";
                                        echo "<td>{$row['created_at']}</td>";
                                        echo "<td><button class='btn btn-danger delete-button' data-id='{$row['id']}'>Delete</button></td>"; // Added delete button
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No notifications</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="dashboard.php">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional, if you need JavaScript functionality) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Live search functionality
            $('#searchInput').on('input', function() {
                var searchText = $(this).val().toLowerCase();
                $('.notification').each(function() {
                    var message = $(this).text().toLowerCase();
                    if (message.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });

            // Print button functionality
            $('#printButton').on('click', function() {
                window.print();
            });

            // Delete button functionality
            $(document).on('click', '.delete-button', function() {
                var notificationId = $(this).data('id');
                console.log('Notification ID to be deleted:', notificationId); // Log the notification ID
                // Call AJAX to delete the notification with the specified ID
                $.ajax({
                    url: 'delete_notification.php',
                    method: 'POST',
                    data: {id: notificationId},
                    success: function(response) {
                        if (response === 'success') {
                            // Remove the deleted row from the table
                            $('[data-id="' + notificationId + '"]').closest('tr').remove();
                            // Display success message
                            swal({
                                title: 'Success',
                                text: 'Notification deleted successfully.',
                                icon: 'success',
                                button: 'OK'
                            });
                        } else {
                            // Display error message if deletion fails
                            swal({
                                title: 'Error',
                                text: 'Failed to delete notification.',
                                icon: 'error',
                                button: 'OK'
                            });
                        }
                    },
                    error: function() {
                        // Display error message if AJAX request fails
                        swal({
                            title: 'Error',
                            text: 'Failed to delete notification.',
                            icon: 'error',
                            button: 'OK'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
