<?php
            session_start();
            if (!isset($_SESSION['UserID'])) 
                {
                    header("Location: login.php");
                    exit();
                }

            require_once("connection.php");

            if (isset($_GET['userId'])) 
            {
                $userId = $_GET['userId'];

                $queryUserDetails = "SELECT u.username, u.usertype, p.IDNo, p.IDproof, s.location, s.licence, s.certificate
                                    FROM users u
                                    LEFT JOIN personallog p ON u.UserID = p.UserID
                                    LEFT JOIN showroomlog s ON u.UserID = s.UserID
                                    WHERE u.UserID = ?";
                $stmtUserDetails = mysqli_prepare($connection, $queryUserDetails);
                mysqli_stmt_bind_param($stmtUserDetails, "i", $userId);
                mysqli_stmt_execute($stmtUserDetails);
                $resultUserDetails = mysqli_stmt_get_result($stmtUserDetails);

                if ($userDetails = mysqli_fetch_assoc($resultUserDetails)) 
                    {
                        $username = $userDetails['username'];
                        $userType = $userDetails['usertype'];
                        $IDNo = $userDetails['IDNo'];
                        $IDproof = $userDetails['IDproof'];
                        $location = $userDetails['location'];
                        $licence = $userDetails['licence'];
                        $certificate = $userDetails['certificate'];

                        // Fetch cars listed by the user
                        $queryListedCars = "SELECT * FROM carreg WHERE UserID = ?";
                        $stmtListedCars = mysqli_prepare($connection, $queryListedCars);
                        mysqli_stmt_bind_param($stmtListedCars, "i", $userId);
                        mysqli_stmt_execute($stmtListedCars);
                        $resultListedCars = mysqli_stmt_get_result($stmtListedCars);
                        $listedCars = mysqli_fetch_all($resultListedCars, MYSQLI_ASSOC);


                    } 

                
                else 
                    {
                        header("Location: registered_users.php");
                        exit();
                    }

                mysqli_stmt_close($stmtUserDetails);
                mysqli_stmt_close($stmtListedCars);
            } 
            else 
                {
                    header("Location: registered_users.php");
                    exit();
                }

            mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="STYLING/user.css">
    <style>


.content-container table 
        {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .content-container table th, .content-container table td 
        {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .content-container table th 
        {
            background-color: #f2f2f2;
        }

        .content-container table img 
        {
            max-width: 100px;
            height: auto;
        }

        .unlist-button 
        {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .unlist-button:hover 
        {
            background-color: #d32f2f;
        }




    </style>
</head>

<body>
    <header>
        <h1>User Details</h1>
    </header>
    <div class="content-container">
        <h2><?= $username ?>'s Details</h2>

        <table>
            <tr>
                <th>Username</th>
                <td><?= $username ?></td>
            </tr>

            <?php if ($userType === 'personal') : ?>
                <tr>
                    <th>ID Number</th>
                    <td><?= $IDNo ?></td>
                </tr>

                <tr>
                    <th>ID Proof</th>
                    <td>
                        <div class="image-container">
                            <img src="<?= $IDproof ?>" alt="ID Proof Image">
                        </div>
                    </td>
                </tr>
            <?php endif; ?>

            <?php if ($userType === 'showroom') : ?>
                <tr>
                    <th>Location</th>
                    <td><?= $location ?></td>
                </tr>

                <tr>
                    <th>Licence</th>
                    <td><img src="<?= $licence ?>" alt="Licence Image" style="max-width: 30%;"></td>
                </tr>

                <tr>
                    <th>Certificate</th>
                    <td><img src="<?= $certificate ?>" alt="Certificate Image" style="max-width: 30%;"></td>
                </tr>
            <?php endif; ?>
        </table>

        <!-- ALSO DISPLAY THE CARS THE USER HAS LISTED -->
        <?php if (!empty($listedCars)) : ?>
            <h2><?= $username ?>'s Listed Cars</h2>
            <table>
                <tr>
                    <th>Car Name</th>
                    <th>Price</th>
                    <th>Images</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($listedCars as $car) : ?>
                    <tr>
                        <td><?= $car['carName'] ?></td>
                        <td><?= $car['price'] ?></td>
                        <td>
                            <div class="image-container">
                                <img src="<?= $car['frontimage'] ?>" alt="<?= $car['carName'] ?>">
                            </div>
                        </td>
                        <td><button class="unlist-button" onclick="unlistCar(<?= $car['vinNo'] ?>)">Unlist</button></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <button class="back-button" onclick="goBack()">Back to Registered Users</button>
    </div>

    <script>
        function goBack() 
        {
            window.location.href = 'registered_users.php';
        }

        function unlistCar(vinNo) 
        {
            window.location.href = 'delete_car.php?vinNo=' + vinNo;
        }
    </script>
</body>

</html>
