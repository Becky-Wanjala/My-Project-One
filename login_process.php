<?php
// login_process.php

// Database connection (replace with your actual database credentials)
$host = "localhost";
$dbname = "syftware_lddt";
$username = "syftware_amis";
$password = "amis2024/..";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get user input
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate user input (you can add more validation if needed)

    // Check if the user exists in the database
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the password (assuming the stored password is SHA1 hashed)
        if (sha1($password) === $user['password']) {
            // Successful login
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php"); // Redirect to dashboard.php
            exit;
        } else {
            // Incorrect password
            echo "<script>
                    alert('Incorrect username or password. Please try again.');
                    window.location.href = 'login.php';
                  </script>";
            exit;
        }
    } else {
        // User not found
        echo "<script>
                alert('User not found. Please check your username.');
                window.location.href = 'login.php';
              </script>";
        exit;
    }
} else {
    // Invalid input
    echo "<script>
            alert('Invalid input. Please fill in both username and password.');
            window.location.href = 'login.php';
          </script>";
    exit;
}
?>
