<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php"); 
    exit();
}

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
    $currentTime = date("Y-m-d"); // Current date

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
            header("Location: index.php");
            exit();
        } else {
            echo "Error logging utilization: " . $stmt->error;
        }

        $stmt->close();
    }
}

// History of utilization
$userID = $_SESSION['UserID'];
$sql = "SELECT * FROM utilization WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Your Utilization History:</h2>";
echo "<table border='1'><tr><th>Date</th><th>Time</th><th>Room</th><th>Purpose</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['Date']}</td><td>{$row['Time']}</td><td>{$row['Room']}</td><td>{$row['Purpose']}</td></tr>";
}

echo "</table>";

$stmt->close();
$conn->close();
?>

<!-- Utilization Log Form -->

<link rel="stylesheet" href="css/student.css">
<h3>Log Utilization</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Date: <input type="date" name="utilization_date" required><br>
    Time: <input type="time" name="utilization_time" required><br>
    Room #: <input type="text" name="utilization_room" required><br>
    Purpose: <input type="text" name="utilization_purpose" required><br>
    <input type="submit" name="log_utilization" value="Log Utilization">
</form>
