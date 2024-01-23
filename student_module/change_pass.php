<script src="../javascript/change.js" defer></script>
<link rel="stylesheet" href="../css/change.css">

<h2>Change Password</h2>

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

<form action="change_pass.php" method="post">
    <label for="new_password">New Password:</label>
    <input type="password" id="new_password" name="new_password" required>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <input type="checkbox" onclick="toggleChangePassword()"> Show Password<br><br>
    <input type="submit" value="Change Password">
</form>