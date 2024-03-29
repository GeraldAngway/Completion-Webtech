<?php
require('../database/db.php');
require('../otherpages/require_session.php');

$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
$name = "";

if ($userID !== null) {
    $sqlUser = "SELECT CONCAT(FirstName, ' ', LastName) AS FullName FROM users WHERE UserID = ?";
    $stmtUser = $db->prepare($sqlUser);
    $stmtUser->bind_param("i", $userID);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($rowUser = $resultUser->fetch_assoc()) {
        $name = $rowUser['FullName'];
    }

    $stmtUser->close();
}

if (isset($_GET['idNumber'])) {
    $searchID = $_GET['idNumber'];
    $logsSql = "SELECT u.UtilizationID, u.UserID, u.Date, u.Time, u.Room, u.Purpose, us.IDNum, CONCAT(us.FirstName, ' ', us.LastName) AS UserName FROM utilization u JOIN users us ON u.UserID = us.UserID WHERE us.IDNum = ?";
    $stmtLogs = $db->prepare($logsSql);
    $stmtLogs->bind_param("s", $searchID);
    $stmtLogs->execute();
    $logsResult = $stmtLogs->get_result();
} else {
    $logsSql = "SELECT u.UtilizationID, u.UserID, u.Date, u.Time, u.Room, u.Purpose, us.IDNum, CONCAT(us.FirstName, ' ', us.LastName) AS UserName FROM utilization u JOIN users us ON u.UserID = us.UserID";
    $logsResult = $db->query($logsSql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Logs</title>
    <link rel="stylesheet" href="../css/userlogs.css">
</head>
<body>
<div class="box-container">

    <div class="logout">
        <a href='../otherpages/logout.php'>Logout</a>
    </div>

    <div class="reset">
        <a href='admin.php'>Reset Password Request/s</a>
    </div>

    <div class="users">
        <a href='admin_viewusers.php'>Users</a>
    </div>

    <div class="logs">
        <a href='admin_userlogs.php'>User Logs</a>
    </div>

    <br><br>

    <div class="search">
        <form method="get" action="admin_userlogs.php">
            <input type="text" id="idNumber" name="idNumber" placeholder="Search ID Number">
            <button type="submit">Search</button>
        </form>
    </div>

    <br>

    <div class="table">
        <table>
            <thead>
            <tr>
                <th>Utilization ID</th>
                <th>ID Number</th>
                <th>Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Room</th>
                <th>Purpose</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($logsResult && $logsResult->num_rows > 0) {
                while ($logRow = $logsResult->fetch_assoc()) {
                    echo "<tr>
                                    <td>" . htmlspecialchars($logRow['UtilizationID']) . "</td>
                                    <td>" . htmlspecialchars($logRow['IDNum']) . "</td>
                                    <td>" . htmlspecialchars($logRow['UserName']) . "</td>
                                    <td>" . htmlspecialchars($logRow['Date']) . "</td>
                                    <td>" . htmlspecialchars($logRow['Time']) . "</td>
                                    <td>" . htmlspecialchars($logRow['Room']) . "</td>
                                    <td>" . htmlspecialchars($logRow['Purpose']) . "</td>
                                </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No User Logs</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <p><strong>Admin <?php echo htmlspecialchars($name);  ?></strong></p>

</div>
</body>
</html>