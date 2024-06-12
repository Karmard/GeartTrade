<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vinNo'])) 
{
    $vinNo = $_POST['vinNo'];


    $updateQuery = "UPDATE carreg SET carStatus = 'sold' WHERE vinNo = '$vinNo'";
    $updateResult = $connection->query($updateQuery);

    if ($updateResult) 
    {
        echo 'success';
    } 
    else 
    {
        echo 'error';
    }
} 
else 
{
    echo 'invalid_request';
}

$connection->close();
