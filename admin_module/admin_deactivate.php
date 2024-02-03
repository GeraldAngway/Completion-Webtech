<?php
require('../database/db.php');
require('../otherpages/require_session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userID'])) {
    $deactivate = $_POST['userID'];

    $getUserIDSql = "SELECT UserID FROM users WHERE UserID = ?";

    $stmt = $db->prepare($getUserIDSql);
    $stmt->bind_param("i", $deactivate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $acctStatus = 'Deactivated';
    
        $updateSql = "UPDATE accounts SET Account_Status = ? WHERE UserID = ?";
    
        $update_stmt = $db->prepare($updateSql);
        $update_stmt->bind_param("si", $acctStatus, $deactivate);
    
        if ($update_stmt->execute()) {
            echo "<script>alert('Account Deactivated');
            window.location.href = 'admin_viewusers.php';
            </script>";
        } else {
            echo "Error deactivating user: " . $update_stmt->error;
        }
    }
}
$db->close();
?>