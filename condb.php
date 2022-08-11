<?php 

$servername = "localhost";

// REPLACE with your Database name
$dbname = "";
// REPLACE with Database user
$username = "";
// REPLACE with Database user password
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>