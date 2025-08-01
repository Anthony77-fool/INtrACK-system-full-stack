<?php
$host = "localhost";      // Usually 'localhost'
$dbUser = "root";         // Your DB username
$dbPass = "";             // Your DB password (default empty for XAMPP)
$dbName = "intrack_system"; // Replace with your actual DB name

// Create connection
$conn = new mysqli($host, $dbUser, $dbPass, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>