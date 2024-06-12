<?php
        session_start();
            if (!isset($_SESSION['UserID'])) 
                {
                    header("Location: login.php");
                    exit();
                }

        require_once("connection.php");
        $userID = $_SESSION['UserID'];

        // QUERY TO RETRIEVE LOGGED IN ADMIN DATA
        $queryAdminDetails = "SELECT UserID, Fname, Lname, email, wnumber FROM adminlog WHERE UserID = ?";
        $stmtAdminDetails = mysqli_prepare($connection, $queryAdminDetails);
        mysqli_stmt_bind_param($stmtAdminDetails, "s", $userID);
        mysqli_stmt_execute($stmtAdminDetails);
        $resultAdminDetails = mysqli_stmt_get_result($stmtAdminDetails);

        // FETCH ADMIN DETAILS
        $admin = mysqli_fetch_assoc($resultAdminDetails);

        if (!$admin) 
        {
            die("Admin details not found. Please contact support.");
        }

        // QUERY TO RETRIEVE DATA OF USER SUSPENDED BY THE ADMIN
        $querySuspendedUsers = "SELECT username, email, wnumber FROM users WHERE suspended = 1 AND suspended_by_admin = ?";
        $stmtSuspendedUsers = mysqli_prepare($connection, $querySuspendedUsers);
        mysqli_stmt_bind_param($stmtSuspendedUsers, "s", $userID);
        mysqli_stmt_execute($stmtSuspendedUsers);
        $resultSuspendedUsers = mysqli_stmt_get_result($stmtSuspendedUsers);
?>

        <!DOCTYPE html>
        <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Admin Profile</title>
                    <link rel="stylesheet" href="STYLING/admin_profile.css">
                </head>

                <body>
                <header class="header">
                <div class="header-content">
                    <div class="logo-container">
                        <a href="admin.php">
                            <img src="images/WhatsApp_Image_2023-09-17_at_2.41.26_PM-removebg-preview.png" alt="Company Logo">
                        </a>
                    </div>
                    <h1>Gear Trade Hub</h1>
                </div>

            </header>

                    <div class="admin-data">
                                <div class="admin-details">
                                        <div>
                                            <h2>Your Details</h2>
                                            <p>Your Admin ID: <b><?php echo $admin['UserID']; ?></b></p>
                                            <p>Full Name: <b><?php echo $admin['Fname'] . " " . $admin['Lname']; ?></b></p>
                                            <p>Email: <b><?php echo $admin['email']; ?></b></p>
                                            <p>WhatsApp Number: <b><?php echo $admin['wnumber']; ?></b></p>
                                        </div>
                                </div>  


                                <div class="suspended-details">
                                        <div>
                                            <h2>Suspended Users</h2>
                                            <?php if ($resultSuspendedUsers && mysqli_num_rows($resultSuspendedUsers) > 0) : ?>
                                                <ul>
                                                    <?php while ($suspendedUser = mysqli_fetch_assoc($resultSuspendedUsers)) : ?>
                                                        <li>
                                                            Username: <?php echo $suspendedUser['username']; ?><br>
                                                            Email: <?php echo $suspendedUser['email']; ?><br>
                                                            WhatsApp Number: <?php echo $suspendedUser['wnumber']; ?><br>
                                                        </li>
                                                    <?php endwhile; ?>
                                                </ul>
                                            <?php else : ?>
                                                <!-- MESSAGE IF NO SUSPENDED USER -->
                                                <p>You have not suspended any user</p>
                                            <?php endif; ?>
                                        </div>
                                </div>
                    </div>

                    <div class="back-button-container">
                          <a href="admin.php" class="back-button">Back</a>
                    </div>
                </body>

        </html>

        <?php
        mysqli_close($connection);
        ?>
