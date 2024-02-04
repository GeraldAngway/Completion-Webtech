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

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Log ID</th>
                        <th>User ID</th>
                        <th>Action</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require('../database/db.php');

                    $logsSql = "SELECT * FROM userlogs";
                    $logsResult = $db->query($logsSql);

                    if ($logsResult && $logsResult->num_rows > 0) {
                        while ($logRow = $logsResult->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$logRow['LogID']}</td>
                                    <td>{$logRow['UserID']}</td>
                                    <td>{$logRow['Action']}</td>
                                    <td>{$logRow['Timestamp']}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No User Logs</td></tr>";
                    }

                    $db->close();
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
