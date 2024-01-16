<?php
session_start();

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Replace with your actual database credentials
    $user = 'root';
    $password = '';
    $database = 'geeksforgeeks';
    $servername = 'localhost:3306';

    // Create connection
    $mysqli = new mysqli($servername, $user, $password, $database);

    // Check connection
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Sanitize and validate input
    $username = $mysqli->real_escape_string($username);
    $password = password_hash($mysqli->real_escape_string($password), PASSWORD_DEFAULT);
    $email = $mysqli->real_escape_string($email);

    // Check if the username already exists
    $checkSql = "SELECT * FROM users WHERE username = '$username'";
    $checkResult = $mysqli->query($checkSql);

    if ($checkResult && $checkResult->num_rows > 0) {
        $response['error'] = 'Username already exists';
    } else {
        // No duplicate username, proceed with registration
        $insertSql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

        if ($mysqli->query($insertSql)) {
            $_SESSION['username'] = $username;
            $response['success'] = true;
        } else {
            $response['error'] = $mysqli->error;
        }
    }

    $mysqli->close();
} else {
    $response['error'] = 'Invalid request method';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
