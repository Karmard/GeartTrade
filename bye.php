<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .logout-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .image-container {
            margin-bottom: 20px;
        }

        #time-image {
            max-width: 60%; 
            display: block; 
            margin: 0 auto;
            border-radius: 50px;
        }

        .message-container {
            text-align: center;
        }

        #greeting-message {
            font-size: 24px;
            color: #333;
            font-weight: bold;
            text-transform: capitalize;
        }

    </style>
</head>
<body>
    <div class="logout-container">
        <div class="image-container">
            <?php
                $now = new DateTime();
                $hours = $now->format('G');
                $timeMessage = "";

                if ($hours >= 5 && $hours < 12) { 
                    $timeMessage = "morning";
                } elseif ($hours >= 12 && $hours < 18) { 
                    $timeMessage = "noon";
                } else {
                    $timeMessage = "night";
                }
            ?>
            <img id="time-image" src="<?php echo $timeMessage ?>.jpg" alt="Time Image">
        </div>
        <div class="message-container">
            <?php
                // Greeting message without the username
                $greetingMessage = "";
                if ($hours >= 5 && $hours < 12) { 
                    $greetingMessage = "have a lovely day";
                } elseif ($hours >= 12 && $hours < 18) { 
                    $greetingMessage = "have a lovely afternoon";
                } else {
                    $greetingMessage = "have a lovely evening";
                }

                $fullGreetingMessage = "See you soon, $greetingMessage";
            ?>
            <p id="greeting-message"><?php echo $fullGreetingMessage; ?></p>
        </div>
    </div>

    <script>
        var now = new Date();
        var hours = now.getHours();

        var timeImage = document.getElementById("time-image");
        var greetingMessage = document.getElementById("greeting-message");

        if (hours >= 5 && hours < 12) {
            timeImage.src = "images/morning.jpg";
        } else if (hours >= 12 && hours < 18) {
            timeImage.src = "images/noon.jpg";
        } else {
            timeImage.src = "images/night.jpg";
        }

        setTimeout(function() {
            window.location.href = "index.php";
        }, 2000); 
    </script>
</body>
</html>
