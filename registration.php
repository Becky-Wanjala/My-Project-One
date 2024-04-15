<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Register loanees</title>
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
        <h1 class="mt-5">Bank Admin Panel</h1>
        
        <!-- Register Defaulters Form -->
        <div class="card mt-5">
            <div class="card-body">
                <h2>Register Defaulters</h2>
                <form id="registerForm" action="add_loanee.php" method="POST">
                    <div class="form-group">
                        <label for="id_number">ID Number:</label>
                        <input type="text" class="form-control" id="id_number" name="id_number" required>
                        <div id="idError" class="error-message"></div>
                        <div id="idSuccess" class="success-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Full Name:</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="amount_in_default">Amount in Default:</label>
                        <input type="text" class="form-control" id="amount_in_default" name="amount_in_default" required>
                    </div>
                    <div class="form-group">
                        <label for="date_of_default">Date of Default:</label>
                        <input type="date" class="form-control" id="date_of_default" name="date_of_default" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="loan_status">Loan Status:</label>
                        <select class="form-control" id="loan_status" name="loan_status">
                            <option value="defaulted">Defaulted</option>
                            <option value="cleared">Cleared</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
            <a href="dashboard.php">Back to Dashboard</a>
        </div>
        
        

    <!-- Bootstrap JS (Optional, if you need JavaScript functionality) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Validate ID number input
        $('#id_number').on('input', function() {
            var idInput = $(this).val();
            var idError = $('#idError');
            var idSuccess = $('#idSuccess');

            if (idInput.length !== 8 || isNaN(idInput)) {
                idError.text('ID number must be 8 digits and numeric.');
                idSuccess.text('');
            } else {
                idError.text('');
                // Check if ID exists in the database
                $.ajax({
                    url: 'check_id.php',
                    method: 'POST',
                    data: {id_number: idInput},
                    success: function(response) {
                        if (response === 'exists') {
                            // Display SweetAlert for duplicate entry
                            swal({
                                title: 'Error',
                                text: 'ID number already exists.',
                                icon: 'error',
                                button: 'OK'
                            });
                            idSuccess.text('');
                        } else {
                            idSuccess.text('ID number is valid.');
                        }
                    }
                });
            }
        });

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
        });
    </script>
</body>
</html>
