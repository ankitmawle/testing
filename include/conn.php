<?php 

$servername = "localhost";
$username = "rootgq8v_BattleTournament";
$password = "@#Vipulsingh";
$db = "rootgq8v_BattleTournament";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
mysqli_set_charset($conn,"utf8");
?>