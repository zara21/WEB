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


document.addEventListener('DOMContentLoaded', function () {
    var loginForm = document.getElementById('login-form');
    var logoutButton = document.getElementById('logout-btn');
    var userInfo = document.getElementById('user-info');
    var userStatus = document.getElementById('user-status');
    var searchInput = document.getElementById('search-input');
    var clearButton = document.getElementById('clear-search');
    var userCardsContainer = document.getElementById('user-cards-container');
    var searchResultsContainer = document.getElementById('search-results');

    // Check if the user is already authenticated (you need to implement this function)
    var isLoggedIn = checkAuthentication();

    // If the user is logged in, show welcome message and hide login form
    if (isLoggedIn) {
        showWelcomeMessage(getLoggedInUsername());
    }

    // Handle login form submission
    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

        var formData = new FormData(loginForm);
        var url = 'php/login.php';

        fetch(url, {
            method: 'POST',
            body: formData,
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    // Login successful
                    showWelcomeMessage(data.username);
                } else {
                    // Login failed, show error message
                    showErrorMessage('Invalid username or password. Please try again.');
                }
            })
            .catch(function (error) {
                console.error('Error logging in:', error);
            });
    });

    // Handle logout button click
    logoutButton.addEventListener('click', function () {
        // Implement a function to clear authentication status (e.g., remove session variables)
        clearAuthentication();
        // Show login form and hide logout button
        loginForm.style.display = 'block';
        logoutButton.style.display = 'none';
        userInfo.innerHTML = ''; // Clear user information
        userInfo.style.display = 'none';
        userStatus.style.display = 'none';
        // You may also clear or hide other elements related to user data
        // userCardsContainer.innerHTML = '';
        // searchResultsContainer.innerHTML = '';
    });

    // ... rest of your code

    // Placeholder functions, replace these with your actual implementation
    function checkAuthentication() {
        // Implement logic to check if the user is authenticated (e.g., check session variables)
        return false;
    }

    function getLoggedInUsername() {
        // Implement logic to get the username of the logged-in user (e.g., retrieve from session)
        return '';
    }

    function clearAuthentication() {
        // Implement logic to clear authentication status (e.g., destroy session variables)
    }

    function showWelcomeMessage(username) {
        loginForm.style.display = 'none';
        logoutButton.style.display = 'inline-block';
        userInfo.innerHTML = '<p>Welcome, ' + username + '!</p>';
        userInfo.style.display = 'block';
        userStatus.innerHTML = 'Welcome, ' + username;
        userStatus.style.display = 'block';
        // You may also fetch and display user data here if needed
        // fetchAndDisplayUserData('');
    }

    function showErrorMessage(message) {
        userStatus.innerHTML = message;
        userStatus.style.display = 'block';
    }

    function fetchAndDisplayUserData(query) {
        // Implement logic to fetch and display user data
        // Use the fetchAndDisplayUserData function from your existing code
    }
});
