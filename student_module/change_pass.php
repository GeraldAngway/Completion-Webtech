<script src="../javascript/change.js" defer></script>
<link rel="stylesheet" href="../css/pass.css">

<?php
// require('../login/require_session.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<p style='color: red;'>The new and confirm passwords must match.</p>";
    } else {
        $password_length = strlen($new_password);

        if ($password_length < 8 || $password_length > 16) {
            echo "<p style='color: red;'>Password must be 8 to 16 characters long.</p>";
        } else {
            require('../database/db.php');
            session_start();

            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $idnumber = $_SESSION['idnumber'];

            $sql = "UPDATE accounts SET password = ? WHERE UserID = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ss", $hashed_password, $idnumber);
            $stmt->execute();
            $stmt->close();
            $db->close();

            echo "<script>
                    alert('Password changed successfully');
                    window.location.href = 'student.php';
                  </script>";
            exit();
        }
    }
}
?>

<div class="box-container">
    <header>CHANGE PASSWORD</header>

<form action="change_pass.php" method="post">

    <div class="new"> 
    <label for="new_password">New Password:</label>
    <input type="password" id="new_password" name="new_password" required>
    </div>
    
    <div class="confirm"> 
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    
    <div class="check"> 
    <input type="checkbox" onclick="togglePassword()"> 
    <span>Show Password</span><br><br>
    </div>

    <div class="button"> 
    <input type="submit" value="Change Password">
    </div>

</form>
</div>