<?php

$hostname = 'localhost';
$username = 'Any';
$password = '';
$database = 'geartradehub';

// THE LINE BELOW IS FOR CREATING CONNECTION
$conn = new mysqli($hostname, $username, $password, $database);

// CHECK WHETHER THERE IS CONNECTION
if ($conn->connect_error) 
{
    //IF CONNECTION IS NOT GOOD, CANCEL
    die("Connection failed: " . $conn->connect_error);
}

// IF CONNECTION IS GOOD, DISPLAY
echo "Database connected successfully";

//CLOSE CONNECTION
$conn->close();