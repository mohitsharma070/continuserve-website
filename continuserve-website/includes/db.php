<?php
// Database credentials
$host = "localhost";
$dbname = "tekstrafin_db";
$username = "root"; // default XAMPP MySQL user
$password = "";     // default XAMPP MySQL password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // For testing
?>
