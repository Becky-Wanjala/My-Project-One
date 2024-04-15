<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Your custom CSS (if any) -->
    <style>
        /* Add your custom styles here */
        .dashboard-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<?php
// Assuming you have a database connection
$pdo = new PDO("mysql:host=localhost;dbname=syftware_lddt", "syftware_amis", "amis2024/..");

// Execute the query to get the count
$stmt = $pdo->query("SELECT COUNT(*) FROM notifications");
$notificationCount = $stmt->fetchColumn();
?>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div style="background-color: orange; color: white;" class="dashboard-card">
                    <h4>Register Loanee</h4>
                    <p>Add defaulter records</p>
                    <a href="registration.php" class="btn btn-primary">Go to Page</a>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background-color: red; color: white;"class="dashboard-card">
                    <h4>Loanee List</h4>
                    <p>View/Manage defaulter details</p>
                    <a href="Loanee_list.php" class="btn btn-primary">Go to page</a>
                </div>
            </div>
            <div class="col-md-4">
    <div style="background-color: green; color: white;" class="dashboard-card">
        <h4>Notifications (<?php echo $notificationCount; ?>)</h4>
        <p>View/Manage Notifications</p>
        <a href="notifications.php" class="btn btn-primary">Go to Notifications</a>
    </div>
</div>
            <div class="col-md-4">
                <div style="background-color: black; color: white;"class="dashboard-card">
                    <h4>Logout</h4>
                    <p>Logout of the system</p>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
