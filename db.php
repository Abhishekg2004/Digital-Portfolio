<?php
// Database configuration
$servername = "sql301.infinityfree.com";  // Usually localhost
$username = "if0_38278867";         // Your MySQL username
$password = "Abhiroyal24";             // Your MySQL password
$dbname = "if0_38278867_portfolio";      // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8");
?>
