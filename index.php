<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan-Defaulters Debt Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional custom styles */
        body {
            background-color: #222;
            color: #fff;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin-top: 50px;
        }
        .navbar {
            background-color: #444 !important;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #fff !important;
        }
        .navbar-toggler {
            border-color: #fff !important;
        }
        .navbar-toggler-icon {
            background-color: #fff;
        }
        /* Logo styles */
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 100px;
            height: 100px;
            overflow: hidden;
        }
        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Navigation bar -->
     <nav class="navbar navbar-expand-lg navbar-dark">
       <div class="container">
            <a class="navbar-brand" href="login.php">Admin Portal</a>
            <center><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button></center>
            <!--<div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                </ul>
            </div>-->
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        <!-- Logo -->
        <div class="logo-container">
            <div class="logo">
                <img src="home.svg" alt="Logo">
            </div>
        </div>
        <h1 class="mt-5">Loan-Defaulters Debt Tracker System</h1>
        <form class="mt-3" id="loan_form">
            <div class="form-group">
                <label for="id_number">Enter Your ID Number for clearance check:</label>
                <input type="text" class="form-control" id="id_number" name="id_number" required>
                <div id="id_error_message" style="color: red;"></div>
            </div>
            <input type="hidden" id="user_location" name="user_location">
            <button type="submit" class="btn btn-primary">Check Status</button>
        </form>
    </div>

    <!-- Bootstrap JS (Optional, if you need JavaScript functionality) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Audio elements -->
    <audio id="warningAudio">
        <source src="warning.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <audio id="successAudio">
        <source src="success.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <!-- JavaScript for geolocation and input validation -->
    <script>
        // Function to get user's geolocation
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        // Function to display user's geolocation
        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var userLocation = latitude + ',' + longitude;
            document.getElementById('user_location').value = userLocation;
        }

        // Function to handle geolocation error
        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    console.log("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    console.log("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    console.log("An unknown error occurred.");
                    break;
            }
        }

        // Call getLocation function when the page loads
        window.onload = function() {
            getLocation();

            // Add event listener to input for validation
            var idNumberInput = document.getElementById('id_number');
            idNumberInput.addEventListener('input', function() {
                validateIDNumber(idNumberInput);
            });
        };

        // Function to validate ID number input
        function validateIDNumber(input) {
            var idNumber = input.value;
            var errorDiv = document.getElementById('id_error_message');
            errorDiv.textContent = '';

            // Check if ID number is numeric and has a size of 8 characters
            if (!/^\d{8}$/.test(idNumber)) {
                errorDiv.textContent = 'ID number must be numeric and have a size of 8 characters.';
                input.setCustomValidity('Invalid ID number');
            } else {
                input.setCustomValidity('');
            }
        }

        // Function to play warning audio
        function playWarningAudio() {
            var warningAudio = document.getElementById('warningAudio');
            warningAudio.play();
        }

        // Function to play success audio
        function playSuccessAudio() {
            var successAudio = document.getElementById('successAudio');
            successAudio.play();
        }

        // Function to handle form submission
        document.getElementById('loan_form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get the ID number and geolocation data
            var idNumber = document.getElementById('id_number').value;
            var userLocation = document.getElementById('user_location').value;

            // Send data to server using AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        if (response.exists && response.loan_status) {
                            // Display warning message using SweetAlert and play warning audio
                            swal({
                                title: 'Warning',
                                text: 'Defaulted or pending loan found for user with ID number ' + idNumber + '.',
                                icon: 'warning',
                                button: 'OK',
                            }).then(function() {
                                window.location.replace('index.php');
                            });
                            playWarningAudio();
                        } else {
                            // Display success message using SweetAlert and play success audio
                            swal({
                                title: 'Success',
                                text: 'The person with ID number ' + idNumber + ' has no pending or defaulted loans.',
                                icon: 'success',
                                button: 'OK',
                            });
                            playSuccessAudio();
                        }
                    } else {
                        // Display error message using SweetAlert
                        swal({
                            title: 'Error',
                            text: 'Error sending request to check loan status.',
                            icon: 'error',
                            button: 'OK',
                        });
                    }
                }
            };
            xhttp.open('POST', 'check_loan.php', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send('id_number=' + encodeURIComponent(idNumber) + '&user_location=' + encodeURIComponent(userLocation));
        });
    </script>
    <footer>
        <center><p>&copy; <span id="year"></span> LDDT. All rights reserved. Developed by Becky Naliaka</p></center>
    </footer>
</body>
</html>
