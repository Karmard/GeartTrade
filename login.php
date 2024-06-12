<?php
session_start();
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // CHECK IF USER EXISTS OR CREDENTIALS ARE CORRECT IN users TABLE
    $queryUser = "SELECT * FROM users WHERE username = ?";
    $stmtUser = mysqli_prepare($connection, $queryUser);
    mysqli_stmt_bind_param($stmtUser, "s", $username);
    mysqli_stmt_execute($stmtUser);
    $resultUser = mysqli_stmt_get_result($stmtUser);

    if (mysqli_num_rows($resultUser) == 1) 
    {
        $user = mysqli_fetch_assoc($resultUser);

        // CHECK PASSWORD USING password_verify
        if (password_verify($password, $user['password'])) 
        {
            $_SESSION['UserID'] = $user['UserID'];
            $_SESSION['IsAdmin'] = false; 
            header("Location: loading.php");
            exit();
        }
    }

    // CHECK IF USER EXISTS OR CREDENTIALS ARE CORRECT IN adminlog TABLE
    $queryAdmin = "SELECT * FROM adminlog WHERE UserID = ? AND email = ? AND password = ?";
    $stmtAdmin = mysqli_prepare($connection, $queryAdmin);
    mysqli_stmt_bind_param($stmtAdmin, "sss", $username, $email, $password);
    mysqli_stmt_execute($stmtAdmin);
    $resultAdmin = mysqli_stmt_get_result($stmtAdmin);

    // CHECK IF ONE ROW IS RETURNED, LOGIN SUCCESSFUL FOR adminlog
    if (mysqli_num_rows($resultAdmin) == 1) 
    {
        $admin = mysqli_fetch_assoc($resultAdmin);
        $admin_id = $admin['UserID'];

        // SET THE ADMIN ID IN THE SESSION
        $_SESSION['UserID'] = $admin_id;

        // REDIRECT TO ADMIN PAGE IF AN ADMIN LOGS IN
        header("Location: admin.php");
        exit();
    } 
    else 
    {
        // ERROR MESSAGE FOR FAILED LOGIN
        $error_message = "Invalid email or password!!!.";
    }
}

mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gear Trade Hub</title>
    <link rel="stylesheet" href="STYLING/registration.css">

    <style>
        .container 
        {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 60%;
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }

        .popup 
        {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: lightblue;
            color: red;
            padding: 15px;
            border-radius: 8px;
            z-index: 1;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }    

        .link-container 
        {
            display: flex;
            justify-content: space-between;
        }

        .register-link, .forgot-password-link 
        {
            width: 48%;
            text-align: center;
            text-decoration: none;
        }


        </style>
</head>
<body>

    <header>
        <div class="logo-container">
            <a href="index.php">
                <img src="images/WhatsApp_Image_2023-09-17_at_2.41.26_PM-removebg-preview.png" alt="Company Logo">
            </a>
        </div>
        <h1>Gear Trade Hub</h1>
    </header>

    <div class="container">
        <form action="login.php" method="post">
            <h2>Log In Here</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>

            <div class="link-container">
                <p class="register-link">Don't have an account? <a href="registration.php">Register here</a>.</p>
                <p class="forgot-password-link">Forgot your password? <a href="reset.php">Reset it here</a>.</p>
            </div>

        </form>
    </div>

    <!-- ERROR -->
    <div class="popup" id="error-popup">
        <?php if (isset($error_message)) echo $error_message; ?>
    </div>

    <script>
        var errorPopup = document.getElementById('error-popup');
        if (errorPopup.innerHTML.trim() !== '') 
        {
            errorPopup.style.display = 'block';
            setTimeout(function () 
            {
                errorPopup.style.display = 'none';
            }, 3000); 
        }
    </script>
</body>
</html>
