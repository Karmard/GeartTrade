<?php
session_start();
include_once "connection.php"; // Include your connection script

// Check if the user is logged in
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit(); // Stop further execution
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if Admin ID and Image are provided
    if (!empty($_POST['admin_id']) && isset($_FILES['image'])) {
        $admin_id = $_POST['admin_id'];
        $image = $_FILES['image'];

        // Check for errors during file upload
        if ($image['error'] !== UPLOAD_ERR_OK) {
            echo "Error uploading image";
            exit(); // Stop further execution
        }

        // Move uploaded image to profile folder
        $target_dir = "profile/";
        $target_file = $target_dir . basename($image['name']);
        if (!move_uploaded_file($image['tmp_name'], $target_file)) {
            echo "Error moving image file";
            exit(); // Stop further execution
        }

        // Update the img column in the adminlog table
        $sql = "UPDATE adminlog SET img = '$target_file' WHERE UserID = '$admin_id'";
        if ($connection->query($sql) === TRUE) {
            echo "Image added successfully";
        } else {
            echo "Error updating image: " . $connection->error;
        }
    } else {
        echo "Admin ID or Image not provided";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Image</title>
</head>
<body>
  <h2>Add Image for Admin</h2>
  <?php
  // Query to retrieve admin data from the database
  $sql = "SELECT * FROM adminlog";
  $result = $connection->query($sql);

  // Check if there are any admins in the database
  if ($result->num_rows > 0) {
      // Output data of each admin
      while ($row = $result->fetch_assoc()) {
          echo "<div class='admin-item'>";
          echo "<span>{$row['Fname']} {$row['Lname']}</span>";
          echo "<form action='' method='post' enctype='multipart/form-data'>";
          echo "<input type='hidden' name='admin_id' value='{$row['UserID']}'>";
          echo "<input type='file' name='image' accept='image/*'>";
          echo "<button type='submit'>Upload Image</button>";
          echo "</form>";
          echo "</div>";
      }
  } else {
      echo "No admins found in the database";
  }
  ?>
</body>
</html>
