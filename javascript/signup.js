

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