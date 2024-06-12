<?php
session_start();
require_once("connection.php");

$searchTerm = $_GET['searchTerm'];

$queryUsers = "SELECT u.UserID, u.username, u.email, u.wnumber, u.usertype, u.approval_status, p.pFname, p.pLname, s.showname, u.suspended
               FROM users u
               LEFT JOIN personallog p ON u.UserID = p.UserID
               LEFT JOIN showroomlog s ON u.UserID = s.UserID
               WHERE u.username LIKE ?";

$stmt = mysqli_prepare($connection, $queryUsers);
$searchTerm = "%" . $searchTerm . "%";
mysqli_stmt_bind_param($stmt, "s", $searchTerm);
mysqli_stmt_execute($stmt);
$resultUsers = mysqli_stmt_get_result($stmt);

mysqli_close($connection);

$users = array();

while ($user = mysqli_fetch_assoc($resultUsers)) 
{
    $users[] = $user;
}

echo json_encode($users);
?>
