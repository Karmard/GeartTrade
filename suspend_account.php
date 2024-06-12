<?php
        session_start();
        require_once("connection.php");

        if (isset($_SESSION['UserID']) && isset($_GET['userId'])) 
        {
            $adminId = $_SESSION['UserID'];
            $userId = $_GET['userId'];

            // TOGGLE SUSPENSION STATUS
            $queryToggleSuspend = "UPDATE users SET suspended = 1 - suspended, suspended_by_admin = CASE WHEN suspended = 1 THEN ? ELSE NULL END WHERE UserID = ?";
            $stmtToggleSuspend = mysqli_prepare($connection, $queryToggleSuspend);

            if ($stmtToggleSuspend === false) 
            {
                die('Error preparing statement: ' . mysqli_error($connection));
            }

            mysqli_stmt_bind_param($stmtToggleSuspend, "ii", $adminId, $userId);

            if (mysqli_stmt_execute($stmtToggleSuspend)) 
            {
                // FETCH SUSPENDED USER'S DETAILS
                $getEmailUsernameQuery = "SELECT email, username FROM users WHERE UserID = ?";
                $stmtGetEmailUsername = mysqli_prepare($connection, $getEmailUsernameQuery);
                mysqli_stmt_bind_param($stmtGetEmailUsername, "i", $userId);
                mysqli_stmt_execute($stmtGetEmailUsername);
                mysqli_stmt_bind_result($stmtGetEmailUsername, $email, $username);
                mysqli_stmt_fetch($stmtGetEmailUsername);
                mysqli_stmt_close($stmtGetEmailUsername);

                // CHECK IF USER IS BEING SUSPENDED
                $isSuspended = (mysqli_fetch_assoc(mysqli_query($connection, "SELECT suspended FROM users WHERE UserID = $userId"))['suspended'] == 1);

                // CONSTRUCT SUSPENSION LETTER
                $suspensionMessage = $_GET['suspensionMessage'];

                $subject = "Account Suspension Notice";
                $message = "Subject: $subject\n\n";
                $message .= "Dear $username,\n\n$suspensionMessage\n\nRegards,\nGTH Support";

                if ($isSuspended) 
                {
                    require_once 'email_functions.php';
                    if (sendEmail($email, $subject, $message)) 
                    {
                        echo "Account suspended successfully.";
                    } 
                    else 
                    {
                        echo "Error sending email to the suspended user.";
                    }
                } 
                else 
                {
                    echo "Account unsuspended successfully.";
                }
            } 
            else 
            {
                echo "Error toggling the account suspension status: " . mysqli_error($connection);
            }

            mysqli_stmt_close($stmtToggleSuspend);
        } 
        else 
        {
            echo "User ID not provided or admin not logged in.";
        }

        mysqli_close($connection);
