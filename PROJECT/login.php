<?php

// Start the session
session_start();

// INCLUDING THE DATABASE CONNECTION PAGE
require_once("connection.php"); 

// CHECK IF FORM IS SUBMITTED USING POST (post is used to submit sensitive info)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // CHECK IF USER EXISTS OR CREDENTIALS ARE CORRECT
    $query = "SELECT * FROM users WHERE username = '$username' AND email = '$email' AND password = '$password'";
    $result = mysqli_query($connection, $query); 

    // CHECK IF ONE ROW IS RETURNED, LOGIN SUCCESSFUL
    if (mysqli_num_rows($result) == 1) {
        // Assuming you have a column named 'user_id' in your 'users' table
        $user = mysqli_fetch_assoc($result);
        $user_id = $user['UserID'];

        // SET THE USER ID IN THE SESSION
        $_SESSION['UserID'] = $user_id;

        // Redirect to the homepage or wherever you want
        header("Location: index.php");
        exit();
    } else {
        // ERROR MESSAGE FOR FAILED LOGIN
        $error_message = "Invalid username, email, or password!!!.";
    }
}

// CLOSE DB CONNECTION
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gear Trade Hub</title>
    <link rel="stylesheet" href="registration.css">

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
        }    </style>
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
            <p>Don't have an account? <a href="registration.php">Register here</a>.</p>
        </form>
    </div>

    <!-- ERROR -->
    <div class="popup" id="error-popup">
        <?php if (isset($error_message)) echo $error_message; ?>
    </div>

    <script>
        var errorPopup = document.getElementById('error-popup');
        if (errorPopup.innerHTML.trim() !== '') {
            errorPopup.style.display = 'block';
            setTimeout(function () {
                errorPopup.style.display = 'none';
            }, 3000); 
        }
    </script>
</body>
</html>
