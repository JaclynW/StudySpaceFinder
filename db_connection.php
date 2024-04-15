<?php
$servername = "localhost";  // the server where the database is hosted
$username = "your_username";  // the username to log into the database
$password = "your_password";  // the password to log into the database
$dbname = "your_dbname";  // the name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
?>
