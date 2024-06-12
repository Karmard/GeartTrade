<?php
session_start();

if (!isset($_SESSION['UserID'])) 
{
    header("Location: login.php");
    exit();
}

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $vinNo = $_POST["vinNo"];
    $carName = $_POST["carName"];
    $brand = $_POST["brand"];
    $vehicleType = $_POST["vehicleType"];
    $transmission = $_POST["transmission"];
    $carCondition = $_POST["carCondition"];
    $mileage = $_POST["mileage"];
    $price = $_POST["price"];

    $targetDir = "uploads/";

    function uploadImage($file, $targetDir) 
    {
        if ($file['size'] > 0) 
        {
            $targetFile = $targetDir . basename($file["name"]);
            move_uploaded_file($file["tmp_name"], $targetFile);
            return $targetFile;
        }
         else 
         {
            return "";
        }
    }


    $frontImage = uploadImage($_FILES["frontImage"], $targetDir);
    $sideLeftImage = uploadImage($_FILES["sideLeftImage"], $targetDir);
    $sideRightImage = uploadImage($_FILES["sideRightImage"], $targetDir);
    $backImage = uploadImage($_FILES["backImage"], $targetDir);
    $interiorImage = uploadImage($_FILES["interiorImage"], $targetDir);
    $dashboardImage = uploadImage($_FILES["dashboardImage"], $targetDir);


    $sql = "INSERT INTO carreg (UserID, vinNo, carName, brand, vehicleType, transmission, carCondition, mileage, frontimage, sideLeftimage, sideRightimage, backimage, interiorimage, dashboardimage, price)
            VALUES ('{$_SESSION['UserID']}', '$vinNo', '$carName', '$brand', '$vehicleType', '$transmission', '$carCondition', '$mileage', '$frontImage', '$sideLeftImage', '$sideRightImage', '$backImage', '$interiorImage', '$dashboardImage', '$price')";

    if ($connection->query($sql) === TRUE) 
    {
        echo "<script>alert('Car registered successfully!');</script>";
    } 
    else 
    {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Registration</title>
    <link rel="stylesheet" href="carregistration.css">
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
                <li><a href="account.php">Back Admin</a></li>
                <li><a href="help.html">Help</a></li>
            </ul>
        </nav>

    </header>

<div class="registration-container">

<div class="text-input-container">
    <h2>List New Car</h2>
    <form action="carregistration.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <!-- TEXT INPUT FIELDS -->
        
        <label for="vinNo">VIN Number:</label>
        <input type="text" id="vinNo" name="vinNo" required>

        <label for="carName">Car Name:</label>
        <input type="text" id="carName" name="carName" required>

        <label for="brand">Brand:</label>
        <input type="text" id="brand" name="brand" required>

        <label for="vehicleType">Vehicle Type:</label>
        <select id="vehicleType" name="vehicleType" required>
            <option value="SUV">SUV</option>
            <option value="Hatchback">Hatchback</option>
            <option value="Sedan">Sedan</option>
            <option value="Station Wagon">Station Wagon</option>
            <option value="Minivan">Minivan</option>
            <option value="Coupe">Coupe</option>
            <option value="Convertible">Convertible</option>
            <option value="Truck">Truck</option>
            <option value="Pickup Truck">Pickup Truck</option>
        </select>

        <label for="transmission">Transmission:</label>
        <select id="transmission" name="transmission" required>
            <option value="Manual">Manual</option>
            <option value="Automatic">Automatic</option>
            <option value="Hybrid">Hybrid</option>
            <option value="Electric">Electric</option>
        </select>

        <label for="carCondition">Condition:</label>
        <select id="carCondition" name="carCondition" required>
            <option value="New">New</option>
            <option value="Used">Used</option>
        </select>

        <label for="mileage">Mileage:</label>
        <input type="text" id="mileage" name="mileage" required>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>
</div>

<div class="image-upload-container">
<h2>Upload Images below</h2>

<label for="frontImage">
    Front Image
    <input type="file" id="frontImage" name="frontImage" accept="image/*" onchange="previewImage(this)">
    <img id="frontImagePreview" alt="Front Image Preview" style="max-width: 100%; max-height: 150px; display: none;">
</label>

<label for="sideLeftImage">
    Left side image
    <input type="file" id="sideLeftImage" name="sideLeftImage" accept="image/*" onchange="previewImage(this)">
    <img id="sideLeftImagePreview" alt="Side Left Image Preview" style="max-width: 100%; max-height: 150px; display: none;">
</label>

<label for="sideRightImage">
    Right side image
    <input type="file" id="sideRightImage" name="sideRightImage" accept="image/*" onchange="previewImage(this)">
    <img id="sideRightImagePreview" alt="Side Right Image Preview" style="max-width: 100%; max-height: 150px; display: none;">
</label>

<label for="backImage">
    Back image
    <input type="file" id="backImage" name="backImage" accept="image/*" onchange="previewImage(this)">
    <img id="backImagePreview" alt="Back Image Preview" style="max-width: 100%; max-height: 150px; display: none;">
</label>

<label for="interiorImage">
    Interior image
    <input type="file" id="interiorImage" name="interiorImage" accept="image/*" onchange="previewImage(this)">
    <img id="interiorImagePreview" alt="Interior Image Preview" style="max-width: 100%; max-height: 150px; display: none;">
</label>

<label for="dashboardImage">
    Dashboard image
    <input type="file" id="dashboardImage" name="dashboardImage" accept="image/*" onchange="previewImage(this)">
    <img id="dashboardImagePreview" alt="Dashboard Image Preview" style="max-width: 100%; max-height: 150px; display: none;">
</label>
<button type="submit">Register Car</button>
</form>
</div>
</div>

    <script>

        function validateForm() 
        {
            // CHECK IF ALL THE IMAGE FIELDS ARE FILLED
            const imageInputs = document.querySelectorAll('input[type="file"]');
            for (const input of imageInputs) 
            {
                if (input.files.length === 0) 
                {
                    alert('Please upload all necessary images.');
                    return false;
                }
            }
            return true;
        }

        function previewImage(input) 
        {
            const previewId = input.id + 'Preview';
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) 
            {
                const reader = new FileReader();

                reader.onload = function (e) 
                {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            } 
            else 
            {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
