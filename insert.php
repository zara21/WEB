<?php
 
// Username is root
$user = 'root';
$password = '';
 
// Database name is geeksforgeeks
$database = 'geeksforgeeks';
 
// Server is localhost with
// port number 3306
$servername='localhost:3306';
$mysqli = new mysqli($servername, $user,
                $password, $database);
 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else{
    $_SERVER["REQUEST_METHOD"] == "POST"
    $username = $_POST['username'];
    $problems = $_POST['problems'];
    $score = $_POST['score'];
    $articles = $_POST['articles'];

}

    

    // // Check if a file was uploaded
    // if ($_FILES['photo']['error'] == 0) {
    //     $photoContent = file_get_contents($_FILES['photo']['tmp_name']);
    //     $photoContent = $conn->real_escape_string($photoContent);
    // } else {
    //     $photoContent = null;
    // }

    $sql = "INSERT INTO your_table_name (username, problems, score, articles) VALUES ('$username', '$problems', '$score', '$articles')";

//     if ($conn->query($sql) === TRUE) {
//         echo "Record added successfully";
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }

        

$conn->close();
?>
