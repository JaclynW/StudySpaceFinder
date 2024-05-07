<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Study Spot Finder - Login</title>
   <link rel="icon" href="assets/icon.png" type="image/png">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <nav id="navbar">
       <div id="logo"><a href="index.html">Study Spot Finder</a> > Login</div>
   </nav>

   <div class="section" id="registration-section">
       <div class="loginContent">
           <h1>Login</h1>
           <p>Create an account to find and save your study spots.</p>

           <form id="registration-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
               <label for="username">Username</label><br />
               <input type="text" id="Username" name="username" required><br><br>
               <label for="password">Password</label><br />
               <input type="password" id="password" name="password" required><br /><br>
               <button class="loginButton" type="submit">Login</button>
           </form><br><br>

           <p>If you don't have an account, you can easily register one!</p>
           <button class="loginButton" onclick="window.location.href='register.php';">Register</button>
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
// Database credentials 
$servername = "localhost";
$username = "team_3";
$password = "zf7vf2z0"; 
$dbname = "team_3"; 

// Error reporting
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

// Create 'Users' table if it doesn't exist
$usersTableSql = "CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    user_password VARCHAR(255) NOT NULL, 
    type_status VARCHAR(50) 
)";

if (!$conn->query($usersTableSql)) {
    echo "Error creating table: " . $conn->error;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement for security
    $stmt = $conn->prepare("SELECT user_id, type_status FROM Users WHERE username = ? AND user_password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $username;
        $_SESSION['type_status'] = $user['type_status'];

        // Redirect based on type
        if ($user['type_status'] == 'Admin') {
            header("Location: adminDashboard.php");
        } else {
            header("Location: collaboratorDashboard.php");
        }
    } else {
        $errorMessage = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
