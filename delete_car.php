<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vinNo'])) 
{
    $vinNo = $_POST['vinNo'];

    $deleteQuery = "DELETE FROM carreg WHERE vinNo = '$vinNo' AND UserID = '{$_SESSION['UserID']}'";

    if ($connection->query($deleteQuery) === TRUE) 
    {
        echo 'Car successfully deleted';
    } else {
        echo 'Error deleting car: ' . $connection->error;
    }
} 
else 
{
    echo 'Invalid request';
}

$connection->close();