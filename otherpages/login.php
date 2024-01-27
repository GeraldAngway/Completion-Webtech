<?php
require('../database/db.php');
session_start();

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    // Redirect to the appropriate page based on the user's role
    if ($_SESSION['role'] == 'Student') {
        header("location: ../student_module/student.php");
        exit();
    } elseif ($_SESSION['role'] == 'TRIL') {
        header("location: ../tril_module/tril.php");
        exit();
    } else {
        header("location: ../admin_module/admin.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idnumber = $_POST['idNum'];
    $password = $_POST['password'];

    $sql = "SELECT a.password, u.role, u.UserID FROM accounts a
            JOIN users u ON a.UserID = u.UserID
            WHERE u.IDNum = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $idnumber);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['idNum'] = $idnumber;
            $_SESSION['role'] = $row['role'];
            $_SESSION['UserID'] = $row['UserID'];

            // Redirect to the appropriate page based on the user's role
            if ($_SESSION['role'] == 'Student') {
                header("location: ../student_module/student.php");
                exit();
            } elseif ($_SESSION['role'] == 'TRIL') {
                header("location: ../tril_module/tril.php");
                exit();
            } else {
                header("location: ../admin_module/admin.php");
                exit();
            }
        }
    }

    $_SESSION['error'] = 'Invalid ID number or password';
}

header('Location: ../index.php');
exit();
?>
