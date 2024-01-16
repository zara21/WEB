<?php
session_start();

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

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
    $password = $mysqli->real_escape_string($password);

    // Fetch user data from the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['username'] = $username;
            $response['success'] = true;
            $response['username'] = $username; // Include the username in the response
        } else {
            $response['error'] = 'Invalid password';
        }
    } else {
        $response['error'] = 'User not found';
    }

    $mysqli->close();
} else {
    $response['error'] = 'Invalid request method';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
