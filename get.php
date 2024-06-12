<?php
session_start();
include_once "connection.php";

if(isset($_SESSION['UserID'])) 
{
    $outgoing_id = $_SESSION['UserID']; // Assuming UserID is set in the session

    // Retrieve messages from the database
    $query = "SELECT * FROM messages WHERE incoming_msg_id = '$outgoing_id' OR outgoing_msg_id = '$outgoing_id'";
    $result = mysqli_query($connection, $query);
    if($result && mysqli_num_rows($result) > 0) 
    {
        $messages = [];
        while($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
        // Return JSON response
        echo json_encode($messages);
    } 
    else 
    {
        // No messages found
        echo "You don't have any chats with this admin 😊😊";
    }
} 
else 
{
    // UserID not set in session
    echo "User not logged in";
}
?>
