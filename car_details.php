<?php
include 'connection.php';
// CHECKS WHICH USER IS CURRENTLY USING THE SYSTEM
session_start();

// RETRIEVE CAR DETAILS
$vinNo = isset($_GET['vinNo']) ? $_GET['vinNo'] : '';
$carName = isset($_GET['carName']) ? $_GET['carName'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$transmission = isset($_GET['transmission']) ? $_GET['transmission'] : '';

$query = "SELECT carCondition FROM carreg WHERE vinNo = '$vinNo'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) 
    {
        $row = mysqli_fetch_assoc($result);
        
        $carCondition = $row['carCondition'];
    } 
else 
    {
        $carCondition = "Not defined";
    }
$mileage = isset($_GET['mileage']) ? $_GET['mileage'] : '';
$username = isset($_GET['username']) ? $_GET['username'] : '';
$frontimage = isset($_GET['frontimage']) ? $_GET['frontimage'] : '';
$sideLeftimage = isset($_GET['sideLeftimage']) ? $_GET['sideLeftimage'] : '';
$sideRightimage = isset($_GET['sideRightimage']) ? $_GET['sideRightimage'] : '';
$backimage = isset($_GET['backimage']) ? $_GET['backimage'] : '';
$dashboardimage = isset($_GET['dashboardimage']) ? $_GET['dashboardimage'] : '';
$interiorimage = isset($_GET['interiorimage']) ? $_GET['interiorimage'] : '';
$loggedIn = isset($_SESSION['UserID']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="STYLING/details.css">
    <link rel="stylesheet" href="slideshow.css">

    <style>

    #buyButton 
    {
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease-in-out;
        cursor: pointer;
        font-size: 16px; 
        height: 40px;   
        display: inline-block; 
    }

    #buyButton:hover 
    {
        background-color: darkred;
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


        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="help.html">Help</a></li>
                <li id="loginButton"></li>
            </ul>
        </nav>
    </header>

    <section id="carDetails">
        <div class="carDetail">
            <div class="slideshow-container">
                <div class="mySlides">
                    <img src="<?php echo $frontimage; ?>" alt="<?php echo $carName; ?>">
                </div>
                <div class="mySlides">
                    <img src="<?php echo $sideLeftimage; ?>" alt="Side Left">
                </div>
                <div class="mySlides">
                    <img src="<?php echo $sideRightimage; ?>" alt="Side Right">
                </div>
                <div class="mySlides">
                    <img src="<?php echo $backimage; ?>" alt="Back">
                </div>
                <div class="mySlides">
                    <img src="<?php echo $dashboardimage; ?>" alt="Dashboard">
                </div>
                <div class="mySlides">
                    <img src="<?php echo $interiorimage; ?>" alt="Interior">
                </div>
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <h2><?php echo $carName; ?></h2>
            <div class="details-container">
                <p>Price: Ksh.<?php echo $price; ?></p>
                <p>Transmission: <?php echo $transmission; ?></p>
                <p>Condition: <?php echo $carCondition; ?></p>
                <p>Mileage: <?php echo $mileage; ?> Kilometers</p>
                <p>Listed by: <?php echo $username; ?></p>
            </div>
        </div>


        <div class="buttons">
            <a href="index.php">Back</a>
            <?php if ($loggedIn) 
            { ?>
                <button id="buyButton" onclick="sendWhatsApp()">Buy</button>
                <a href="help.html" onclick="reportCar()">Report</a>
              <?php 
            }
         ?>
        </div>
    </section>


    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n)
        {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) 
        {
            showSlides(slideIndex = n);
        }

        function showSlides(n) 
        {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            if (n > slides.length) 
            {
                slideIndex = 1;
            }
            if (n < 1) 
            {
                slideIndex = slides.length;
            }
            for (i = 0; i < slides.length; i++) 
            {
                slides[i].style.display = "none";
            }
            slides[slideIndex - 1].style.display = "block";
        }
    </script>

<script>
function sendWhatsApp() 
{
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () 
    {
        if (xhr.readyState === XMLHttpRequest.DONE) 
        {
            try 
            {
                var response = JSON.parse(xhr.responseText);

                if (response.success) 
                {
                    window.location.href = response.whatsappLink;
                } 
                else 
                {
                    alert('WhatsApp number not available.');
                }
            } 
            catch (e) 
            {
                console.error('Error parsing JSON response:', e);
                alert('Error parsing JSON response.');
            }
        }
    };

    xhr.open('GET', 'get_whatsapp_number.php?username=<?php echo $username; ?>&vinNo=<?php echo $vinNo; ?>', true);
    xhr.send();
}

</script>

</body>
</html>
