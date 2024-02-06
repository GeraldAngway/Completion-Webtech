<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Logs</title>
    <link rel="stylesheet" href="../css/admin.css">
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
                <label for="idNumber">Search by ID Number:</label>
                <input type="text" id="idNumber" name="idNumber">
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Utilization ID</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Room</th>
                        <th>Purpose</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    require('../database/db.php');

                    // Check if a search query is submitted
                    if(isset($_GET['idNumber'])) {
                        $searchID = $_GET['idNumber'];
                        $logsSql = "SELECT u.UtilizationID, u.UserID, u.Date, u.Time, u.Room, u.Purpose, us.IDNum FROM utilization u JOIN users us ON u.UserID = us.UserID WHERE us.IDNum = '$searchID'";
                        $logsResult = $db->query($logsSql);
                    } else {
                        // If no search query, fetch all logs
                        $logsSql = "SELECT u.UtilizationID, u.UserID, u.Date, u.Time, u.Room, u.Purpose, us.IDNum FROM utilization u JOIN users us ON u.UserID = us.UserID";
                        $logsResult = $db->query($logsSql);
                    }

                    if ($logsResult && $logsResult->num_rows > 0) {
                        while ($logRow = $logsResult->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$logRow['UtilizationID']}</td>
                                    <td>{$logRow['IDNum']}</td>
                                    <td>{$logRow['Date']}</td>
                                    <td>{$logRow['Time']}</td>
                                    <td>{$logRow['Room']}</td>
                                    <td>{$logRow['Purpose']}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No User Logs</td></tr>";
                    }

                    $db->close();
                ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
