<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $author = $_POST['author'];

    // Check if a file was uploaded
    if ($_FILES['photo']['error'] == 0) {
        $photoContent = file_get_contents($_FILES['photo']['tmp_name']);
        $photoContent = $conn->real_escape_string($photoContent);
    } else {
        $photoContent = null;
    }

    $sql = "INSERT INTO your_table_name (title, description, author, photo) VALUES ('$title', '$description', '$author', '$photoContent')";

    if ($conn->query($sql) === TRUE) {
        echo "Record added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
