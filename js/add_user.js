// add_user.js

document.addEventListener('DOMContentLoaded', function () {
    var addUserForm = document.getElementById('add-user-form');

    addUserForm.addEventListener('submit', function (event) {
        event.preventDefault();

        var formData = new FormData(addUserForm);
        var url = 'php/add_user.php';

        fetch(url, {
            method: 'POST',
            body: formData,
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                // Handle the response (success or error)
                console.log(data);
            })
            .catch(function (error) {
                console.error('Error adding user data:', error);
            });
    });
});
