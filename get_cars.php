<?php
include 'connection.php';

$searchTerm = $_GET['search'] ?? '';

$query = "SELECT cr.vinNo, cr.carName, cr.frontimage, cr.sideLeftimage, cr.sideRightimage, cr.backimage, cr.dashboardimage, cr.interiorimage, cr.price, cr.transmission, cr.mileage, u.username, cr.carStatus
          FROM carreg cr
          INNER JOIN users u ON cr.UserID = u.UserID
          WHERE (cr.brand LIKE ? OR cr.carName LIKE ?) AND u.suspended = 0";

$stmt = $connection->prepare($query);

if ($stmt) 
{
    $searchTerm = '%' . $searchTerm . '%';
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();

    $result = $stmt->get_result();

    $cars = array();

    while ($row = $result->fetch_assoc()) 
    {
        $cars[] = array(
            'vinNo' => $row['vinNo'],
            'carName' => $row['carName'],
            'frontimage' => $row['frontimage'],
            'sideLeftimage' => $row['sideLeftimage'],
            'sideRightimage' => $row['sideRightimage'],
            'backimage' => $row['backimage'],
            'dashboardimage' => $row['dashboardimage'],
            'interiorimage' => $row['interiorimage'],
            'price' => $row['price'],
            'transmission' => $row['transmission'],
            'mileage' => $row['mileage'],
            'username' => $row['username'],
            'carStatus' => $row['carStatus'],


        );
    }

    $stmt->close();
} 
else 
{
    echo 'Error preparing statement: ' . $connection->error;
}

$connection->close();

echo json_encode($cars);
