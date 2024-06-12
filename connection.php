<?php

$servername = "localhost";
$username = "Any";
$password = "";
$dbname = "geartradehub"; 

// CREATING CONNECTION
$connection = new mysqli($servername, $username, $password, $dbname);

// CHECK IF CONNECTION IS OK
if ($connection->connect_error) 
{
    die("Connection failed: " . $connection->connect_error);
}

