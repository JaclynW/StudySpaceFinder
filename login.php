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

<!DOCTYPE html>
<html lang="en">
<?php if (isset($errorMessage)) : ?>
    <div class="error-message"><?= $errorMessage ?></div>
<?php endif; ?>

</body>
</html>
