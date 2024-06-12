<?php
    session_start();
    if (!isset($_SESSION['UserID'])) 
    {
        header("Location: login.php");
        exit();
    }

    include 'connection.php';
    $loggedInUserID = $_SESSION['UserID'];
    $userSql = "SELECT * FROM adminlog WHERE UserID = '$loggedInUserID'";
    $userResult = $connection->query($userSql);

    $sql = "SELECT * FROM adminlog WHERE UserID != '$loggedInUserID'";
    $result = $connection->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List</title>
    <link rel="stylesheet" href="admin_list.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            if ($userResult->num_rows > 0) 
            {
                $userRow = $userResult->fetch_assoc();
                ?>
                <img src="<?php echo $userRow['img']; ?>" alt="">
                <div class="details">
                  <span><?php echo $userRow['Fname']. " " . $userRow['Lname'] ?></span>
                </div>
                <?php 
            } 
            else 
            {
              echo "<p>No admins found</p>";
            }
          ?>
        </div>
        <!-- Add logout link or button if needed -->
        <!-- <a href="#" class="logout">Logout</a> -->
      </header>
      <div class="search">
        <span class="text">Select an admin to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
        <?php
        if ($result->num_rows > 0) 
        {
          while($row = $result->fetch_assoc()) 
          {
            ?>
            
            <a href='chat.php?user_id=<?php echo $row["unique_id"]; ?>'>
                  <img src="<?php echo $row["img"]; ?>" alt="">
                  <div class="details">
                    <span><?php echo $row["Fname"]." ".$row["Lname"]; ?></span>
                  </div>
                  <div class="status-dot <?php echo ($row['status'] == 'online') ? 'online' : 'offline'; ?>"></div>
                </a>
            <?php
          }
        } 
        else 
        {
          echo "<p>No admins found</p>";
        }
        ?>
      </div>
    </section>
  </div>
</body>
</html>
