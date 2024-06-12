<?php
        session_start();
        include 'connection.php';

        $subscriptionActive = false;

        if (!isset($_SESSION['UserID'])) 
            {
                header("Location: login.php");
                exit();
            }

        $query = "SELECT u.*, s.end_date 
                FROM users u 
                LEFT JOIN subscription s ON u.UserID = s.UserID 
                WHERE u.UserID = '{$_SESSION['UserID']}'";
        $result = $connection->query($query);

        if ($result) 
            {
                $user = $result->fetch_assoc();
                // CHECK IF USER HAS AN ACTIVE SUBSCRIPTION
                if ($user['end_date']) 
                    {
                        $endDate = strtotime($user['end_date']);
                        $currentDate = strtotime(date('Y-m-d'));
                        $daysRemaining = ($endDate - $currentDate) / (60 * 60 * 24);

                        if ($daysRemaining > 0) 
                            {
                                $subscriptionStatus = "Your subscription ends in " . ceil($daysRemaining) . " days";
                                $subscriptionActive = true; // SLAG TO INDICATE ACTIVE SUBSCRIPTION

                            } 

                        else 
                            {
                                // WHEN SUBSCRIPTION EXPIRED, DELETE FROM DATABASE
                                $deleteQuery = "DELETE FROM subscription WHERE UserID = '{$_SESSION['UserID']}'";
                                if ($connection->query($deleteQuery)) 
                                    {
                                        $subscriptionStatus = "Your subscription has expired";
                                        $subscriptionActive = false; // FLAG TO INDICATE EXPIRED SUBSCRIPTION
                                    } 
                                else 
                                    {
                                        $subscriptionStatus = "Error deleting subscription: " . $connection->error;
                                        $subscriptionActive = false;
                                    }
                            }
                    } 
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
        <link rel="stylesheet" href="STYLING/account.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-FO5oi+e6+PDVm+vGxxa7+p1FXsR6NHlq4sld9c8b2mIsGdhyNNlUWZhW/1KfvDQ74Mg14FaeN7Hn/udLalBtNw==" crossorigin="anonymous" />

        <style>
            body 
            {
                margin: 0;
                font-family: Arial, sans-serif;
                overflow-x: hidden;
            }

            header 
            {
                background-color: #333;
                padding: 15px;
                text-align: center;
                color: white;
                position: relative; 
                z-index: 1001; 
            }

            footer 
            {
                color: black;
                padding: 10px;
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                z-index: 1001;
            }

            #accountPage 
            {
                padding: 20px;
            }

            #accountPage .content-suspended 
            {
                filter: blur(5px);
                pointer-events: none; 
                opacity: 0.7; 
                position: relative; 
                z-index: 1000; 
            }

            .suspended-overlay 
            {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                z-index: 1000;
            }

            .carListing 
            {
                margin-bottom: 20px;
                border: 1px solid #ddd;
                padding: 10px;
                position: relative;
            }
            .image-container 
            {
                position: relative;
                overflow: hidden;
            }


            .carListing img 
            {
                max-width: 100%;
                height: auto;
                position: relative;

            }

            .carButtons 
            {
                display: flex;
                justify-content: space-between;
                margin-top: 10px;
            }

            .carButtons button 
            {
                padding: 5px 10px;
                cursor: pointer;
            }

            .scroll-to-top 
            {
                display: none;
                position: fixed;
                bottom: 20px;
                right: 20px;
                background-color: #333;
                color: white;
                padding: 10px;
                cursor: pointer;
            }

            .footer-hidden 
            {
                transform: translateY(100%);
            }

            .footer-visible 
            {
                transform: translateY(0);
            }

            .confirmation-popup 
            {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #fff;
                padding: 20px;
                border: 1px solid #ccc;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                z-index: 1001;
            }

            .confirmation-popup h3 
            {
                margin-top: 0;
            }

            .confirmation-popup button 
            {
                background-color: #333;
                color: #fff;
                padding: 10px 15px;
                border: none;
                cursor: pointer;
            }

            .confirmation-popup button:hover 
            {
                background-color: #555;
            }

            .overlay 
            {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1000;
            }
            .sold-watermark 
            {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                background-color: #39e75f;
                color: red;
                padding: 10px 100px;
                font-weight: bold;
                z-index: 1000;
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

            <!-- GREETI TEXT -->
            <p id="greetingText" style="color: white;"></p>

            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="help.html">Help</a></li>
                    <li id="loginButton"></li>
                </ul>
            </nav>
        </header>

        <?php if ($user['suspended'] == 1) : ?>
            <div class="suspended-overlay">
                <p>Sorry, your account has been suspended temporarily. Please contact customer care within 3 days or your account will be terminated!! Thank you</p>
            </div>
        <?php endif; ?>

        <!-- LIST CAR BUTTON -->
        <?php if ($subscriptionActive): ?>
        <div id="listCarButton">
            <a href="carregistration.php"><button>List a New Car</button></a>
        </div>
        <?php endif; ?>

                <!-- SUBSCRIPTION BUTTON -->
                <section id="subscribeSection">
                    <?php if (isset($subscriptionStatus)) : ?>
                        <button id="subscribeButton" onclick="window.location.href = 'subscription.php'"><?php echo $subscriptionStatus; ?></button>
                    <?php else : ?>
                        <button id="subscribeButton" onclick="window.location.href = 'subscription.php'">Subscribe to enjoy more features</button>
                    <?php endif; ?>
                    <p id="subscriptionStatus"></p>
                </section>

        <?php if ($subscriptionActive): ?>
        <div id="accountPage" class="<?php echo ($user['suspended'] == 1) ? 'content-suspended' : ''; ?>">

            <!-- LISTED CARS -->
            <section id="listedCars">
                    <h3>Listed Cars</h3>
                    <?php
                    include 'connection.php';

                // FETCH LISTED CARS
                $queryListedCars = "SELECT * FROM carreg WHERE UserID = '{$_SESSION['UserID']}'";
                $resultListedCars = $connection->query($queryListedCars);

                if ($resultListedCars && $resultListedCars->num_rows > 0) 
                    {
                        while ($car = $resultListedCars->fetch_assoc()) 
                            {
                                // CHECK IF CAR IS SOLD FOR APPROPRIATE CLASS
                                $soldClass = (strcasecmp($car['carStatus'], 'sold') == 0) ? 'sold' : '';
                            
                                // DISPLAY LISTED CARS
                                echo "<div class='carListing'>";
                            
                                echo "<div class='image-container {$soldClass}'>";

                                // CHECK FOR SOLD WATERMARK
                                if (strcasecmp($car['carStatus'], 'sold') == 0) 
                                    {
                                        echo "<div class='sold-watermark'>SOLD</div>";
                                    }
                                echo "<img src='{$car['frontimage']}' alt='{$car['carName']}'>";
                                echo "</div>";
                            
                                echo "<h4>{$car['carName']}</h4>";
                                echo "<p>Price: {$car['price']}</p>";
                            
                                // ADD SOLD AND DELETE BUTTONS
                                echo "<div class='carButtons'>";
                                echo "<button class='soldButton {$soldClass}' data-vin='{$car['vinNo']}' onclick='markAsSold(this)'>Sold</button>";
                                echo "<button class='editButton' data-vin='{$car['vinNo']}' onclick='editCar(this)'>✏️</button>";
                                echo "<button class='deleteButton' data-vin='{$car['vinNo']}' onclick='deleteCar(this)'>Unlist</button>";
                                echo "</div>";
                            
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

            <section id="editAccount">
                <h3>Edit Account Information</h3>
                <form action="update_account.php" method="post">
                    <label for="oldPassword">Old Password:</label>
                    <input type="password" id="oldPassword" name="oldPassword" required>

                    <label for="newPassword">New Password:</label>
                    <input type="password" id="newPassword" name="newPassword" required>

                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>

                    <button type="submit">Save Changes</button>
                </form>
            </section>

        </div>
        <?php endif; ?>


        <div id="scrollToTop" class="scroll-to-top">&#8593;</div>

        <script>
            document.addEventListener('DOMContentLoaded', function () 
            {
                const scrollToTopButton = document.getElementById('scrollToTop');
                const greetingText = document.getElementById('greetingText');
                const listCarButton = document.getElementById('listCarButton');

                function getGreeting() {
                    const currentHour = new Date().getHours();
                    let greeting;

                    if (currentHour >= 5 && currentHour < 12) 
                        {
                            greeting = 'Good morning';
                        } 
                    else if (currentHour >= 12 && currentHour < 18) 
                        {
                            greeting = 'Good afternoon';
                        } 
                    else 
                        {
                            greeting = 'Good evening';
                        }

                    return greeting;
                }

                // UPDATE GREETING TEXT
                function updateGreeting() 
                    {
                        const greeting = getGreeting();
                        greetingText.textContent = `${greeting}, <?php echo $user['username']; ?>!`;
                    }

                updateGreeting();

                // SHOW/HIDE SCROLL TO TOP BUTTON
                window.addEventListener('scroll', function () 
                {
                    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) 
                        {
                            scrollToTopButton.style.display = 'block';
                        } 
                    else 
                        {
                            scrollToTopButton.style.display = 'none';
                        }
                });

                // SCROLL TO THE TOP ON CLICK
                scrollToTopButton.addEventListener('click', function () 
                {
                    document.body.scrollTop = 0; // SAFARI
                    document.documentElement.scrollTop = 0; // CHROME,FIREFOX
                });

                <?php if (isset($_GET['incorrect_password']) && $_GET['incorrect_password'] === 'true') : ?>
                    alert('Your old password is incorrect. Please try again.');
                <?php endif; ?>
            });

            


            function editCar(button) 
            {
                const vinNo = button.dataset.vin;
                window.location.href = `edit_car.php?vinNo=${vinNo}`;
            }




            function deleteCar(button) 
            {
                const vinNo = button.dataset.vin;

                // CONFIRM DELETION
                const confirmed = confirm('Are you sure you want to unlist this car?');

                if (confirmed) 
                    {
                        const confirmationPopup = document.createElement('div');
                        confirmationPopup.className = 'confirmation-popup';
                        confirmationPopup.innerHTML = `
                            <h3>Car Unlisted</h3>
                            <p>The car has been successfully unlisted.</p>
                            <button onclick="closeConfirmationPopup()">Close</button>
                        `;

                        const overlay = document.createElement('div');
                        overlay.className = 'overlay';

                        document.body.appendChild(overlay);
                        document.body.appendChild(confirmationPopup);

                        // AJAX REQUEST DELETE CAR
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'delete_car.php', true);
                         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function () 
                        {
                            if (xhr.readyState === 4 && xhr.status === 200) 
                                {
                                    button.closest('.carListing').remove();
                                }
                        };
                        xhr.send('vinNo=' + encodeURIComponent(vinNo));
                    }
            }

                    // fUNCTION TO HANDLE MARKING CAR AS SOLD
                    function markAsSold(button) 
                    {
                        const vinNo = button.dataset.vin;

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'mark_as_sold.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function () 
                        {
                            if (xhr.readyState === 4) 
                                {
                                    console.log(`Response: ${xhr.responseText}`);

                                    if (xhr.status === 200 && xhr.responseText === 'success') 
                                        {
                                            button.style.backgroundColor = 'red';
                                            button.style.color = 'white';
                                            console.log(`Car with VIN ${vinNo} marked as sold.`);
                                        } 
                                    else 
                                        {
                                            console.log('Error marking the car as sold.');
                                        }
                                }
                        };
                        xhr.send('vinNo=' + encodeURIComponent(vinNo));
                    }


            // CLOSE POP UP CONFIRMATION
            function closeConfirmationPopup() 
                {
                    const confirmationPopup = document.querySelector('.confirmation-popup');
                    const overlay = document.querySelector('.overlay');

                    if (confirmationPopup && overlay) 
                        {
                            document.body.removeChild(confirmationPopup);
                            document.body.removeChild(overlay);
                        }
                }

            
        </script>

                <footer id="footer" class="footer-hidden">
                    <p>© Gear Trade Hub 2024</p>
                </footer>

        <script>
            document.addEventListener('DOMContentLoaded', function () 
                {
                    const footer = document.getElementById('footer');

                    function showFooter() 
                        {
                            footer.classList.remove('footer-hidden');
                            footer.classList.add('footer-visible');
                        }

                    function hideFooter() 
                        {
                            footer.classList.remove('footer-visible');
                            footer.classList.add('footer-hidden');
                        }

                    window.addEventListener('scroll', function () 
                    {
                        if (window.innerHeight + window.scrollY >= document.body.offsetHeight) 
                            {
                                showFooter();
                            } 
                        else 
                            {
                                hideFooter();
                            }
                    });

                    window.addEventListener('mousemove', function (event) 
                    {
                        const mouseY = event.clientY;
                        const windowHeight = window.innerHeight;

                        if (mouseY >= windowHeight - 10) 
                            {
                                showFooter();
                            } 
                        else 
                            {
                                hideFooter();
                            }
                    });


                });
        </script>
    </body>
</html>
