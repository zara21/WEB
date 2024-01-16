<?php
session_start();

$response = ['success' => false];

if (isset($_SESSION['username'])) {
    // Destroy the session
    session_unset();
    session_destroy();
    session_start(); // Start a new session for the next user
    $response['success'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
