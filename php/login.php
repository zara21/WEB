<?php
// Your database connection code here

// Assuming you have connected to the database
$user = 'root';
$password = '';

// Database name is geeksforgeeks
$database = 'geeksforgeeks';

// Server is localhost with port number 3306
$servername = 'localhost:3306';
$mysqli = new mysqli($servername, $user, $password, $database);

// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
        $mysqli->connect_errno . ') ' .
        $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Modify the SQL query based on your database schema
    $sql = "SELECT * FROM users WHERE username = '$username'";

    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password using password_verify()
        if (password_verify($password, $row['password'])) {
            echo json_encode(['success' => true, 'username' => $row['username']]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid password']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User not found']);
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}

$mysqli->close();
?>
