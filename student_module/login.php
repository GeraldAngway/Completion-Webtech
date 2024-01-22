<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $idNumber = $_POST['idNumber']; 
    $password = $_POST['password']; 

    $db = new mysqli("localhost", "root", "", "management_system");

    $sql = "SELECT u.UserID, u.IDNum, a.Password
            FROM users u
            JOIN accounts a ON u.UserID = a.UserID
            WHERE u.IDNum = ?";
            
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $idNumber);
    $stmt->execute();
    $stmt->bind_result($userID, $dbIDNum, $hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if ($dbIDNum === $idNumber && password_verify($password, $hashedPassword)) {
        $_SESSION['UserID'] = $userID; 
        header("Location: index.php"); 
        exit();
    } else {
        $loginError = "Invalid ID number or password";
    }

    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../student_module/login.css">
    <title>Login</title>
</head>
<body>

<div class="box-container">
    <img src="../images/logo.png" alt="top-logo">
    <header>LOG IN</header>

<?php
if (isset($loginError)) {
    echo '<p style="color: red;">' . $loginError . '</p>';
}
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <div class="idnum"> 
    <label for="idNumber">ID Number: </label>
    <input type="text" name="idNumber" required><br>
    </div>

    <div class="pass">
    <label for="password">Password: </label>
    <input type="password" name="password" required><br>
    </div>

    <input type="submit" value="Login">
</form>

</body>
</html>
