<?php
// This file contains your database connection details.
// It's good practice to keep these separate from your main logic.

$servername = "localhost"; // Usually 'localhost' for XAMPP
$username = "root";        // Default XAMPP MySQL username
$password = "";            // Default XAMPP MySQL password (empty)
$dbname = "cambric_school"; // The database name you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character set to UTF-8 for proper handling of various characters
$conn->set_charset("utf8");

?>
