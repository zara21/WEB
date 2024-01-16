document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('search-input');
    var clearButton = document.getElementById('clear-search');
    var userCardsContainer = document.getElementById('user-cards-container');
    var searchResultsContainer = document.getElementById('search-results');

    // Fetch all user data when the page loads
    fetchAndDisplayUserData('');

    searchInput.addEventListener('input', function () {
        var searchQuery = this.value.trim().toLowerCase();
        fetchAndDisplayUserData(searchQuery);
    });

    function fetchAndDisplayUserData(query) {
        // Assuming you have a PHP file named 'fetch_users.php'
        // Adjust the URL accordingly
        var url = 'php/fetch_users.php';

        // You can use fetch API to make an AJAX request
        fetch(url, {
            method: 'POST',
            body: JSON.stringify({ query: query }),
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (query) {
                    displaySearchResults(data);
                } else {
                    displayAllUsers(data);
                }
            })
            .catch(function (error) {
                console.error('Error fetching user data:', error);
            });
    }

    function displayAllUsers(data) {
        userCardsContainer.innerHTML = '';

        if (data.length > 0) {
            data.forEach(function (userData) {
                var userCard = createUserCard(userData);
                userCardsContainer.appendChild(userCard);
            });
        } else {
            userCardsContainer.innerHTML = '<p>No users found</p>';
        }

        // Hide search results when displaying all users
        searchResultsContainer.innerHTML = '';
        clearButton.style.display = 'none';
    }

    function displaySearchResults(data) {
        searchResultsContainer.innerHTML = '';

        if (data.length > 0) {
            data.forEach(function (userData) {
                var userCard = createUserCard(userData);
                searchResultsContainer.appendChild(userCard);
            });

            // Display clear button for search results
            clearButton.style.display = 'inline-block';
        } else {
            searchResultsContainer.innerHTML = '<p>No search results found</p>';
            clearButton.style.display = 'none';
        }
    }

    function createUserCard(userData) {
        var userCard = document.createElement('div');
        userCard.className = 'user-card';
        userCard.innerHTML = `
            <div class="user-card-items user-card-username">${userData.title}</div>
            <div class="user-card-items user-card-description">${userData.description}</div>
            <div class="user-card-items user-card-score">${userData.price + " ₾"}</div>
            <div class="user-card-items user-card-articles">${userData.articles}</div>
            <div class="user-card-items user-card-image">
                <img src="data:image/jpeg;base64,${userData.image}" alt="${userData.image_title}">
            </div>
        `;
        return userCard;
    }

    clearButton.addEventListener('click', function () {
        searchInput.value = '';
        searchResultsContainer.innerHTML = '';
        clearButton.style.display = 'none';
    });
});
