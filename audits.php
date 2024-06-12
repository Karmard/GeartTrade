<?php
include 'connection.php';

$sql_users = "SELECT a.*, u.username AS changed_by_username 
              FROM audit_log a
              LEFT JOIN users u ON a.UserID = u.UserID
              WHERE a.table_name = 'users'";
$result_users = $connection->query($sql_users);

$sql_cars = "SELECT a.*, u.username AS changed_by_username 
             FROM audit_log a
             LEFT JOIN users u ON a.UserID = u.UserID
             WHERE a.table_name = 'carreg'";
$result_cars = $connection->query($sql_cars);

$connection->close();

function getChangedParts($oldData, $newData) 
{
    $oldArray = json_decode($oldData, true);
    $newArray = json_decode($newData, true);
    $changedParts = array();

    if ($oldArray === null) 
    {
        $oldArray = array();
    }

    if ($newArray === null) 
    {
        $newArray = array();
    }

    foreach ($newArray as $key => $value) 
    {
        $oldValue = isset($oldArray[$key]) ? $oldArray[$key] : 'NULL';
        if ($oldValue != $value) 
        {
            $changedParts[] = "$key: $oldValue -> $value";
        }
    }

    return implode("<br>", $changedParts);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log</title>
    <link rel="stylesheet" type="text/css" href="audits.css">
    <style>
   
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="admin.php">Home</a>
        <a href="index2.php">Clients' Home</a>
        <a href="audits.php">Audit</a>
        <a href="registered_users.php">Registered Users</a>
        <a href="subscribed.php">Subscribed Clients</a>
    </div>

    <div class="main-content">
        <h2>User Audit Log</h2>
        <table>
            <tr>
                <th>Table Name</th>
                <th>Action Type</th>
                <th>Record ID</th>
                <th>Changed Parts (Old -> New)</th>
                <th>Changed By</th>
                <th>Change Time</th>
            </tr>
            <?php
            if ($result_users->num_rows > 0) 
            {
                while ($row = $result_users->fetch_assoc()) 
                {
                    echo "<tr>";
                    echo "<td>" . $row["table_name"] . "</td>";
                    echo "<td>" . $row["action_type"] . "</td>";
                    echo "<td>" . $row["record_id"] . "</td>";
                    echo "<td class='changed-part'>" . getChangedParts($row["old_data"], $row["new_data"]) . "</td>";
                    echo "<td>" . ($row["changed_by_username"] ? $row["changed_by_username"] : "Unknown") . "</td>";
                    echo "<td>" . $row["change_time"] . "</td>";
                    echo "</tr>";
                }
            } 
            else 
            {
                echo "<tr><td colspan='6'>No audit log data available for users</td></tr>";
            }
            ?>
        </table>

        <h2>Car Audit Log</h2>
        <table>
            <tr>
                <th>Table Name</th>
                <th>Action Type</th>
                <th>Record ID</th>
                <th>Changed Parts (Old -> New)</th>
                <th>Changed By</th>
                <th>Change Time</th>
            </tr>
            <?php
            if ($result_cars->num_rows > 0) 
            {
                while ($row = $result_cars->fetch_assoc()) 
                {
                    echo "<tr>";
                    echo "<td>" . $row["table_name"] . "</td>";
                    echo "<td>" . $row["action_type"] . "</td>";
                    echo "<td>" . $row["record_id"] . "</td>";
                    echo "<td class='changed-part'>" . getChangedParts($row["old_data"], $row["new_data"]) . "</td>";
                    echo "<td>" . ($row["changed_by_username"] ? $row["changed_by_username"] : "Unknown") . "</td>";
                    echo "<td>" . $row["change_time"] . "</td>";
                    echo "</tr>";
                }
            } 
            else 
            {
                echo "<tr><td colspan='6'>No audit log data available for cars</td></tr>";
            }
            ?>
        </table>

        <a href="admin.php">Back to Admin Panel</a>
    </div>
</body>
</html>
