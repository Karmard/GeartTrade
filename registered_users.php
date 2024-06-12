<?php
        session_start();
        if (!isset($_SESSION['UserID'])) 
        {
            header("Location: login.php");
            exit();
        }

        require_once("connection.php");

        $searchQuery = isset($_GET['searchQuery']) ? '%' . $_GET['searchQuery'] . '%' : '%';

        $queryUsers = "SELECT u.UserID, u.username, u.email, u.wnumber, u.usertype, p.pFname, p.pLname, s.showname, u.suspended
                        FROM users u
                        LEFT JOIN personallog p ON u.UserID = p.UserID
                        LEFT JOIN showroomlog s ON u.UserID = s.UserID
                        WHERE u.username LIKE ?";
                        
        $stmt = $connection->prepare($queryUsers);
        $stmt->bind_param("s", $searchQuery);
        $stmt->execute();
        $resultUsers = $stmt->get_result();

        if ($resultUsers->num_rows == 0 && !empty($_GET['searchQuery'])) 
        {
            $errorMessage = "Sorry! Unfortunately, the user is not in our system. Please check your spelling or look for another name.";
        }

        $stmt->close();
        mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <link rel="stylesheet" href="STYLING/admin.css">
    <link rel="stylesheet" href="STYLING/registered_users.css">
    <style>
        .error-message-container 
        {
            margin: 20px auto;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 40px;
            text-align: center;
        }

        .error-message 
        {
            color: #721c24;
            font-size: 16px;
            font-weight: bold;
        }

    </style>
</head>
<body>
<header>
    <h1>Registered Users</h1>

    <div class="search-bar">
        <form action="registered_users.php" method="GET">
            <input type="text" id="searchInput" name="searchQuery" placeholder="Search for users">
            <button type="submit">Search</button>
        </form>
    </div>


</header>

<div class="navbar-icon" onclick="toggleNavbar()">
    <i class="fas fa-bars" style="font-size: 24px; color: white;"></i>
</div>

<div class="content-container">
    <table>
        <thead>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>W-Number</th>
            <th>User Type</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Showroom Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($user = $resultUsers->fetch_assoc()) : ?>
            <tr data-user-id="<?= $user['UserID'] ?>">
                <td><?= $user['UserID'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['wnumber'] ?></td>
                <td><?= $user['usertype'] ?></td>
                <td><?= $user['pFname'] ?></td>
                <td><?= $user['pLname'] ?></td>
                <td><?= $user['showname'] ?></td>
                <td>

                    <button onclick="viewUser(<?= $user['UserID'] ?>)">View</button>
                    <button class="suspend-button" data-user-id="<?= $user['UserID'] ?>" onclick="suspendUser(<?= $user['UserID'] ?>)">
                        <?= ($user['suspended'] == 1) ? 'Unsuspend' : 'Suspend' ?>
                    </button>
                    <button class="delete" onclick="deleteAccount(<?= $user['UserID'] ?>)">Delete Account</button>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <button class="back-button" onclick="goBack()">Back to Admin Home</button>
</div>

<script>
    function viewUser(userId)
    {
        window.location.href = 'user_details.php?userId=' + userId;
    }

    function suspendUser(userId) 
    {
        var suspendedRow = document.querySelector("tr[data-user-id='" + userId + "']");
        var suspendButton = suspendedRow.querySelector(".suspend-button");

        if (suspendButton.textContent.trim() === "Unsuspend") 
        {
            var confirmUnsuspend = confirm("Are you sure you want to unsuspend the account?");

            if (confirmUnsuspend) 
            {
                var xhr = new XMLHttpRequest();

                xhr.open("GET", "unsuspend_account.php?userId=" + userId, true);

                xhr.onreadystatechange = function () 
                {
                    if (xhr.readyState == 4 && xhr.status == 200) 
                    {
                        alert(xhr.responseText);

                        if (xhr.responseText === "Account unsuspended successfully.") 
                        {
                            // Update button text
                            suspendButton.textContent = "Suspend";
                        }
                    }
                };

                xhr.send();
            } 
            else 
            {
                console.log('Unsuspend canceled by admin');
            }
        }
        else 
        {
            // PROMPT FOR SUSPENSION MESSAGE
            var username = suspendedRow.querySelector("td:nth-child(2)").textContent.trim();
            var suspensionMessage = prompt("Enter suspension message for the user:", "");

            if (suspensionMessage !== null) 
            {
                var confirmSuspend = confirm("Are you sure you want to suspend the account?");

                if (confirmSuspend) 
                {
                    var xhr = new XMLHttpRequest();

                    xhr.open("GET", "suspend_account.php?userId=" + userId + "&suspensionMessage=" + encodeURIComponent(suspensionMessage), true);

                    xhr.onreadystatechange = function () 
                    {
                        if (xhr.readyState == 4 && xhr.status == 200) 
                        {
                            alert(xhr.responseText);

                            if (xhr.responseText === "Account suspended successfully.") 
                            {
                                suspendButton.textContent = "Unsuspend";
                            }
                        }
                    };

                    xhr.send();
                } 
                else 
                {
                    console.log('Suspension canceled by admin');
                }
            } 
            else 
            {
                console.log('Suspension message canceled by admin');
            }
        }
    }




    function deleteAccount(userId) 
    {
        var confirmDelete = confirm("Are you sure you want to delete the account?");

        if (confirmDelete) 
        {
            var xhr = new XMLHttpRequest();

            xhr.open("GET", "delete_account.php?userId=" + userId, true);

            xhr.onreadystatechange = function () 
            {
                if (xhr.readyState == 4 && xhr.status == 200) 
                {
                    alert(xhr.responseText);
                    location.reload();
                }
            };

            xhr.send();
        } 
        else 
        {
            console.log('Deletion canceled by admin');
        }
    }




    function goBack()
    {
        window.location.href = 'admin.php';
    }
</script>

<?php if (isset($errorMessage)): ?>
    <div class="error-message-container">
        <div class="error-message"><?php echo $errorMessage; ?></div>
    </div>
<?php endif; ?>

</body>
</html>
