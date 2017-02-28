<?php
$servername = "localhost";
$username = "vpnUser";
$password = "vpnPassword";
$dbname = "ultimateVPN";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table



$conn->close();
?>