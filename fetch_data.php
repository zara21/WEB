<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT title, description, photo, author, creation_date FROM your_table_name";
$result = $conn->query($sql);

$data = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    die("Error in SQL query: " . $conn->error);
}

$conn->close();

// Send only the JSON-encoded data as the response
header('Content-Type: application/json');
echo json_encode($data);
?>
