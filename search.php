<?php
// Establish connection to the database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$zipcode = $_POST['zipcode'];

// Query to select locations from the database
$sql = "SELECT * FROM locations WHERE zipcode = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $zipcode);
$stmt->execute();
$result = $stmt->get_result();

// Store results to a session or send directly to listings page
session_start();
$_SESSION['results'] = $result->fetch_all(MYSQLI_ASSOC);

// Redirect to listings.html (which you might need to change to listings.php to display results)
header("Location: listings.php");
exit();
?>
