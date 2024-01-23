<?php
require('../database/db.php');
session_start();

$idnumber = $_POST['idNum'];
$password = $_POST['password'];

$sql = "SELECT a.password, u.role, u.UserID, u.IDNum FROM accounts a
        JOIN users u ON a.UserID = u.UserID
        WHERE u.IDNum = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("s", $idnumber);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            if (isset($_SESSION['logged_users']) && in_array($idnumber, $_SESSION['logged_users'])) {
                $_SESSION['error'] = 'User already logged in';
                header('Location: ../index.php');
                exit();
            }

            $_SESSION['loggedin'] = true;
            $_SESSION['idNum'] = $row['IDNum'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['logged_users'][] = $row['IDNum'];

            // Adjust your logic to handle multiple rows
            if ($_SESSION['role'] == 'Student' || $_SESSION['role'] == 'student') {
                if ($password == $idnumber) {
                    header("location: change_pass.php");
                } else {
                    header("location: ../student_module/student.php");
                }
                exit();
            } elseif ($_SESSION['role'] == 'TRIL') {
                if ($password == $idnumber) {
                    header("location: change_pass.php");
                } else {
                    header("location: ../tril_module/tril.php");
                }
                exit();
            } else {
                header("location: ../admin_module/admin.php");
                exit();
            }
        }
    }
    $_SESSION['error'] = 'Invalid password';
    header('Location: ../index.php');
    exit();
} else {
    $_SESSION['error'] = 'Account not found';
    header('Location: ../index.php');
    exit();
}
$stmt->close();
$db->close();
?>