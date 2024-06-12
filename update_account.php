<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['UserID'])) 
{
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // RETRIEVE AND SANITIXE USER INFO
    $oldPassword = $connection->real_escape_string($_POST['oldPassword']);
    $newPassword = $connection->real_escape_string($_POST['newPassword']);
    $confirmPassword = $connection->real_escape_string($_POST['confirmPassword']);

    // VERIFY OLD USER PASSWORD
    $query = "SELECT password FROM users WHERE UserID = '{$_SESSION['UserID']}'";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) 
    {
        $storedHashedPassword = $result->fetch_assoc()['password'];

        if (password_verify($oldPassword, $storedHashedPassword)) 
        {
            // IF OLD PASSWORD IS CORRECT, PROCEED WITH CHANGES

            $updateQuery = "UPDATE users SET password = ? WHERE UserID = ?";
            $stmt = $connection->prepare($updateQuery);

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);


            $stmt->bind_param("si", $hashedPassword, $_SESSION['UserID']);
            if ($stmt->execute()) 
            {
                echo '<script>alert("Password updated successfully!"); window.location.replace(document.referrer);</script>';
                exit();
            } 
            else 
            {
                // ERROR MESSAGE FOR FAILED UPDATE
                echo '<script>alert("Error updating password: ' . $stmt->error . '"); window.history.back();</script>';
                exit();
            }

            $stmt->close();
        } 
        else 
        {
            // WRONG PASSWORD ALERT
            echo '<script>alert("Incorrect old password. Please try again."); window.history.back();</script>';
            exit();
        }
    } 
    else 
    {
        echo '<script>alert("Error retrieving user information."); window.history.back();</script>';
        exit();
    }
}

$connection->close();
