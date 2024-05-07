<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Study Spot Finder - Register</title>
   <link rel="icon" href="assets/icon.png" type="image/png">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
      <?php
    // Database credentials (ideally, move these to a separate config file later)
    $servername = "localhost";
    $username = "team_3";
    $password = "zf7vf2z0"; 
    $dbname = "team_3"; 

     // Error reporting for development (remove for production)
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Connect to the database
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $conn->query("CREATE DATABASE IF NOT EXISTS `$dbname`");
        $conn->select_db($dbname);
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // PASSWORD HASHING (Important for security)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

        // Prepared statement 
        $stmt = $conn->prepare("INSERT INTO Users (username, user_password, email_address) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $email); // Bind with hashed password
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $successMessage = "Registration successful!";
        } else {
            $errorMessage = "Error during registration.";
        }

        $stmt->close();
        $conn->close();
    }
   ?>

   <?php if (isset($successMessage)) : ?>
       <div class="success-message"><?= $successMessage ?></div>
   <?php elseif (isset($errorMessage)) : ?>
        <div class="error-message"><?= $errorMessage ?></div> 
   <?php endif; ?> 

</body>
</html>
