<?php
session_start();
var_dump($_SESSION);
// Check if the user is already logged in
if (isset($_SESSION['UserID'])) {
    // Redirect to the dashboard if logged in
    header("Location: dashboard.php");
    exit();
}

// If not logged in, redirect to the login page
header("Location: login.php");
exit();
?>
