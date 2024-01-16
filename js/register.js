document.addEventListener('DOMContentLoaded', function () {
    var registerForm = document.getElementById('register-form');
    var registerResult = document.getElementById('register-result');

    registerForm.addEventListener('submit', function (event) {
        event.preventDefault();

        var formData = new FormData(registerForm);
        var url = 'php/register.php';

        fetch(url, {
            method: 'POST',
            body: formData,
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    registerResult.innerHTML = '<p>Registration successful. Welcome, ' + data.username + '!</p>';
                } else {
                    registerResult.innerHTML = '<p class="error-message">Error: ' + data.error + '</p>';
                }
            })
            .catch(function (error) {
                console.error('Error registering user:', error);
            });
    });
});
