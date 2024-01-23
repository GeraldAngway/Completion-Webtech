<script src="javascript/login.js" ></script>
<link rel="stylesheet" href="css/loginn.css">

<?php
    session_start();
    if(isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        echo "<p style='color: red;'>$error</p>";
        unset($_SESSION['error']);
    }
?>
<div class="box-container">
    <img src="images/logo.png" alt="top-logo">
    <header>LOG IN</header>
<form action="login/login.php" method="post">

    <div class="idnum"> 
    <label form="idNum">ID Number:</label>
    <input type="text" id="idNum" name="idNum" required>
    </div>
    
    <div class="pass">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    </div>
    
    <div class="check"> 
    <input type="checkbox" onclick="toggleLoginPassword()">
    <span style="color: #060f8a;">Show Password</span>
    </div>
    
    <div class="button"> 
    <input type="submit" value="Login">
    </div>
    

    <!--Sign-Up button -->
    <button class="signup_button" type="button" onclick="window.location.href='student-module/signup_form.php'">Sign-Up</button>
    <br><br>

    <a href="login/forgot_pass.php">Forgot Password?</a>

</form>


<div class="image">
        <img src="images/logo.png" alt="img">
    </div>
</div>