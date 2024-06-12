<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['UserID'])) 
{
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM users WHERE UserID = '{$_SESSION['UserID']}'";
$result = $connection->query($query);

if ($result) 
{
    $user = $result->fetch_assoc();
} 
else 
{
    echo 'Error executing the query: ' . $connection->error;
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Gear Trade Hub</title>
    <link rel="stylesheet" href="account.css">
</head>
<body>

    <header>
        <div class="logo-container">
            <a href="index.php">
                <img src="images/WhatsApp_Image_2023-09-17_at_2.41.26_PM-removebg-preview.png" alt="Company Logo">
            </a>
        </div>
        <h1>Gear Trade Hub</h1>
        
    <!-- GREETI TEXT -->
<p id="greetingText" style="color: white;"></p>

        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="help.html">Help</a></li>
                <li><a href="chat.html">Report</a></li>
                <li id="loginButton"></li>
            </ul>
        </nav>
    </header>




    <!-- LIST CAR BUTTON -->
    <div id="listCarButton">
        <a href="carregistration.php"><button>List a New Car</button></a>
    </div>



    <div id="accountPage">
        <h2>Your Activity</h2>

                <section id="listedCars">
                    <h3>Listed Cars</h3>
                    <?php
                    include 'connection.php';

                    // Fetch the user's listed cars
                    $queryListedCars = "SELECT * FROM carreg WHERE UserID = '{$_SESSION['UserID']}'";
                    $resultListedCars = $connection->query($queryListedCars);

                    if ($resultListedCars && $resultListedCars->num_rows > 0) 
                    {
                        while ($car = $resultListedCars->fetch_assoc()) 
                        {
                            // DISPLAY LISTED CARS
                            echo "<div class='carListing'>";
                            echo "<img src='{$car['frontimage']}' alt='{$car['carName']}'>";
                            echo "<h4>{$car['carName']}</h4>";
                            echo "<p>Price: {$car['price']}</p>";
                            echo "</div>";
                        }
                    } 
                    else 
                    {
                        echo "<p>No listed cars.</p>";
                    }

                    $connection->close();
                    ?>
                </section>


                    <section id="earnings">
                        <h3>Earnings</h3>
                        <!-- Display earnings information here -->
                    </section>

                    <section id="carsSold">
                        <h3>Cars Sold</h3>
                        <!-- Display number of cars sold information here -->
                    </section>

                    <section id="editAccount">
                        <h3>Edit Account Information</h3>

                    </section>


        <section id="deleteAccount">
            <h3>Delete Account</h3>
            <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            <form action="delete_account.php" method="post">
                <button type="submit" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</button>
            </form>
        </section>
    </div>

    <div id="scrollToTop" class="scroll-to-top">&#8593;</div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const scrollToTopButton = document.getElementById('scrollToTop');
        const greetingText = document.getElementById('greetingText');
        const listCarButton = document.getElementById('listCarButton');

        // Function to get the greeting based on the current time
        function getGreeting() {
            const currentHour = new Date().getHours();
            let greeting;

            if (currentHour >= 5 && currentHour < 12) {
                greeting = 'Good morning';
            } else if (currentHour >= 12 && currentHour < 18) {
                greeting = 'Good afternoon';
            } else {
                greeting = 'Good evening';
            }

            return greeting;
        }

        // UPDATE GREETING TEXT
        function updateGreeting() {
            const greeting = getGreeting();
            greetingText.textContent = `${greeting}, <?php echo $user['username']; ?>!`;
        }

        updateGreeting();

        // SHOW/HIDE SCROLL TO TOP BUTTON
        window.addEventListener('scroll', function () {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollToTopButton.style.display = 'block';
            } else {
                scrollToTopButton.style.display = 'none';
            }
        });

        // SCROLL TO THE TOP ON CLICK
        scrollToTopButton.addEventListener('click', function () {
            document.body.scrollTop = 0; // SAFARI
            document.documentElement.scrollTop = 0; // CHROME,FIREFOX
        });

        <?php if (isset($_GET['incorrect_password']) && $_GET['incorrect_password'] === 'true') : ?>
            alert('Your old password is incorrect. Please try again.');
        <?php endif; ?>
    });
</script>

</body>
</html>
