<?php
require('../otherpages/require_session.php');
require('../database/db.php');

$isValid = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idNumber = $_POST['idNum'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $program = $_POST['program'];
    $role = $_POST['role'];

    $checkSluSql = "SELECT COUNT(*) FROM slu WHERE IDNumber = ?";
    $checkSluStmt = $db->prepare($checkSluSql);
    $checkSluStmt->bind_param("s", $idNumber);
    $checkSluStmt->execute();
    $checkSluStmt->bind_result($sluCount);
    $checkSluStmt->fetch();
    $checkSluStmt->close();

    if ($sluCount === 0) {
        echo "<script>alert('Invalid ID Number');
                window.location.href = 'admin_viewusers.php';
            </script>";
        $isValid = false;
    }

    $checkIdNumberSql = "SELECT COUNT(*) FROM users WHERE IDNum = ? AND Role = ?";
    $checkIdNumberStmt = $db->prepare($checkIdNumberSql);
    $checkIdNumberStmt->bind_param("ss", $idNumber, $role);
    $checkIdNumberStmt->execute();
    $checkIdNumberStmt->bind_result($count);
    $checkIdNumberStmt->fetch();
    $checkIdNumberStmt->close();

    if ($count > 0) {
        echo "<script>alert('ID Number already registered');
                window.location.href = 'admin_viewusers.php';
            </script>";
        $isValid = false;
    }

    if ($isValid) {
        $insertUsersSql = "INSERT INTO users (IDNum, FirstName, LastName, Program, Role)
                        VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($insertUsersSql);
        $stmt->bind_param("sssss", $idNumber, $fName, $lName, $program, $role);

        if ($stmt->execute()) {
            $userID = $stmt->insert_id;
            $passwordStatus = 0;
            $accountStatus = 'Active';
            $userStatus = 'Offline';

            if ($role === 'Student') {
                $password = password_hash($idNumber, PASSWORD_DEFAULT);
            } elseif ($role === 'TRIL') {
                $password = password_hash('tril_cis', PASSWORD_DEFAULT);
            }

            $insertAccsSql = "INSERT INTO accounts (UserID, Password, Password_Status, 
                            Account_Status, User_Status) VALUES (?, ?, ?, ?, ?)";
            $stmtAccounts = $db->prepare($insertAccsSql);
            $stmtAccounts->bind_param("isiss", $userID, $password, $passwordStatus, $accountStatus, $userStatus);

            if ($stmtAccounts->execute()) {
                echo "<script>alert('User Account Added Successfully');
                        window.location.href = 'admin_viewusers.php';
                    </script>";
            } else {
                echo "Error inserting account data: " . $stmtAccounts->error;
            }
        } else {
            echo "Error inserting user data: " . $stmt->error;
        }
    }
}
?>