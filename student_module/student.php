<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "management_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Log utilization
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["log_utilization"])) {
    $selectedDate = $_POST["utilization_date"];
    $currentTime = date("Y-m-d");

    if ($selectedDate < $currentTime) {
        echo "Invalid date. Please select a date equal to or after today.";
    } else {
        $date = $selectedDate;
        $time = $_POST["utilization_time"];
        $room = $_POST["utilization_room"];
        $purpose = $_POST["utilization_purpose"];
        $userID = $_SESSION['UserID'];

        $sql = "INSERT INTO utilization (UserID, Date, Time, Room, Purpose) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $userID, $date, $time, $room, $purpose);

        if ($stmt->execute()) {
            echo "Utilization logged successfully!";
            // Redirect to the same page after successful logging
            header("Location: student.php");
            exit();
        } else {
            echo "Error logging utilization: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Fetch user's name
$userID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : null;
$userFirstName = "";
$userLastName = "";

if ($userID !== null) {
    $sqlUser = "SELECT FirstName, LastName FROM users WHERE UserID = ?";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("i", $userID);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($rowUser = $resultUser->fetch_assoc()) {
        $userFirstName = $rowUser['FirstName'];
        $userLastName = $rowUser['LastName'];
    }

    $stmtUser->close();
}

// History of utilization
if ($userID === null) {
    // Handle the case where UserID is not set, such as redirecting the user to the login page.
    header("Location: ../otherpages/login.php");
    exit();
}

$sql = "SELECT * FROM utilization WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all rows and store them in an array
$utilizationRows = [];
while ($row = $result->fetch_assoc()) {
    $utilizationRows[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="css/student.css">
</head>
<body>

<div class="container">
    <div class="user-info">
        <p>Welcome, <?php echo $userFirstName . ' ' . $userLastName; ?></p>
    </div>

    <div class="log-utilization">
        <h3>Log Utilization</h3>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            Date: <input type="date" name="utilization_date" required><br>
            Time: <input type="time" name="utilization_time" required><br>
            Room #: <input type="text" name="utilization_room" required><br>
            Purpose: <input type="text" name="utilization_purpose" required><br>
            <input type="submit" name="log_utilization" value="Log Utilization">
        </form>
    </div>

    <div class="utilization-history">
        <h2>Your Utilization History:</h2>
        <table border="1">
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Room</th>
                <th>Purpose</th>
            </tr>
            <?php foreach ($utilizationRows as $row): ?>
                <tr>
                    <td><?php echo $row['Date']; ?></td>
                    <td><?php echo $row['Time']; ?></td>
                    <td><?php echo $row['Room']; ?></td>
                    <td><?php echo $row['Purpose']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="logout">
    <form method="post" action="../otherpages/logout.php">
        <p><input type="submit" name="logout" value="Logout"></p>
    </form>
</div>
</div>



</body>
</html>
