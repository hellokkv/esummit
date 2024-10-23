<?php
// Database credentials
$servername = "localhost";  // Or your actual server name
$username = "root";  // Your database username
$password = "";  // Your database password
$dbname = "esummit";  // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
