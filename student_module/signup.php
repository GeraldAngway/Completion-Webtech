<?php
include '../database/db.php';

$errors = array();
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $idNumber = $_POST['idNumber'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $program = strtoupper($_POST['program']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        $errors[] = "Password and confirm password do not match.";
    }

    if (strlen($password) < 8 || strlen($password) > 16) {
        $errors[] = "Password must be between 8 and 16 characters in length.";
    }

    $checkSluSql = "SELECT COUNT(*) FROM slu WHERE IDNumber = ?";
    $checkSluStmt = $db->prepare($checkSluSql);
    $checkSluStmt->bind_param("s", $idNumber);
    $checkSluStmt->execute();
    $checkSluStmt->bind_result($sluCount);
    $checkSluStmt->fetch();
    $checkSluStmt->close();

    if ($sluCount === 0) {
        $errors[] = "Invalid ID number. Please check and try again.";
    }

    $checkIdNumberSql = "SELECT COUNT(*) FROM users WHERE IDNum = ?";
    $checkIdNumberStmt = $db->prepare($checkIdNumberSql);
    $checkIdNumberStmt->bind_param("s", $idNumber);
    $checkIdNumberStmt->execute();
    $checkIdNumberStmt->bind_result($idNumberCount);
    $checkIdNumberStmt->fetch();
    $checkIdNumberStmt->close();

    if ($idNumberCount > 0) {
        $errors[] = "ID number already exists in the database.";
    }

    if (empty($errors)) { // If there are no errors, proceed with registration
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $role ='Student';

        $sql = "INSERT INTO users (IDNum, FirstName, LastName, Program, Role) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssss", $idNumber, $fName, $lName, $program, $role);

        if ($stmt->execute()) {
        
            $userID = $stmt->insert_id;
            $passwordStatus = 0;
            $accountStatus = 'Active';
            $userStatus = 'Offline';

            $sqlAccounts = "INSERT INTO accounts (UserID, Password, Password_Status, Account_Status, User_Status) VALUES (?, ?, ?, ?, ?)";
            $stmtAccounts = $db->prepare($sqlAccounts);
            $stmtAccounts->bind_param("isiss", $userID, $hashedPassword, $passwordStatus, $accountStatus, $userStatus);

            if ($stmtAccounts->execute()) {
                $successMessage = "Registration successful!";
            } else {
                $errors[] = $stmtAccounts->error;
            }

            $stmtAccounts->close();
        } else {
            $errors[] = $stmt->error;
        }

        $stmt->close();
        $db->close();
    }
}

include 'signup_form.php'; // Include the signup form at the end

?>