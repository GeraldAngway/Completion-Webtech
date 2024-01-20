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
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php
if (isset($loginError)) {
    echo '<p style="color: red;">' . $loginError . '</p>';
}
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    ID Number: <input type="text" name="idNumber" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>

</body>
</html>
