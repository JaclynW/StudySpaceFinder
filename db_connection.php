<?php
$servername = "localhost";  // the server where the database is hosted
$username = "team_3";  // the username to log into the database
$password = "zf7vf2z0";  // the password to log into the database
$dbname = "team_3";  // the name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
?>
