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
    $email = $_POST['email'];

    // You should hash the password using password_hash() before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username already exists
    $checkSql = "SELECT * FROM users WHERE username = '$username'";
    $checkResult = $mysqli->query($checkSql);

    if ($checkResult && $checkResult->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Username already exists']);
    } else {
        // No duplicate username, proceed with registration
        $insertSql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashedPassword', '$email')";

        if ($mysqli->query($insertSql)) {
            echo json_encode(['success' => true, 'username' => $username]);
        } else {
            echo json_encode(['success' => false, 'error' => $mysqli->error]);
        }
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}

$mysqli->close();
?>
