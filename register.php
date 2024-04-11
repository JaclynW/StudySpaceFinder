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
    <nav id="navbar">
        <div id="logo"><a href="index.html">Study Spot Finder</a> > Register</div>
    </nav>

    <div class="section" id="registration-section">
        <div class="content">
            <h1>Register</h1>
            <p>Create an account to find and save your study spots.</p>
            <form id="registration-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <label for="username">Username</label><br />
                <input type="text" id="username" name="username" required><br><br>
                <label for="email">Email</label><br />
                <input type="email" id="email" name="email" required><br><br>
                <label for="password">Password</label><br />
                <input type="password" id="password" name="password" required><br /><br>
                <button class="registerButton" type="submit">Register</button>
            </form><br><br>
            <p>If you already have an account, log in here!</p>
            <button class="registerButton" onclick="window.location.href='login.php';">Login</button>
        </div>
    </div>

    <footer>
        <p>
            <a href="contact.html">Contact Us</a> | 
            <a href="sitemap.html">Site Map</a> |
            <a href="about.html">About Us</a>
        </p>
    </footer>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db_connection.php'; // Ensure db_connection.php is set up for database access

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Consider hashing the password

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO Users (username, user_password, email_address) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Registration successful!');</script>";
            header("Location: login.php"); // Redirect to login page
        } else {
            echo "<script>alert('Error during registration.');</script>";
        }
        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
