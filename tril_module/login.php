<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['idNumber']; // Change variable name to match the form input
    $userPassword = $_POST['password']; // Change variable name to match the form input

    // Database connection details
    $servername = "localhost";
    $usernameDB = "root";
    $dbPassword = ""; 
    $dbname = "management_system";

    // Create connection
    $conn = new mysqli($servername, $usernameDB, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to retrieve password for the given username from 'trilaccounts' table
    $sql = "SELECT password FROM trilaccounts WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();
    $stmt->close();

    // Check if the credentials are valid
    if ($storedPassword === $userPassword) {
        // Set session variable to mark the user as logged in
        $_SESSION['loggedin'] = true;

        // Redirect to the dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        $loginError = "Invalid username or password";
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRIL Login</title>
</head>
<body>

    <h2>Login</h2>

    <?php
    if (isset($loginError)) {
        echo '<p style="color: red;">' . $loginError . '</p>';
    }
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Username: <input type="text" name="idNumber" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Login">
    </form>

</body>
</html>
