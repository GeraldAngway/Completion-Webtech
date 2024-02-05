<link rel="stylesheet" href="css/loginn.css">
<script src="javascript/login.js" ></script>

<h2>Login</h2>

<?php 
    session_start();
    if(isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        echo "<p style='color: red;'>$error</p>";
        unset($_SESSION['error']);
    }
?>

<form action="otherpages/login.php" method="post">
    <label form="idNum">ID Number:</label>
    <input type="text" id="idNum" name="idNum" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <input type="checkbox" onclick="toggleLoginPassword()">
    <span style="color: black;">Show Password</span>
    <input type="submit" value="Login">
    <button class="signup_button" type="button" onclick="window.location.href='student_module/signup_form.php'">Sign-Up</button>
    <a href="otherpages/forgot_pass.php">Forgot Password?</a>
</form>    