<?php
// cHECKS WHICH USER OR PROCESS IS OPEN
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="STYLING/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-Fj4BQQV4zGJ3qOu3FuAg8MC5Mcqcsc4CVB13u3zZsPP3MRHiB4Q+BDWf76ZVQwJV" crossorigin="anonymous">

    
    <style>
    button.back-button 
    {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
    }

    button.back-button:hover 
    {
        background-color: #45a049;
    }

    footer 
    {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
    padding: 10px;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    transition: transform 0.3s ease-in-out;
    }

    .footer-hidden 
    {
    transform: translateY(100%);
    }

    .footer-visible 
    {
    transform: translateY(0);
    }

    @media screen and (max-width: 600px) 
    {
    footer 
        {
            flex-direction: row; 
            justify-content: space-around;
        }
    }
</style>





    <script>
        document.addEventListener('DOMContentLoaded', async function () 
        {
            try 
            {
                // FETCH DATA FROM DATABASE USING get_cars.php
                const response = await fetch('get_cars.php');
                const data = await response.json();

                // LOG THE DATA TO CONSOLE FOR DEBUGGING
                console.log(data);

                const carListings = document.getElementById('carListings');

                data.forEach(car => 
                {
                    const carListing = document.createElement('div');
                    carListing.className = 'carListing';

                    // CHECK IF PRICE IS VALID
                    const priceFloat = parseFloat(car.price);
                    const isValidPrice = !isNaN(priceFloat) && isFinite(priceFloat);

                    // PRICE TO 2 DECIMAL PLACES AND ADDING K / M depending on price
                    let formattedPrice = 'N/A';

                    if (isValidPrice) 
                    {
                        if (priceFloat >= 1e6) 
                        {
                            formattedPrice = (priceFloat / 1e6).toFixed(2) + ' M';
                        } 
                        else if (priceFloat >= 1e3) 
                        {
                            formattedPrice = (priceFloat / 1e3).toFixed(2) + ' K';
                        }
                        else 
                        {
                            formattedPrice = priceFloat.toFixed(2);
                        }
                    }

                    // LOG FINAL FORMATTED PRICE AND USERNAME FOR DEBUGGING
                    console.log('Formatted Price:', formattedPrice);
                    console.log('Username:', car.username);

                    carListing.innerHTML =
                        `
                        <a href="car_details.php?vinNo=${car.vinNo}&carName=${car.carName}&price=${car.price}&transmission=${car.transmission}&mileage=${car.mileage}&username=${car.username}&frontimage=${car.frontimage}&sideLeftimage=${car.sideLeftimage}&sideRightimage=${car.sideRightimage}&backimage=${car.backimage}&dashboardimage=${car.dashboardimage}&interiorimage=${car.interiorimage}">
                            <img src="${car.frontimage}" alt="${car.carName}">
                            <h3>${car.carName}</h3>
                            <p>Price: ${formattedPrice}</p>
                            <p>Listed by: ${car.username}</p>
                        </a>
                    `;

                    carListings.appendChild(carListing);
                });

                // CHECK IF USER IS LOGGED IN
                const loggedIn = <?php echo isset($_SESSION['UserID']) ? 'true' : 'false'; ?>;
                const loginButton = document.getElementById('loginButton');

                if (loggedIn) 
                {
                    loginButton.innerHTML = '<a href="logout.php">Log Out</a>';
                } 
                else 
                {
                    loginButton.innerHTML = '<a href="login.php">Log In</a>';
                }
            } catch (error) 
            {
                // HANDLE ERRORS
                console.error('Error fetching car data:', error);
            }
        });
    </script>

</head>
<body>
    
    <header>
        <div class="logo-container">
            <a href="index.php">
                <img src="images/WhatsApp_Image_2023-09-17_at_2.41.26_PM-removebg-preview.png" alt="Company Logo">
            </a>
        </div>
        <h1>Gear Trade Hub</h1>

        <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search for cars">
    <button type="button" onclick="searchCars()">Search</button>
</div>

        <nav>
            <ul>
                <li><a href="admin.php">Back to Admin</a></li>
                <li><a href="help.html">Help</a></li>
                <li id="loginButton"></li>
            </ul>
        </nav>
    </header>

    <section id="carListings">
        <!-- LISTED CARS WILL BE DISPLAYED IN THIS SECTION -->
    </section>

    <div id="scrollToTop" class="scroll-to-top">&#8593;</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () 
        {
            const scrollToTopButton = document.getElementById('scrollToTop');

            // SHOW/HIDE SCROLL TO TOP BUTTON
            window.addEventListener('scroll', function ()
            {
                console.log('Scrolling...');
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
                document.body.scrollTop = 0; // SAFARI BROWSER
                document.documentElement.scrollTop = 0; //OTHER BROWSERS
            });
        });
    </script>
    
    <script>
                function searchCars() 
                {
                    const searchInput = document.getElementById('searchInput').value;
                    console.log('Search Input:', searchInput);

                    const carListings = document.getElementById('carListings');

                    carListings.innerHTML = '';

                    fetch(`get_cars.php?search=${searchInput}`)
                        .then(response => response.json())
                        .then(data => 
                        {
                            console.log('Search Results:', data);

                            const backButton = document.createElement('button');
                            backButton.textContent = 'Go Back';
                            backButton.className = 'back-button';
                            backButton.addEventListener('click', showAllCars); 

                            carListings.appendChild(backButton);

                            if (data.length === 0) 
                            {
                                carListings.innerHTML += '<p>No results found</p>';
                            } 
                            else 
                            {
                                data.forEach(car => 
                                {
                                    const carListing = document.createElement('div');
                                    carListing.className = 'carListing';

                                    carListing.innerHTML =
                                        `<a href="car_details.php?vinNo=${car.vinNo}&carName=${car.carName}&price=${car.price}&transmission=${car.transmission}&mileage=${car.mileage}&username=${car.username}&frontimage=${car.frontimage}&sideLeftimage=${car.sideLeftimage}&sideRightimage=${car.sideRightimage}&backimage=${car.backimage}&dashboardimage=${car.dashboardimage}&interiorimage=${car.interiorimage}">
                                            <img src="${car.frontimage}" alt="${car.carName}">
                                            <h3>${car.carName}</h3>
                                            <p>Price: ${car.price}</p>
                                            <p>Listed by: ${car.username}</p>
                                        </a>`;

                                    carListings.appendChild(carListing);
                                });
                            }
                        })
                        .catch(error => 
                        {
                            console.error('Error fetching search results:', error);
                        });
                }

                function showAllCars() 
                {
                    window.location.href = 'index.php';
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
