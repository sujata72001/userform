<?php
$servername = 'localhost'; // Replace with your server name
$username = 'your_username'; // Replace with your database username
$password = 'your_password'; // Replace with your database password
$database = 'your_database_name'; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
