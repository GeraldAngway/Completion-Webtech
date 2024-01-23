<link rel="stylesheet" href="../css/forgot.css">

<?php
require('../database/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idnumber = $_POST['idNum'];

    $stmt = $db->prepare("SELECT * FROM users WHERE IDNum = ?");
    $stmt->bind_param("s", $idnumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (isset($row['role']) && strtolower($row['role']) == 'student') {
            echo "<script>alert('Invalid Student ID Number');</script>";
        } else {
            $checkStatusStmt = $db->prepare("SELECT Password_Status FROM accounts WHERE UserID = ?");
            $checkStatusStmt->bind_param("s", $row['UserID']);
            $checkStatusStmt->execute();
            $statusResult = $checkStatusStmt->get_result();
            $checkStatusStmt->close();

            if ($statusResult->num_rows > 0) {
                $statusRow = $statusResult->fetch_assoc();
                if ($statusRow['Password_Status'] == 1) {
                    echo "<script>
                            alert('Request already sent, please wait');
                            window.location.href = '../index.php';
                          </script>";
                } else {
                    $updateStmt = $db->prepare("UPDATE accounts SET Password_Status = 1 WHERE UserID = ?");
                    $updateStmt->bind_param("s", $row['UserID']);
                    $updateStmt->execute();
                    $updateStmt->close();

                    echo "<script>
                            alert('Request sent');
                            window.location.href = '../index.php';
                          </script>";
                }
            } else {
                echo "<p style='color: red;'>Error checking Password_Status</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>Account not found</p>";
    }
    $stmt->close();
    $db->close();
}
?>

<div class="box-container">
    <header>FORGOT PASSWORD</header>

<form action="forgot_pass.php" method="post">


    <div class="idnum"> 
    <label for="idNum">ID Number: </label>
    <input type="text" id="idNum" name="idNum" required><br><br>
    </div>
    
    <div class="button"> 
    <input type="submit" value="Submit">
    </div>
    
    <div class="back">
    <button class="back" type="button" onclick="window.location.href='../index.php'">Back</button>
    </div>

</form>
</div>