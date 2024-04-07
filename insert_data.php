<?php
// Include database connection
include 'connection.php';

// Retrieve data from POST request
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$recipient_email = $_POST['recipient_email'];
$typepassword = $_POST['typepassword'];

// Hash the password
$hashed_password = password_hash($typepassword, PASSWORD_DEFAULT);

// Perform database insertion with hashed password
$sql = "INSERT INTO users (firstname, lastname, recipient_email, typepassword) VALUES ('$firstname', '$lastname', '$recipient_email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "Registration data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>
