function toggleChangePassword() {
    var newPassField = document.getElementById("new_password");
    var confirmPassField = document.getElementById("confirm_password");

    if (newPassField.type === "password" && confirmPassField.type === "password") {
        newPassField.type = "text";
        confirmPassField.type = "text";
    } else {
        newPassField.type = "password";
        confirmPassField.type = "password";
    }
}