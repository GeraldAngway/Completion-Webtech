<?php
include("../database/db.php");
require('../otherpages/require_session.php');

$delete_stmt = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['userID'];

    if (isset($_POST['admin_password'])) {
        $admin_password = $_POST['admin_password'];

        if (isset($_SESSION['userID'])) {
            $admin_userID = $_SESSION['userID'];
            $adminSql = "SELECT Password FROM accounts WHERE UserID = ?";
            $admin_stmt = $db->prepare($adminSql);
            $admin_stmt->bind_param("i", $admin_userID);
            $admin_stmt->execute();
            $admin_result = $admin_stmt->get_result();

            if ($admin_result->num_rows > 0) {
                $admin_row = $admin_result->fetch_assoc();
                if (password_verify($admin_password, $admin_row['Password'])) {

                    $deleteSql = "DELETE FROM users WHERE UserID = ?";
                    $delete_stmt = $db->prepare($deleteSql);
                    $delete_stmt->bind_param("i", $user);

                    if ($delete_stmt->execute()) {
                        echo "<script>alert('Account Deleted');
                        window.location.href = 'admin_viewusers.php';
                        </script>";
                    } else {
                        echo "Error deleting user: " . $delete_stmt->error;
                    }
                } else {
                    echo "<script>alert('Incorrect Password');
                    window.location.href = 'admin_viewusers.php';
                    </script>";
                }
            }
        }
    }
}
if ($delete_stmt) {
    $delete_stmt->close();
}
$db->close();
?>