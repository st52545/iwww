<?php
$servername = "sql2.webzdarma.cz";
$username = "st52545webzd2482";
$password = "Databaze1";
$dbname = "st52545webzd2482";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>