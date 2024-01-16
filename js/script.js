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
    var authBox = document.getElementById('auth-box');
    var userInfoPanel = document.getElementById('user-info-panel');
    var logoutButton = document.getElementById('logout-btn');
    var userInfo = document.getElementById('user-info');

    // Check user status on page load
    checkUserStatus();

    function checkUserStatus() {
        // Make an AJAX request to check user status
        fetch('php/check_user_status.php')
            .then(response => response.json())
            .then(data => {
                if (data.loggedIn) {
                    // User is logged in
                    displayUserInfo(data.username);
                } else {
                    // User is not logged in
                    displayAuthForm();
                }
            })
            .catch(error => {
                console.error('Error checking user status:', error);
            });
    }

    function displayUserInfo(username) {
        authBox.style.display = 'none';
        userInfoPanel.style.display = 'flex';
        logoutButton.style.display = 'block';

        // Check if the username is defined before displaying
        userInfo.textContent = 'Welcome, ' + (username ? username : 'User');
    }

    function displayAuthForm() {
        authBox.style.display = 'block';
        userInfoPanel.style.display = 'none';
        logoutButton.style.display = 'none';
    }

    logoutButton.addEventListener('click', function () {
        // Make an AJAX request to logout
        fetch('php/logout.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Logout successful
                    checkUserStatus(); // Re-check user status
                } else {
                    console.error('Logout failed:', data.error);
                }
            })
            .catch(error => {
                console.error('Error during logout:', error);
            });
    });

    // Additional code for handling login and registration form submissions
    document.getElementById('login-form').addEventListener('submit', function (event) {
        event.preventDefault();
        var formData = new FormData(this);

        // Make an AJAX request to login
        fetch('php/login.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Login successful
                    checkUserStatus(); // Re-check user status
                } else {
                    // Display an error message or handle unsuccessful login
                    console.log('Login failed:', data.error);
                }
            })
            .catch(error => {
                console.error('Error during login:', error);
            });
    });

    document.getElementById('register-form').addEventListener('submit', function (event) {
        event.preventDefault();
        var formData = new FormData(this);

        // Make an AJAX request to register
        fetch('php/register.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Registration successful
                    checkUserStatus(); // Re-check user status
                } else {
                    // Display an error message or handle unsuccessful registration
                    console.log('Registration failed:', data.error);
                }
            })
            .catch(error => {
                console.error('Error during registration:', error);
            });
    });
});
