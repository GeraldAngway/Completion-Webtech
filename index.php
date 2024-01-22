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

<form action="login/login.php" method="post">
    <label form="idNum">ID Number:</label>
    <input type="text" id="idNum" name="idNum" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <input type="checkbox" onclick="toggleLoginPassword()">
    <span style="color: black;">Show Password</span>
    <input type="submit" value="Login">

    <!--Sign-Up link -->
    <a href="student-module/signup_form.php">Sign-Up</a>

    <!--Sign-Up button -->
    <button class="signup_button" type="button" onclick="window.location.href='student-module/signup_form.php'">Sign-Up</button>
    <a href="login/forgot_pass.php">Forgot Password?</a>
</form>