<script src="../javascript/change.js" defer></script>
<link rel="stylesheet" href="../css/change.css">
<div class="box-container">
<?php
require('require_session.php');
require('../database/db.php');

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
            $userID = $_SESSION['userID'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $updateSql = "UPDATE accounts SET Password = ? WHERE UserID = ?";
            $stmt_update = $db->prepare($updateSql);
            $stmt_update->bind_param("ss", $hashed_password, $userID);
            $stmt_update->execute();
            $stmt_update->close();

            $roleSql = "SELECT Role FROM users WHERE UserID = ?";
            $stmt_role = $db->prepare($roleSql);
            $stmt_role->bind_param("s", $userID);
            $stmt_role->execute();
            $stmt_role->bind_result($userRole);
            $stmt_role->fetch();
            $stmt_role->close();

            $db->close();

            if ($userRole === "Student") {
                echo "<script>
                alert('Password changed successfully');
                window.location.href = '../student_module/student.php';
                </script>";
            } elseif ($userRole === "TRIL") {
                echo "<script>
                alert('Password changed successfully');
                window.location.href = '../tril_module/tril.php';
                </script>";
            }
        }
    }
}
?>


    <header>Change Password</header>

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
    <input type="checkbox" onclick="toggleLoginPassword()">
    <span style="color: #060f8a;">Show Password</span>
    </div>

    <div class="button">
    <input type="submit" value="Change Password">
    </div>

</form>
</div>