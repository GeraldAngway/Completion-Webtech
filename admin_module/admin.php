<link rel="stylesheet" href="../css/admin.css">

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
<a href=admin_userlogs>User Logs</a>
</div>

    <br><br>
<div class="table">
<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>ID Number</th>
            <th>Name</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
</table>
</div>
<?php
require('../database/db.php');
require('../otherpages/require_session.php');

$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
$name = "";
$role = "";

if ($userID !== null) {
    $sqlUser = "SELECT CONCAT(FirstName, ' ', LastName) AS FullName, Role FROM users WHERE UserID = ?";
    $stmtUser = $db->prepare($sqlUser);
    $stmtUser->bind_param("i", $userID);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($rowUser = $resultUser->fetch_assoc()) {
        $name = $rowUser['FullName'];
        $role = $rowUser['Role'];
    }

    $stmtUser->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $resetUserID = $_POST['resetUserID'];
    $resetIDNum = $_POST['resetIDNum'];
    $role = $_POST['role'];

    if ($role == 'Student') {
        $resetPass = password_hash($resetIDNum, PASSWORD_DEFAULT);
    } elseif ($role == 'TRIL') {
        $resetPass = password_hash('tril_cis', PASSWORD_DEFAULT);
    }

    $updateSql = "UPDATE accounts SET Password = '$resetPass', Password_Status = 0 WHERE UserID = '$resetUserID'";

    if ($db->query($updateSql) === TRUE) {
        echo "<script>
                alert('Password reset successfully');
                window.location.href = 'admin.php';
                </script>";
    } else {
        echo "Error updating record: " . $db->error;
    }
}

$sql = "SELECT u.UserID, u.IDNum, CONCAT(u.FirstName, ' ', u.LastName) AS FullName,
        u.Role FROM users u INNER JOIN accounts a ON u.UserID = a.UserID
        WHERE a.Password_Status = 1";
$result = $db->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['UserID']}</td>
                <td>{$row['IDNum']}</td>
                <td>{$row['FullName']}</td>
                <td>{$row['Role']}</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='resetUserID' value='". $row["UserID"] ."'>
                        <input type='hidden' name='resetIDNum' value='". $row["IDNum"] ."'>
                        <input type='hidden' name='role' value='". $row["Role"] ."'>
                        <input type='submit' name='reset' value='Reset'>
                    </form>
                </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No Password Reset Request/s</td></tr>";
}
$db->close();
?>

<p><strong><?php echo $name; ?></strong></p>
<p><strong><?php echo $role; ?></strong></p>

</div>
