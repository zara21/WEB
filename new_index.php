<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>GFG User Details</title>
    <!-- CSS FOR STYLING THE PAGE -->
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .user-card {
            border: 1px solid black;
            margin-bottom: 10px;
            padding: 10px;
        }

        h1 {
            text-align: center;
            color: #006600;
            font-size: xx-large;
            font-family: 'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', 'sans-serif';
        }

        .see-more-btn {
            display: block;
            margin: 10px auto;
        }

        img {
            width: 150px;
        }

        #search-results {
            margin-bottom: 10px;
            background-color: #006600;
        }
    </style>
</head>

<body>
<section class="container">
    <h1>GeeksForGeeks</h1>

    <form id="search-form" method="post">
        <input type="text" id="search-input" name="search" placeholder="Enter username">
        <button type="submit">Search</button>
    </form>

    <?php
    // Database connection parameters
    $user = 'root';
    $password = '';
    $database = 'geeksforgeeks';
    $servername = 'localhost:3306';
    $mysqli = new mysqli($servername, $user, $password, $database);

    // Checking for connections
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Display search results if available
    if (isset($_POST['search'])) {
        $searchTerm = $_POST['search'];
        $sql = "SELECT * FROM userdata WHERE username LIKE '%$searchTerm%' ORDER BY score DESC";
        $result = $mysqli->query($sql);

        echo '<div id="search-results">';
        
        // Display the searched username
        echo '<h2>Search Results for: ' . htmlspecialchars($searchTerm) . '</h2>';

        while ($row = $result->fetch_assoc()) {
            echo createUserCardElement($row);
        }

        echo '</div>';
    }

    $mysqli->close();
    ?>

    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <div id="user-cards-container">
        <?php
        // Reconnect to the database
        $mysqli = new mysqli($servername, $user, $password, $database);

        // Loop through initial user-cards and display data
        $sql = "SELECT * FROM userdata ORDER BY score DESC";
        $result = $mysqli->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo createUserCardElement($row);
        }

        $mysqli->close();
        ?>
    </div>

    <script>
        // Your JavaScript code goes here, if needed
    </script>
</section>
</body>

</html>

<?php
function createUserCardElement($userData)
{
    $userCard = '<div class="user-card">';
    $userCard .= '<div class="user-card-items user-card-username">' . $userData['username'] . '</div>';
    $userCard .= '<div class="user-card-items user-card-problems">' . $userData['problems'] . '</div>';
    $userCard .= '<div class="user-card-items user-card-score">' . $userData['score'] . '</div>';
    $userCard .= '<div class="user-card-items user-card-articles">' . $userData['articles'] . '</div>';

    // Check if 'image' and 'image_title' keys exist
    if (isset($userData['image']) && isset($userData['image_title'])) {
        $userCard .= '<div class="user-card-items user-card-image">';
        $userCard .= '<img src="data:image/jpeg;base64,' . base64_encode($userData['image']) . '" alt="' . $userData['image_title'] . '">';
        $userCard .= '</div>';
    }

    $userCard .= '</div>';

    return $userCard;
}
?>
