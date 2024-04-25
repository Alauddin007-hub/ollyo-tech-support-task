<?php
// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$database = "inventory";

// Create connection
$connect = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Start session
session_start();

// Set session variables
// $_SESSION['type'] = 'master'; // Replace 'your_value' with the appropriate value
// $_SESSION['user_id'] = 1 ; // Replace 'your_user_id' with the appropriate user ID
?>
