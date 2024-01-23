<a href='../otherpages/logout.php'>Logout</a>

<a href='admin.php'>Reset Password Request/s</a>
<a href=>Users</a>
<a href=>User Logs</a>

<table>
    <thead>
        <tr>
            <th>ID Number</th>
            <th>Name</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

<?php
require('../database/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $resetIDNum = $_POST['reset'];

    $getIDSql = "SELECT u.IDNum FROM accounts a JOIN users u ON a.UserID = u.UserID WHERE u.IDNum = ?";

    $stmt = $db->prepare($getIDSql);
    $stmt->bind_param("s", $resetIDNum);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userID = $row['IDNum'];
        $resetPass = password_hash($userID, PASSWORD_DEFAULT);

        $updateSql = "UPDATE accounts SET password = ?, Password_Status = 0 WHERE UserID = (
            SELECT UserID FROM users WHERE IDNum = ?
        )";

        $stmt = $db->prepare($updateSql);
        $stmt->bind_param("ss", $resetPass, $resetIDNum);
        $stmt->execute();
    }

    header("Location: admin.php");
    exit();
}

$sql = "SELECT u.IDNum, u.FirstName, u.LastName, u.Role FROM accounts a JOIN users u ON a.UserID = u.UserID WHERE a.Password_Status = 1";
$result = $db->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row['FirstName'] . ' ' . $row['LastName'];
        echo "<tr>
                <td>{$row['IDNum']}</td>
                <td>{$name}</td>
                <td>{$row['Role']}</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='reset' value='{$row['IDNum']}'>
                        <input type='submit' value='Reset'>
                    </form>
                </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No Password Reset Request/s</td></tr>";
}
$db->close();
?>