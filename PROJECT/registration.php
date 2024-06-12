<?php
include('connection.php');

// CHECK IF FORM HAS BEEN SUBMITTED
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($connection, $_POST['confirmPassword']);
    $usertype = mysqli_real_escape_string($connection, $_POST['usertype']);
    $wnumber = mysqli_real_escape_string($connection, $_POST['wnumber']);

    // CHECK IF THE PASSWORDS MATCH
    if ($password !== $confirmPassword) 
    {
        die("Passwords do not match. Please try again.");
    }

    // INSERT INTO USERS TABLE
    $insertUserQuery = "INSERT INTO users (username, email, password, usertype, wnumber) VALUES ('$username', '$email', '$password', '$usertype', '$wnumber')";
    $resultUser = mysqli_query($connection, $insertUserQuery);

    if (!$resultUser) 
    {
        die("Error inserting user data: " . mysqli_error($connection));
    }

    // GET THE GENERATED USER ID
    $userID = mysqli_insert_id($connection);

    // CHECK USER TYPE AND INSERT DATA ACCORDINGLY
    if ($usertype == 'personal') 
    {
        $pFname = mysqli_real_escape_string($connection, $_POST['pFname']);
        $pLname = mysqli_real_escape_string($connection, $_POST['pLname']);
        $IDNo = mysqli_real_escape_string($connection, $_POST['IDNo']);

        // FILE UPLOAD FOR ID PROOF
        $IDproofFileName = basename($_FILES["IDproof"]["name"]);
        $IDproofTargetPath = "uploads/" . $IDproofFileName;

        // CHECK FILE UPLOAD
        if (move_uploaded_file($_FILES["IDproof"]["tmp_name"], $IDproofTargetPath)) {
        } 
        else 
        {
            die("Sorry, there was an error uploading your ID proof.");
        }

        // INSERT DATA TO PERSONALLOG TABLE
        $insertPersonalQuery = "INSERT INTO personallog (UserID, username, email, IDNo, IDproof, pFname, pLname, password, wnumber) VALUES ('$userID', '$username', '$email', '$IDNo', '$IDproofTargetPath', '$pFname', '$pLname', '$password', '$wnumber')";
        $resultPersonal = mysqli_query($connection, $insertPersonalQuery);

        if (!$resultPersonal) 
        {
            die("Error inserting personal data: " . mysqli_error($connection));
        }
    } elseif ($usertype == 'showroom') 
    {
        $showname = mysqli_real_escape_string($connection, $_POST['showname']);
        $location = mysqli_real_escape_string($connection, $_POST['location']);

        // FILE UPLOAD FOR LICENCE
        $licenceFileName = basename($_FILES["licence"]["name"]);
        $licenceTargetPath = "uploads/" . $licenceFileName;

        // CHECK FILE UPLOAD
        if (move_uploaded_file($_FILES["licence"]["tmp_name"], $licenceTargetPath)) {
        } 
        else
        {
            die("Sorry, there was an error uploading your licence.");
        }

        // FILE UPLOAD FOR CERTIFICATE
        $certificateFileName = basename($_FILES["certificate"]["name"]);
        $certificateTargetPath = "uploads/" . $certificateFileName;

        // CHECK FILE UPLOAD
        if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $certificateTargetPath)) {
        } 
        else
        {
            die("Sorry, there was an error uploading your certificate.");
        }

        // INSERT DATA INTO SHOWROOMLOG TABLE
        $insertShowroomQuery = "INSERT INTO showroomlog (UserID, username, email, showname, location, licence, certificate, password, wnumber) VALUES ('$userID', '$username', '$email', '$showname', '$location', '$licenceTargetPath', '$certificateTargetPath', '$password', '$wnumber')";
        $resultShowroom = mysqli_query($connection, $insertShowroomQuery);

        if (!$resultShowroom) 
        {
            die("Error inserting showroom data: " . mysqli_error($connection));
        }
    }

    if ($resultUser) 
    {
        // REDIRECT TO registration_success.php IF SUCCESSFUL
        header("Location: registration_success.php");
        exit();
    } 
    else 
    {
        // PROVIDE ERROR IF REGISTRATION FAIL
        header("Location: registration_error.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Gear Trade Hub</title>
    <link rel="stylesheet" href="registration.css">

    <style>
        .container {
            width: 60%;
            max-width: 600px;
            margin: auto;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            margin-top: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
    </style>

</head>
<body>

<header>
    <div class="logo-container">
        <a href="index.html">
            <img src="images/WhatsApp_Image_2023-09-17_at_2.41.26_PM-removebg-preview.png" alt="Company Logo">
        </a>
    </div>
    <h1>Gear Trade Hub</h1>
</header>

<div class="container">
    <form action="registration.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <!-- COMMON FIELDS FOR BOTH SHOWROOM AND PERSONAL -->
        <h2>Register New Account</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="wnumber">WhatsApp Number(+254):</label>
        <input type="text" id="wnumber" name="wnumber" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
        <label for="usertype">Register as:</label>

        <select id="usertype" name="usertype" required>
            <option value="personal">Personal</option>
            <option value="showroom">Showroom</option>
        </select>

        <!-- PERSONAL REGISTRATION FIELDS -->
        <div id="personalFields" style="display:none;">
            <label for="pFname">First Name:</label>
            <input type="text" id="pFname" name="pFname">
            <label for="pLname">Last Name:</label>
            <input type="text" id="pLname" name="pLname">
            <label for="IDNo">ID Number:</label>
            <input type="text" id="IDNo" name="IDNo">
            <label for="IDproof">ID Proof (Image):</label>
            <input type="file" id="IDproof" name="IDproof" accept="image/*">
        </div>

        <!-- SHOWROOM REGISTRATION FIELDS -->
        <div id="showroomFields" style="display:none;">
            <label for="showname">Showroom Name:</label>
            <input type="text" id="showname" name="showname">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location">
            <label for="licence">Licence (Image):</label>
            <input type="file" id="licence" name="licence" accept="image/*">
            <label for="certificate">Certificate (Image):</label>
            <input type="file" id="certificate" name="certificate" accept="image/*">
        </div>

        <button type="submit">Register Here</button>
        <p>Already have an account? <a href="login.php">Click here to log in</a></p>
    </form>
</div>

<script>
    // EVENT LISTENER FOR CHANGES IN USERTYPE DROPDOWN
    document.getElementById('usertype').addEventListener('click', function() {
        toggleFields(this.value);
    });

    function toggleFields(selectedType) 
    {
        var personalFields = document.getElementById('personalFields');
        var showroomFields = document.getElementById('showroomFields');

        personalFields.style.display = 'none';
        showroomFields.style.display = 'none';

        if (selectedType === 'personal') 
        {
            personalFields.style.display = 'block';
        } 
        else if (selectedType === 'showroom') 
        {
            showroomFields.style.display = 'block';
        }
    }

    // VALIDATE FORM FIELDS BASED ON USER TYPE
    function validateForm() 
    {
        var selectedType = document.getElementById('usertype').value;

        if (selectedType === 'personal') 
        {
            return validatePersonalFields();
        } 
        else if (selectedType === 'showroom') 
        {
            return validateShowroomFields();
        }

        return true;
    }

    // VALIDATE ADDITIONAL FIELDS FOR PERSONAL
    function validatePersonalFields() 
    {
        var pFname = document.getElementById('pFname').value;
        var pLname = document.getElementById('pLname').value;
        var IDNo = document.getElementById('IDNo').value;
        var IDproof = document.getElementById('IDproof').value;

        if (pFname === '' || pLname === '' || IDNo === '' || IDproof === '') 
        {
            alert('Please fill in all fields for Personal registration.');
            return false;
        }

        return true;
    }

    // VALIDATE ADDITIONAL FIELDS FOR SHOWROOM
    function validateShowroomFields() 
    {
        var showname = document.getElementById('showname').value;
        var location = document.getElementById('location').value;
        var licence = document.getElementById('licence').value;
        var certificate = document.getElementById('certificate').value;

        if (showname === '' || location === '' || licence === '' || certificate === '') 
        {
            alert('Please fill in all fields for Showroom registration.');
            return false;
        }

        return true;
    }
</script>

</body>
</html>
