<?php
session_start();
if (!isset($_SESSION['UserID'])) 
{
    header("Location: login.php");
    exit();
}

require_once("connection.php");

if (isset($_GET['userId'])) 
{
    $userId = $_GET['userId'];

    $queryUserDetails = "SELECT u.username, u.usertype, p.IDNo, p.IDproof, s.location, s.licence, s.certificate
                        FROM users u
                        LEFT JOIN personallog p ON u.UserID = p.UserID
                        LEFT JOIN showroomlog s ON u.UserID = s.UserID
                        WHERE u.UserID = ?";
    $stmtUserDetails = mysqli_prepare($connection, $queryUserDetails);
    mysqli_stmt_bind_param($stmtUserDetails, "i", $userId);
    mysqli_stmt_execute($stmtUserDetails);
    $resultUserDetails = mysqli_stmt_get_result($stmtUserDetails);

    if ($userDetails = mysqli_fetch_assoc($resultUserDetails)) 
    {
        $username = $userDetails['username'];
        $userType = $userDetails['usertype'];
        $IDNo = $userDetails['IDNo'];
        $IDproof = $userDetails['IDproof'];
        $location = $userDetails['location'];
        $licence = $userDetails['licence'];
        $certificate = $userDetails['certificate'];
    } 
    else 
    {
        header("Location: registered_users.php");
        exit();
    }

    mysqli_stmt_close($stmtUserDetails);
} 
else 
{
    header("Location: registered_users.php");
    exit();
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="STYLING/user.css">
</head>
<body>
    <header>
        <h1>Registration <?=$userId?>'s Details</h1>
    </header>
    <div class="content-container">
        <h2><?= $username ?>'s Details</h2>

        <table>
            <tr>
                <th>Username</th>
                <td><?= $username ?></td>
            </tr>
            
            <?php if ($userType === 'personal') : ?>
                
                <tr>
                    <th>ID Number</th>
                    <td><?= $IDNo ?></td>
                </tr>

                <tr>
                    <th>ID Proof</th>
                    <td>
                        <div class="image-container">
                            <?php if ($IDproof) : ?>
                                <img src="<?= $IDproof ?>" alt="ID Proof Image">
                            <?php else : ?>
                                <p>No ID Proof available.</p>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>


            <?php endif; ?>

            <?php if ($userType === 'showroom') : ?>

                <tr>
                    <th>Location</th>
                    <td><?= $location ?></td>
                </tr>

                <tr>
                    <th>Licence</th>
                    <td>
                        <div class="image-container">
                            <?php if ($licence) : ?>
                                <img src="<?= $licence ?>" alt="Licence Image" style="max-width: 30%;">
                            <?php else : ?>
                                <p>No Licence available.</p>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>Certificate</th>
                    <td>
                        <div class="image-container">
                            <?php if ($certificate) : ?>
                                <img src="<?= $certificate ?>" alt="Certificate Image" style="max-width: 30%;">
                            <?php else : ?>
                                <p>No Certificate available.</p>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </table>

        <div class="button-container">
            <button class="back-button" onclick="goBack()">Back home</button>
            <a class="back-button" href="registered_users.php">Registered Users</a>
        </div>
    </div>


    <script>
        function goBack() 
        {
            window.location.href = 'admin.php';
        }
    </script>
</body>
</html>
