<?php
include 'connection.php';

$query = "SELECT vinNo, carName, frontimage, sideLeftimage, sideRightimage, backimage, dashboardimage, interiorimage, price, transmission, mileage, UserID FROM carreg";
$result = $connection->query($query);

$cars = array();

if ($result) 
{
    while ($row = $result->fetch_assoc()) {
        $userID = $row['UserID'];
        $usernameQuery = "SELECT username FROM users WHERE UserID = ?";
        $stmt = $connection->prepare($usernameQuery);

        if ($stmt)
         {
            $stmt->bind_param("s", $userID);
            $stmt->execute();
            $stmt->bind_result($username);

            if ($stmt->fetch()) 
            {
                $stmt->close();
            } 
            else 
            {
                $username = $userID;
            }
        }
         else
        {
            echo 'Error preparing statement: ' . $connection->error;
        }

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
            'username' => $username,
        );
    }
}
 else 
{
    echo 'Error executing the query: ' . $connection->error;
}

$connection->close();

echo json_encode($cars);
?>
