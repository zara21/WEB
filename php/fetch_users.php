<?php
// Your database connection code here

// Assuming you have connected to the database
$user = 'root';
$password = '';

// Database name is geeksforgeeks
$database = 'geeksforgeeks';

// Server is localhost with
// port number 3306
$servername = 'localhost:3306';
$mysqli = new mysqli($servername, $user, $password, $database);

// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
        $mysqli->connect_errno . ') ' .
        $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $searchQuery = $data['query'];

    // Modify the SQL query based on your database schema and search requirements
    $sql = "SELECT * FROM userdata WHERE username LIKE '%$searchQuery%' ORDER BY score DESC";

    $result = $mysqli->query($sql);

    if ($result) {
        $userData = [];

        while ($row = $result->fetch_assoc()) {
            // Format database results into an associative array
            $userData[] = [
                'username' => $row['username'],
                'problems' => $row['problems'],
                'score' => $row['score'],
                'articles' => $row['articles'],
                'image' => base64_encode($row['image']), // Encode image data
                'image_title' => $row['image_title'],
            ];
        }

        echo json_encode($userData);
    } else {
        echo json_encode([]); // Return an empty array if no results
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}

$mysqli->close();
?>
