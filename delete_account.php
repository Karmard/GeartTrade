<?php
    session_start();
    include 'connection.php';

    // DELETE SUBSCRIPTION DATA FIRST BEFORE DELETING FROM USERS TABLE
    function deleteSubscriptions($userId, $connection) 
        {
            $deleteQuery = "DELETE FROM subscription WHERE UserID = ?";
            $stmt = $connection->prepare($deleteQuery);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $stmt->close();
        }

        if (isset($_GET['userId'])) 
            {
                $userId = $_GET['userId'];

                // DELETE RELATED SUSBS  RECORDS FIRST
                deleteSubscriptions($userId, $connection);

                // AFTER, DELETE FROM THE USER'S DATA FROM USERS TABLE
                $deleteQuery = "DELETE FROM users WHERE UserID = ?";
                $stmt = $connection->prepare($deleteQuery);
                $stmt->bind_param("i", $userId);

                if ($stmt->execute()) 
                {
                    echo "Account deleted successfully.";
                } 
                else 
                {
                    echo "Error deleting account: " . $connection->error;
                }

                $stmt->close();
            } 
        else 
            {
                header("Location: index.php");
                exit();
            }