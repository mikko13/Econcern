<?php
// Database connection parameters
$servername = 'localhost'; // Change this to your database host
$dbname = 'econcern_database'; // Change this to your database name
$username = 'root'; // Change this to your database username
$password = '';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
