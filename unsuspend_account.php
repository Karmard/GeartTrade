<?php
session_start();
require_once("connection.php");

if (isset($_SESSION['UserID']) && isset($_GET['userId'])) {
    $adminId = $_SESSION['UserID'];
    $userId = $_GET['userId'];

    // TOGGLE SUSPENSION STATUS
    $queryToggleSuspend = "UPDATE users SET suspended = 1 - suspended, suspended_by_admin = NULL WHERE UserID = ?";
    $stmtToggleSuspend = mysqli_prepare($connection, $queryToggleSuspend);

    if ($stmtToggleSuspend === false) {
        die('Error preparing statement: ' . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmtToggleSuspend, "i", $userId);

    if (mysqli_stmt_execute($stmtToggleSuspend)) {
        echo "Account unsuspended successfully.";
    } else {
        echo "Error toggling the account suspension status: " . mysqli_error($connection);
    }

    mysqli_stmt_close($stmtToggleSuspend);
} else {
    echo "User ID not provided or admin not logged in.";
}

mysqli_close($connection);