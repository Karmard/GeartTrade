<?php
    session_start();
    require_once("connection.php");
    require_once("email_functions.php");

    // GENERATE RANDOM PASSWORDS
    function generateRandomPassword($length = 10) 
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $password = '';
            for ($i = 0; $i < $length; $i++) 
            {
                $password .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $password;
        }

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $email = $_POST["email"];

            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) 
                {
                    $user = mysqli_fetch_assoc($result);

                    // GENERATE RANDOM PASS
                    $new_password = generateRandomPassword();

                    // HASHING PASS
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                    $update_query = "UPDATE users SET password = ? WHERE email = ?";
                    $update_stmt = mysqli_prepare($connection, $update_query);
                    mysqli_stmt_bind_param($update_stmt, "ss", $hashed_password, $email);
                    mysqli_stmt_execute($update_stmt);

                    // SEND TEMPO PASS TO EMAIL
                    $subject = "Temporary Password";
                    $message = "Dear {$user['username']},\n\nYour temporary password is: {$new_password}\n\nPlease log in using this temporary password and change it later.\n\nBest regards,\nGTH Support";
                    sendEmail($email, $subject, $message);

                    header("Location: login.php?reset=1");
                    exit();
            } 
            else 
                {
                    $error_message = "Invalid email!";
                }
        }

    mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - Gear Trade Hub</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('images/pass.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            overflow: hidden;
        }

        .container {
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

        form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .back-button {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<div class="container">
    <form action="reset.php" method="post">
        <h2>Reset Password</h2>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Reset Password</button>
        <button class="back-button" onclick="window.location.href='login.php'">Back to Login</button>
    </form>
</div>

</body>
</html>
