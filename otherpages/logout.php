<?php
session_start();

if (isset($_SESSION['userID'])) {
    require('../database/db.php');

    $updateSql = "UPDATE accounts SET User_Status = 'Offline' WHERE UserID = ?";
    $updateStmt = $db->prepare($updateSql);
    $updateStmt->bind_param("i", $_SESSION['userID']);
    $updateStmt->execute();
    $updateStmt->close();
}

session_unset();
session_destroy();
header("location: ../index.php");
?>
