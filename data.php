<?php
    while($row = mysqli_fetch_assoc($query)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = '{$row['unique_id']}' 
                OR outgoing_msg_id = '{$row['unique_id']}') AND (outgoing_msg_id = '$outgoing_id' 
                OR incoming_msg_id = '$outgoing_id') ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        $result = ($row2) ? $row2['msg'] : "No message available";
        $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;
        $you = ($row2 && $row2['outgoing_msg_id'] == $row['unique_id']) ? "You: " : "";
        $offline = ($row['status'] == "Offline now") ? "offline" : "";
        $hid_me = ($outgoing_id == $row['unique_id']) ? "hide" : "";

        $output .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                    <div class="content">
                    <img src="' . $row['img'] . '" alt="">
                    <div class="details">
                        <span>'. $row['Fname']. " " . $row['Lname'] .'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
    }
?>
