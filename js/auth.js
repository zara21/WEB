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
        userInfo.textContent = 'Welcome, ' + username;
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
    // ...

    // Example for handling login form submission

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

    // Example for handling registration form submission
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
