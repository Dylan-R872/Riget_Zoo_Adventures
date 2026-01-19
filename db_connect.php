<?php


// Database credentials
$servername = "localhost";  
$username   = "root";       
$password   = "";           
$dbname     = "rza_db"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Stop script and show error if connection fails
    die("Database connection failed: " . $conn->connect_error);
}

// Set character set to avoid encoding issues
$conn->set_charset("utf8mb4");
?>
