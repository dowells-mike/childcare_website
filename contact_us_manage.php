<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require_once '../../connection.php';

$sql = "SELECT * FROM contact_us_message";
$result = $db_connection->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Phone Number</th>";
    echo "<th>Message</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['phone_number'] . "</td>";
        echo "<td>" . $row['message'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "No messages found.";
}

$db_connection->close();
?>
