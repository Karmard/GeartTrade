<?php
        session_start();
        include 'connection.php';

        if (!isset($_SESSION['UserID'])) 
            {
                header("Location: login.php");
                exit();
            }

        if (!isset($_GET['vinNo'])) 
            {
                header("Location: account.php"); 
                exit();
            }

        $vinNo = $_GET['vinNo'];

        $queryCar = "SELECT * FROM carreg WHERE vinNo = '{$vinNo}'";
        $resultCar = $connection->query($queryCar);

        if ($resultCar && $resultCar->num_rows > 0) 
            {
                $car = $resultCar->fetch_assoc();
            } 
        else 
            {
                echo "Car not found";
                exit();
            }

        if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                $newCarName = $_POST['carName'];
                $newPrice = $_POST['price'];

                $updateQuery = "UPDATE carreg SET carName = '{$newCarName}', price = '{$newPrice}' WHERE vinNo = '{$vinNo}'";
                if ($connection->query($updateQuery) === TRUE) 
                    {
                        echo "Car details updated successfully";
                        header("Location: account.php");
                        exit();
                    } 
                else 
                    {
                        echo "Error updating car details: " . $connection->error;
                    }
            }

        $connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car Details</title>
    <style>
        body 
        {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        h1 
        {
            text-align: center;
            color: #333; 
            margin-top: 20px; 
        }

        .container 
        {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form 
        {
            margin-top: 20px;
        }

        label 
        {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="number"] 
        {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] 
        {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover 
        {
            background-color: #0056b3;
        }

        img 
        {
            display: block;
            margin: 20px auto;
            max-width: 100%;
            height: auto;
        }
        img 
        {
            display: block;
            margin: 20px auto; 
            max-width: 100%; 
            height: auto;
            max-height: 300px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <h1>Editing details for <?php echo $car['carName']; ?></h1>
    <img src="<?php echo $car['frontimage']; ?>" alt="Car Front Image" style="display: block; margin: 0 auto; max-width: 100%; height: auto;">

    <div class="container">
        <form method="POST">
            <label for="carName">Car Name:</label>
            <input type="text" id="carName" name="carName" value="<?php echo $car['carName']; ?>" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $car['price']; ?>" required>

            <button type="submit">Save Changes</button>

        </form>
    </div>
</body>
</html>
