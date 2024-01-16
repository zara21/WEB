document.addEventListener('DOMContentLoaded', function () {
    var loginForm = document.getElementById('login-form');
    var loginResult = document.getElementById('login-result');
    var userInfo = document.getElementById('user-info');

    // Check if the user is already logged in (you may need to implement session handling)
    var isLoggedIn = false; // Update this based on your authentication mechanism

    if (isLoggedIn) {
        loginForm.style.display = 'none'; // Hide login form
        userInfo.innerHTML = '<p>Welcome, ' + getLoggedInUsername() + '!</p>';
        userInfo.style.display = 'block'; // Display user information
    }

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
                    loginForm.style.display = 'none'; // Hide login form
                    userInfo.innerHTML = '<p>Welcome, ' + data.username + '!</p>';
                    userInfo.style.display = 'block'; // Display user information
                } else {
                    loginResult.innerHTML = '<p>Error: ' + data.error + '</p>';
                }
            })
            .catch(function (error) {
                console.error('Error logging in:', error);
            });
    });

    function getLoggedInUsername() {
        // Implement a function to get the currently logged in user's username
        // You may need to use session or other authentication mechanisms
        return 'DemoUser'; // Replace this with your actual implementation
    }
});


