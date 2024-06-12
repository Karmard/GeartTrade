<?php
include 'connection.php';

$username = $_GET['username'];
$vinNo = $_GET['vinNo'];

$query = "SELECT u.wnumber, c.carName FROM users u
          INNER JOIN carreg c ON u.UserID = c.UserID
          WHERE u.username = '$username' AND c.vinNo = '$vinNo'";
$result = $connection->query($query);


//SET TO JSON
header('Content-Type: application/json'); 

if ($result && $result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $whatsappNumber = $row['wnumber'];
    $carName = $row['carName'];
    
    $customMessage = "Hi, I'm interested in buying the $carName listed on Gear Trade Hub. Can you share more details about its condition and any room for negotiation on the price?";
    
    $whatsappLink = "https://wa.me/$whatsappNumber?text=" . urlencode($customMessage);
    
    echo json_encode(['success' => true, 'whatsappLink' => $whatsappLink]);
} 
else 
{
    echo json_encode(['success' => false]);
}

$connection->close();
