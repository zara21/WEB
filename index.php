<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #333;
        }

        .newClassDiv {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .miniBox {
            border: 1px solid #ccc;
            padding: 10px;
            width: 200px;
        }

        .news-1 img {
            max-width: 100%;
            height: auto;
        }

        .miniBox_items {
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <h2>Display Data from Database</h2>
    <div class="newClassDiv"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const axaliArray = document.querySelector('.newClassDiv');

            function showData(data) {
                data.forEach(row => {
                    axaliArray.innerHTML += `<div class="miniBox"> 
                        <div class="news-1"> 
                            <img src="data:image/jpeg;base64,${row.photo}" alt="img"> 
                            <h2>${row.title}</h2>
                        </div> 
                        <div class="miniBox_items"> 
                            <p>${row.description}</p> 
                            <button id="seeMoreBtn">See more</button>
                        </div> 
                    </div>`;
                });
            }

            function fetchData() {
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            const data = JSON.parse(xhr.responseText);
                            console.log("Received data:", data);
                            showData(data);
                        } else {
                            console.error("Error in AJAX request. Status code:", xhr.status);
                        }
                    }
                };
                xhr.open("GET", "fetch_data.php", true);
                xhr.send();
            }

            // Initially show the data
            fetchData();
        });
    </script>

</body>
</html>
