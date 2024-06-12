<?php
            session_start();

                // CHECK IF USER HAS ADMIN PRIVILEGES
                if (!isset($_SESSION['UserID'])) 
                {
                    // DIRECT TO LOGIN PAGE IF NOT
                    header("Location: login.php");
                    exit();
                }

                require_once("connection.php");

                // GET ADMIN FIRST NAME FROM adminlog FOR THE GREETING
                $userID = $_SESSION['UserID'];
                $queryAdmin = "SELECT Fname FROM adminlog WHERE UserID = ?";
                $stmtAdmin = mysqli_prepare($connection, $queryAdmin);
                mysqli_stmt_bind_param($stmtAdmin, "i", $userID);
                mysqli_stmt_execute($stmtAdmin);
                $resultAdmin = mysqli_stmt_get_result($stmtAdmin);

                if (mysqli_num_rows($resultAdmin) == 1) 
                {
                    $admin = mysqli_fetch_assoc($resultAdmin);
                    $adminFirstName = $admin['Fname'];
                }
                else 
                {
                    // SHOW ADMIN IF THE ADMIN IS MISSING FIRST NAME
                    $adminFirstName = "Admin";
                }


                    // GET TOTAL TOTAL USERS
                    $queryTotalUsers = "SELECT COUNT(*) as totalUsers FROM users";
                    $resultTotalUsers = mysqli_query($connection, $queryTotalUsers);
                    $totalUsers = mysqli_fetch_assoc($resultTotalUsers)['totalUsers'];

                    // GET TOTAL PERSONAL USERS
                    $queryTotalPersonalUsers = "SELECT COUNT(*) as totalPersonalUsers FROM personallog";
                    $resultTotalPersonalUsers = mysqli_query($connection, $queryTotalPersonalUsers);
                    $totalPersonalUsers = mysqli_fetch_assoc($resultTotalPersonalUsers)['totalPersonalUsers'];

                    // GET TOTAL SHOWROOM USERS
                    $queryTotalShowroomUsers = "SELECT COUNT(*) as totalShowroomUsers FROM showroomlog";
                    $resultTotalShowroomUsers = mysqli_query($connection, $queryTotalShowroomUsers);
                    $totalShowroomUsers = mysqli_fetch_assoc($resultTotalShowroomUsers)['totalShowroomUsers'];

                    $querySuspendedUsers = "SELECT username, wnumber, email FROM users WHERE suspended = 1";
                    $resultSuspendedUsers = mysqli_query($connection, $querySuspendedUsers);

            // CLOSE DB CONNECTION
            mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin home</title>
            <link rel="stylesheet" href="STYLING/admin.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" />


            <style>

        </style>      

        </head>

        <body>
            <header class="header">
                <div class="header-content">
                    <div class="logo-container">
                        <a href="admin.php">
                            <img src="images/WhatsApp_Image_2023-09-17_at_2.41.26_PM-removebg-preview.png" alt="Company Logo">
                        </a>
                    </div>
                    <h1>Gear Trade Hub</h1>
                </div>

                <div class="search-bar">
                    <form action="registered_users.php" method="GET">
                        <input type="text" id="searchInput" name="searchQuery" placeholder="Search for users">
                        <button type="submit">Search</button>
                    </form>
                </div>


                <div class="header-icons">
                    <img src="images/icons8-notification-bell-50.png" alt="Notification Bell" class="notification-bell" onclick="showNotifications()">

                    <div class="dropdown" id="dropdownMenu">
                    <img src="images/icons8-user-50.png" alt="User Icon" class="user-icon" onclick="toggleDropdown()">

                    <div class="dropdown-content">
                        <a href="admin_profile.php">My Profile</a>
                        <a href="#">Change Password</a>
                        <a href="logout.php">Log Out</a>
                    </div>
                    
                    </div>
                </div>
            </header>

            <div class="navbar-icon" onclick="toggleNavbar()">
                <i class="fas fa-bars" style="font-size: 24px; color: white;"></i>

            </div>

            <div class="navbar">

                <div id="greeting" class="navbar-greeting"></div>

                    <a href="admin.php"><i class="fa fa-building"></i>Home</a>
                    <a href="index2.php"><i class="fas fa-home"></i>Clients' Home</a>
                    <a href="audits.php"><i class="fas fa-file-alt"></i>Audit</a>
                    <a href="registered_users.php"><i class="fas fa-users"></i>Registered Users</a>
                    <a href="subscribed.php"><i class="fa fa-credit-card"></i>Subscribed clients</a>

            </div>



            <div class="section-container">

                <div class="left-section section">
                    <div class="rectangle">
                        <h2><i class="fas fa-users"></i>Total Users</h2>
                        <p><?php echo $totalUsers; ?></p>

                    </div>
                </div>


                <div class="middle-section section">
                    <div class="rectangle">
                        <h2><i class="fas fa-user"></i>Individual(s)</h2>
                        <p><?php echo $totalPersonalUsers; ?></p>

                    </div>
                </div>



                <div class="right-section section">
                    <div class="rectangle">
                        <h2><i class="fas fa-store"></i>Showroom(s)</h2>
                        <p><?php echo $totalShowroomUsers; ?></p>

                    </div>
                </div>
            </div>



            <div class="approve-section-container">

                    <div class="left-approve-section">
                        <h2>RECENT REGISTERED USERS</h2>
                        <?php
                            include('connection.php');

                            $queryRecentUsers = "SELECT UserID, username, regdate FROM users WHERE regdate >= DATE_SUB(NOW(), INTERVAL 2 DAY) ORDER BY regdate DESC LIMIT 5";
                            $resultRecentUsers = mysqli_query($connection, $queryRecentUsers);

                            if ($resultRecentUsers) 
                            {
                                while ($recentUser = mysqli_fetch_assoc($resultRecentUsers)) 
                                {
                                    echo '<div class="recent-user">';
                                    echo '<p>Username: ' . $recentUser['username'] . '</p>';
                                    echo '<p>Registration Date: ' . $recentUser['regdate'] . '</p>';
                                    echo '<button onclick="viewUserDetails(' . $recentUser['UserID'] . ')">View</button>';
                                    echo '</div>';
                                }
                            }
                            else 
                            {
                                echo '<p>No recent registrations.</p>';
                            }

                            mysqli_free_result($resultRecentUsers);
                            mysqli_close($connection);
                        ?>
                    </div>

                    <script>
                        function viewUserDetails(userId) 
                        {
                            window.location.href = 'view_user.php?userId=' + userId;
                        }
                    </script>


                    <div class="right-approve-section">
                        <h2>Suspended user(s)</h2>
                    
                        <?php
                        // IS USER SUSPENDED?
                        if (mysqli_num_rows($resultSuspendedUsers) > 0) 
                        {
                            echo '<ul>';
                            while ($suspendedUser = mysqli_fetch_assoc($resultSuspendedUsers)) 
                            {
                                echo '<li>';
                                echo 'Username: ' . $suspendedUser['username'] . '<br>';
                                echo 'Wnumber: ' . $suspendedUser['wnumber'] . '<br>';
                                echo 'Email: ' . $suspendedUser['email'] . '<br>';
                                echo '</li>';
                            }
                            echo '</ul>';
                        } 
                        else 
                        {
                            echo '<p>No suspended users.</p>';
                        }
                        ?>
                    </div>
            </div>

            <div id="scrollToTop" class="scroll-to-top">&#8593;</div>

            <script>
                function showNotifications() 
                {
                    window.location.href = 'admin_list.php';
                }

                function openUserProfile() 
                {
                    console.log('Opening user profile...');
                }

                document.addEventListener('DOMContentLoaded', function () 
                {
                    const scrollToTopButton = document.getElementById('scrollToTop');

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

                    scrollToTopButton.addEventListener('click', function () 
                    {
                        document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;
                    });
                });

                function toggleNavbar() 
                {
                    const navbar = document.querySelector('.navbar');
                    if (navbar.style.left === '0px') 
                    {
                        navbar.style.left = '-250px';
                    } 
                    else 
                    {
                        navbar.style.left = '0px';
                    }
                }
            </script>

        <script>
                document.addEventListener('DOMContentLoaded', function () 
                {
                    const greetingElement = document.getElementById('greeting');

                    // CHECK THE CURRENT TIME
                    const currentHour = new Date().getHours();

                    // SET GREETING TO CURRENT TIME
                    if (currentHour >= 5 && currentHour < 12) 
                    {
                        greetingElement.textContent = "Good morning, <?php echo $adminFirstName; ?>!";
                    } 
                        else if (currentHour >= 12 && currentHour < 18) 
                        {
                            greetingElement.textContent = "Good afternoon, <?php echo $adminFirstName; ?>!";
                        } 
                    else 
                    {
                        greetingElement.textContent = "Good evening, <?php echo $adminFirstName; ?>!";
                    }
                });
            </script>

            <script>

                function toggleDropdown() 
                {
                var dropdownContent = document.querySelector('.dropdown-content');
                dropdownContent.classList.toggle('show');
                }

                window.onclick = function(event) {
                if (!event.target.matches('.user-icon')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    var i;
                    for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                    }
                }
                }

            </script>
        </body>
</html>
  