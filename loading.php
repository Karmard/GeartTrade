<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>
    <style>
        body 
        {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        @font-face 
        {
            font-family: 'CustomFont';
            src: url('fonts/BerkshireSwash-Regular.ttf') format('woff2');
            font-weight: normal;
            font-style: normal;
        }

        .loading-container 
        {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .logo 
        {
            width: 300px;
            height: auto;
            margin-bottom: 20px;
            opacity: 0;
            animation: fadeInLogo 2s ease-in-out forwards;
        }

        .text 
        {
            font-family: 'CustomFont', Arial, sans-serif;
            font-size: 20px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            opacity: 0;
            animation: fadeInText 2s ease-in-out forwards;
        }

        .progress 
        {
            width: 500px;
            height: 50px;
            margin: 1em auto;
            border: 1px solid #fff;
            padding: 12px 10px;
        }

        .progress .bar 
        {
            width: 0%;
            height: 30%;
            background: linear-gradient(red, #c85, gold);
            background-repeat: repeat;
            box-shadow: 0 0 10px 0px grey;
            transition: width 2s ease-in-out;
            animation: fillAnimation 2s ease-in-out forwards;
        }

        @keyframes fadeInLogo 
        {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInText 
        {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fillAnimation 
        {
            from { width: 0%; }
            to { width: 100%; }
        }
        @media (max-width: 768px) 
        {
            .logo 
            {
                width: 80%;
                max-width: 250px;
            }

            .progress 
            {
                width: 90%;
                max-width: 400px; 
            }
        }
    </style>
</head>
<body>
    <div class="loading-container">
        <img src="images/WhatsApp_Image_2023-09-17_at_2.41.26_PM-removebg-preview.png" alt="Company Logo" class="logo">
        <div class="text">Welcome to Gear Trade Hub, your most trusted vehicle broker.</div>
        <div class="progress">
            <div class="bar"></div>
        </div>
    </div>

    <script>
        function redirectToPage() 
        {
            <?php
            if(isset($_SESSION['UserID'])) 
            {
                echo "window.location.href = 'index.php';";
            } 
            else 
            {
                echo "window.location.href = 'login.php';";
            }
            ?>
        }

        document.querySelector('.bar').addEventListener('animationend', redirectToPage);
    </script>
</body>
</html>
