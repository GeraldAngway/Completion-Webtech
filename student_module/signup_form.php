<script src="../javascript/signup.js" defer></script>

<h2>SIGN-UP</h2>

<?php
if (!empty($errors)) {
    echo '<div style="color: red;">';
    foreach ($errors as $error) {
        echo $error . '<br>';
    }
    echo '</div>';
}

if (!empty($successMessage)) {
    echo '<div class="success-message" style="color: green;">' . $successMessage . '</div>';
}
?>

<form id="signup-form" action="signup.php" method="POST">
    <label for="idNumber">ID Number</label>
    <input type="text" id="idNumber" name="idNumber" value="<?php echo isset($_POST['idNumber']) ? htmlspecialchars($_POST['idNumber']) : ''; ?>" required>
    <label for="fName">First Name</label>
    <input type="text" id="fName" name="fName" value="<?php echo isset($_POST['fName']) ? htmlspecialchars($_POST['fName']) : ''; ?>" required>
    <label for="lName">Last Name</label>
    <input type="text" id="lName" name="lName" value="<?php echo isset($_POST['lName']) ? htmlspecialchars($_POST['lName']) : ''; ?>" required>
    <label for="program">Choose a Program</label>
    <select id="program" name="program" required>
        <option value=""></option>
        <option value="bscs" <?php echo (isset($_POST['program']) && $_POST['program'] == 'bscs') ? 'selected' : ''; ?>>BSCS</option>
        <option value="bsit" <?php echo (isset($_POST['program']) && $_POST['program'] == 'bsit') ? 'selected' : ''; ?>>BSIT</option>
        <option value="bmma" <?php echo (isset($_POST['program']) && $_POST['program'] == 'bmma') ? 'selected' : ''; ?>>BMMA</option>
    </select>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
    <label for="cpassword">Confirm Password</label>
    <input type="password" id="cpassword" name="cpassword" required>
    <input type="checkbox" onclick="togglePassword()"> 
    <span>Show Password</span><br><br>
    <input type="submit" value="Sign-Up">
</form>

<?php
if (!empty($successMessage)) {
    echo '<script src="../javascript/signup.js"></script>';
}
?>