<script src="../javascript/signup.js" defer></script>
<link rel="stylesheet" href="../css/signup.css">
<div class="box-container">
<?php
if (!empty($errors)) {
    echo '<div style="color: red;">';
    foreach ($errors as $error) {
        echo $error . '<br>';
    }
    echo '</div>';
}
?>


    <img src="../images/logo.png" alt="top-logo">
    <header>SIGN UP</header>

<form id="signup-form" action="signup.php" method="POST">

    <div class="idnum"> 
    <label for="idNumber">ID Number: </label>
    <input type="text" id="idNumber" name="idNumber" value="<?php echo isset($_POST['idNumber']) ? htmlspecialchars($_POST['idNumber']) : ''; ?>" required>
    </div>

    <div class="fn"> 
    <label for="fName">First Name: </label>
    <input type="text" id="fName" name="fName" value="<?php echo isset($_POST['fName']) ? htmlspecialchars($_POST['fName']) : ''; ?>" required>
    </div>
    
    <div class="ln"> 
    <label for="lName">Last Name: </label>
    <input type="text" id="lName" name="lName" value="<?php echo isset($_POST['lName']) ? htmlspecialchars($_POST['lName']) : ''; ?>" required>
    </div>
    
    <div class="prog"> 
    <label for="program">Choose a Program: </label>
    <select id="program" name="program" required>
        <option value=""></option>
        <option value="bscs" <?php echo (isset($_POST['program']) && $_POST['program'] == 'bscs') ? 'selected' : ''; ?>>BSCS</option>
        <option value="bsit" <?php echo (isset($_POST['program']) && $_POST['program'] == 'bsit') ? 'selected' : ''; ?>>BSIT</option>
        <option value="bmma" <?php echo (isset($_POST['program']) && $_POST['program'] == 'bmma') ? 'selected' : ''; ?>>BMMA</option>
    </select>
    </div>
    
    <div class="ps"> 
    <label for="password">Password: </label> 
    <input type="password" id="password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
    </div>
    
    <div class="pps"> 
    <label for="cpassword">Confirm Password: </label>
    <input type="password" id="cpassword" name="cpassword" value="<?php echo isset($_POST['cpassword']) ? htmlspecialchars($_POST['cpassword']) : ''; ?>" required>
    </div>
    
    <div class="check"> 
    <input type="checkbox" onclick="togglePassword()"> 
    <span>Show Password: </span><br><br>
    </div>

    <div class="button"> 
    <input type="submit" value="SIGN UP">
    </div>

</form>

<div class="back">
    <button class="back_button" type="button" onclick="window.location.href='../index.php'">Back</button>
</div>

<div class="image">
        <img src="../images/logo.png" alt="img">
    </div>
</div>

