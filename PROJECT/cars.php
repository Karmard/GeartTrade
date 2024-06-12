<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include 'connection.php';

// Log that the PHP script is running
error_log('PHP script is running');

// Handle the AJAX request to fetch car listings
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT carName, frontimage, price, username FROM carreg";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $carListings = array();
        while ($row = $result->fetch_assoc()) {
            $carListings[] = $row;
        }

        // Log the received car listings
        error_log('Received car listings: ' . json_encode($carListings));

        header('Content-Type: application/json');
        echo json_encode($carListings);
    } else {
        // Log that there are 0 results
        error_log('0 results');

        echo "0 results";
    }
}

// Close the database connection
$connection->close();

?>
