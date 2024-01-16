<?php
// Enable CORS for specific origin(s) - replace with your actual domain during production
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: *");

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "new_table";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT title, description, author, creation_date, photo FROM your_table_name";
$result = $conn->query($sql);

// Store the result in an associative array
$data = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    die("Error in SQL query: " . $conn->error);
}

$conn->close();

// Convert the data to JSON format
$json_data = json_encode($data);


// Output JSON data
header('Content-Type: application/json');
echo $json_data;

// Close connection
$conn->close();
?>
