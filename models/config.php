<?php

// Connects with Database

$host = "localhost";
$user_name = "root";
$user_password = "";
$db_name = "odysseyair";

$conn = mysqli_connect ($host,$user_name,$user_password,$db_name);


if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);}
?>