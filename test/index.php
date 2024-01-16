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
    </style>
</head>

<body>
<section class="container">
    <h1>GeeksForGeeks</h1>

    <?php
    // Username is root
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

    // Display search results if available
    if (isset($_POST['search'])) {
        $searchTerm = $_POST['search'];
        $sql = "SELECT * FROM userdata WHERE username LIKE '%$searchTerm%' ORDER BY score DESC";
        $result = $mysqli->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo '<div class="user-card" data-username="' . $row['username'] . '">';
            // Display other information from the user-card here
            echo '</div>';
        }
    }

    $mysqli->close();
    ?>

    

    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <div id="user-cards-container">
        <?php
        // Reconnect to the database
        $mysqli = new mysqli($servername, $user, $password, $database);

        // Loop through user-cards and display data
        $count = 0;
        $sql = "SELECT * FROM userdata ORDER BY score DESC";
        $result = $mysqli->query($sql);

        while ($row = $result->fetch_assoc()) {
            $count++;
            ?>
            <div class="user-card">
                <div class="user-card-items user-card-username"> <?php echo $row['username']; ?></div>
                <div class="user-card-items user-card-problems"> <?php echo $row['problems']; ?></div>
                <div class="user-card-items user-card-score"> <?php echo $row['score']; ?></div>
                <div class="user-card-items user-card-articles"> <?php echo $row['articles']; ?></div>
                <div class="user-card-items user-card-image">
                    <?php
                    $imageData = $row['image'];
                    $base64Image = base64_encode($imageData);
                    $imageSrc = 'data:image/jpeg;base64,' . $base64Image;
                    ?>
                    <img src="<?php echo $imageSrc; ?>" alt="<?php echo $row['image_title']; ?>">
                </div>
            </div>
        <?php
        }

        $mysqli->close();
        ?>
    </div>

    
</section>



</body>

</html>
