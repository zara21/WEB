<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .box-container {
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            width: 200px;
            display: inline-block;
            vertical-align: top;
            opacity: 1;
            transition: opacity 0.3s ease-in-out;
        }

        .box-container img {
            max-width: 100%;
            height: auto;
        }

        #search-result-container {
            margin-top: 20px;
            display: none;
        }

        #clear-search {
            display: none;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<section class="container">
    <h1>GeeksForGeeks</h1>

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
    // Display all user cards
    $sql = "SELECT * FROM userdata ORDER BY score DESC";
    $result = $mysqli->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo '<div class="box-container">';
        echo '<div class="box-items box-username">' . $row['username'] . '</div>';
        echo '<div class="box-items box-problems">' . $row['problems'] . '</div>';
        echo '<div class="box-items box-score">' . $row['score'] . '</div>';
        echo '<div class="box-items box-articles">' . $row['articles'] . '</div>';

        $imageData = $row['image'];
        $base64Image = base64_encode($imageData);
        $imageSrc = 'data:image/jpeg;base64,' . $base64Image;

        echo '<div class="box-items box-image">';
        echo '<img src="' . $imageSrc . '" alt="' . $row['image_title'] . '">';
        echo '</div>';

        echo '</div>';
    }

    $mysqli->close();
    ?>

    <div id="search-result-container">
        <!-- Search results will be displayed here dynamically -->
    </div>

    <form id="search-form" method="post">
        <input type="text" id="search-input" name="search" placeholder="Search by username">
    </form>

    <button id="clear-search">Clear Search Results</button>

    <script>
        var searchInput = document.getElementById('search-input');
        var clearButton = document.getElementById('clear-search');
        var searchResultContainer = document.getElementById('search-result-container');

        searchInput.addEventListener('input', function () {
            var searchTerm = this.value.trim().toLowerCase();
            var boxContainers = document.querySelectorAll('.box-container');

            searchResultContainer.innerHTML = ''; // Clear previous search results

            boxContainers.forEach(function (box) {
                var username = box.querySelector('.box-username').innerText.toLowerCase();
                if (username.includes(searchTerm)) {
                    searchResultContainer.appendChild(box.cloneNode(true));
                }
            });

            if (searchResultContainer.children.length > 0) {
                searchResultContainer.style.display = 'block';
                clearButton.style.display = 'inline-block';
            } else {
                searchResultContainer.style.display = 'none';
                clearButton.style.display = 'none';
            }
        });

        clearButton.addEventListener('click', function () {
            searchInput.value = '';
            searchResultContainer.style.display = 'none';
            clearButton.style.display = 'none';
        });
    </script>
</section>

</body>
</html>
