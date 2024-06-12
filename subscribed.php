<?php
    session_start();
    if (!isset($_SESSION['UserID'])) 
        {
            header("Location: login.php");
            exit();
        }

    require_once("connection.php");

    $query = "SELECT u.UserID, u.username, u.email, s.end_date 
            FROM users u
            INNER JOIN subscription s ON u.UserID = s.UserID
            WHERE s.end_date > NOW()"; 
    $result = mysqli_query($connection, $query);

    $subscribed_users = [];

    if ($result) 
        {
            $subscribed_users = mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            // CALCULATE NUMBER OF DAYS THE SUBS HAS LEFT
            foreach ($subscribed_users as &$user) 
                {
                    $end_date = strtotime($user['end_date']);
                    $current_date = time();
                    $days_remaining = ceil(($end_date - $current_date) / (60 * 60 * 24)); // CALC REMAINING DAYS
                    $user['days_remaining'] = $days_remaining;
                }
            unset($user);
        } 
    else 
        {
            echo "Error fetching subscribed users: " . mysqli_error($connection);
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribed Clients - Gear Trade Hub</title>
    <link rel="stylesheet" href="STYLING/subscribed.css">

</head>
<body>
            <header>
                <h1>Subscribed Users</h1>

                <div class="search-bar">
                    <form action="registered_users.php" method="GET">
                        <input type="text" id="searchInput" name="searchQuery" placeholder="Search for users">
                        <button type="submit">Search</button>
                    </form>
                </div>  
                <style>
                    .orange-button 
                    {
                        background-color: orange;
                        color: white;
                    }
                </style>
            </header>

    <div class="content">
        <?php if (!empty($subscribed_users)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Subscription End Date</th>
                        <th>Days Remaining</th>
                        <th>Action</th>
                        <th>Send Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscribed_users as $user) : ?>
                        <tr>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['end_date']; ?></td>
                            <td><?php echo $user['days_remaining']; ?></td>
                            <td><button onclick="cancelSubscription(<?php echo $user['UserID']; ?>)">Cancel Subscription</button></td>
                            <td>
                                <!-- CONDINTION IF REM DAYS IS LESS THT 2 -->
                                <?php if ($user['days_remaining'] < 2) : ?> 
                                    <button class="orange-button" onclick="sendConfirmationEmail(<?php echo $user['UserID']; ?>)">Send Email</button>
                                <?php else : ?>
                                    <button onclick="sendConfirmationEmail(<?php echo $user['UserID']; ?>)">Send Email</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No subscribed users found.</p>
        <?php endif; ?>
    </div>

                        <section id="subscribeSection">
                            <button id="subscribeButton" onclick="window.location.href = 'admin.php'">Back Home</button>
                            <p id="subscriptionStatus"></p>
                        </section>  

    <footer>
        <p>© Gear Trade Hub 2024</p>
    </footer>

    <script>
        function cancelSubscription(userID) 
        {
            location.reload();
        }
    </script>
</body>
</html>
