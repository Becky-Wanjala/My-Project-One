<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Loanees List</title>
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

        .edit-button,
        .delete-button {
            margin-right: 5px;
        }

        .user-record {
            margin-bottom: 10px;
        }

        .edit-form {
            display: none;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">LDDT | Bank Admin Panel</h1>
        
        <!-- Loanees List -->
        <div class="mt-5">
            <h2>Loanees List</h2>

            <div class="card">
                <div class="card-body">
                    <!-- Display loanees list here -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID Number</th>
                                    <th>Full Name</th>
                                    <th>Amount in Default</th>
                                    <th>Date of Default</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Actions</th>
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

                                // Fetch loanees from the loanees table
                                $sql = "SELECT * FROM loanees";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['id']}</td>";
                                        echo "<td>{$row['id_number']}</td>";
                                        echo "<td>{$row['full_name']}</td>";
                                        echo "<td>{$row['amount_in_default']}</td>";
                                        echo "<td>{$row['date_of_default']}</td>";
                                        echo "<td>{$row['gender']}</td>";
                                        echo "<td>{$row['loan_status']}</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-primary edit-button' data-id='{$row['id']}'>Edit</button>";
                                        echo "<button class='btn btn-danger delete-button' data-id='{$row['id']}'>Delete</button>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No loanees found</td></tr>";
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
        // Edit button functionality
        $(document).on('click', '.edit-button', function() {
            var id = $(this).data('id');
            var row = $(this).closest('tr');
            var fullName = row.find('td:eq(1)').text();
            var amount = row.find('td:eq(2)').text();
            var date = row.find('td:eq(3)').text();
            var gender = row.find('td:eq(4)').text();

            // Hide the row
            row.hide();

            // Show the edit form
            var editForm = `
                <tr class="edit-form">
                    <form id="editForm" data-id="${id}">
                        <td><input type="text" class="form-control" name="full_name" value="${fullName}"></td>
                        <td><input type="text" class="form-control" name="amount_in_default" value="${amount}"></td>
                        <td><input type="date" class="form-control" name="date_of_default" value="${date}"></td>
                        <td><input type="text" class="form-control" name="gender" value="${gender}"></td>
                        <td colspan="2"><button type="submit" class="btn btn-primary">Save</button></td>
                    </form>
                </tr>
            `;

            row.after(editForm);
        });

        // Edit form submission
        $(document).on('submit', '#editForm', function(e) {
            e.preventDefault(); // Prevent the default form submission
            
            var id = $(this).data('id');
            var formData = $(this).serialize();

            // Send AJAX request to update the record
            $.ajax({
                type: 'POST',
                url: 'update.php', // URL to the PHP script that handles the update operation
                data: formData + '&id=' + id,
                success: function(response){
                    alert(response); // Display response from the server
                    location.reload(); // Reload the page to reflect the changes
                }
            });
        });

        // Delete button functionality
        $(document).on('click', '.delete-button', function() {
            var id = $(this).data('id');
            var confirmation = confirm('Are you sure you want to delete this loanees record?');
            if (confirmation) {
                $.ajax({
                    type: 'POST',
                    url: 'delete.php',
                    data: {delete_id: id},
                    success: function(response) {
                        alert(response);
                        location.reload(); // Reload the page after successful deletion
                    }
                });
            }
        });
    </script>
</body>
</html>
