<?php
$user = 'root';
$password = '';
$database = 'geeksforgeeks';
$servername = 'localhost';

$mysqli = new mysqli($servername, $user, $password, $database);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$sql = "SELECT * FROM userdata ORDER BY score DESC";
$result = $mysqli->query($sql);

while ($row = $result->fetch_assoc()) {
    // Display user information here
}

$mysqli->close();
?>
