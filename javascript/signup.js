function togglePassword() {
    var passField = document.getElementById("password");
    var confirmPassField = document.getElementById("cpassword");

    if (passField.type === "password" && confirmPassField.type === "password") {
        passField.type = "text";
        confirmPassField.type = "text";
    } else {
        passField.type = "password";
        confirmPassField.type = "password";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    var successMessage = document.querySelector('.success-message');

    if (successMessage) {
        alert(successMessage.textContent); // Display the success message as an alert

        // Redirect to ../index.php after the user clicks "OK"
        window.location.href = '../index.php';
    }
});
