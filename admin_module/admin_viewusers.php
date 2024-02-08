<link rel="stylesheet" href="../css/view.css">
<script src="../javascript/admin.js"></script>
<script src="../javascript/delete.js"></script>

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
<a href=admin_userlogs.php>User Logs</a>
</div>

    <br><br>
<div class="table">

<div class="search">
    <form method="get" action="admin_viewusers.php">
        <input type="text" id="idNumber" name="idNumber" placeholder="Search ID Number">
        <button type="submit">Search</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>ID Number</th>
            <th>Name</th>
            <th>Program</th>
            <th>Role</th>
            <th>User Status</th>
            <th>Account Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
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

        $sql = "SELECT u.UserID, u.IDNum, CONCAT(u.FirstName, ' ', u.LastName) AS Name, u.Program,
            u.Role, a.User_Status, a.Account_Status FROM users u JOIN accounts a ON u.UserID = a.UserID
            WHERE u.Role NOT IN ('Admin', 'admin')";

        if(isset($_GET['idNumber']) && !empty($_GET['idNumber'])) {
            $id_number = mysqli_real_escape_string($db, $_GET['idNumber']);
            $sql .= " AND u.IDNum = '$id_number'";
        }
        $result = mysqli_query($db, $sql);

        if (!$result) {
            die("Query failed: " . mysqli_error($db));        
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $activateButtonDisabled = ($row['Account_Status'] === 'Deactivated') ? 'disabled' : '';
            $deactivateButtonDisabled = ($row['Account_Status'] === 'Active') ? 'disabled' : '';
            echo "<tr>
                    <td>" . htmlspecialchars($row['UserID']) . "</td>
                    <td>" . htmlspecialchars($row['IDNum']) . "</td>
                    <td>" . htmlspecialchars($row['Name']) . "</td>
                    <td>" . htmlspecialchars($row['Program']) . "</td>
                    <td>" . htmlspecialchars($row['Role']) . "</td>
                    <td>" . htmlspecialchars($row['User_Status']) . "</td>
                    <td>" . htmlspecialchars($row['Account_Status']) . "</td>
                    <td>   
                        <button $deactivateButtonDisabled onclick='showActivatePopup(\"{$row['UserID']}\")'>Activate</button>
                        <button $activateButtonDisabled onclick='showDeactivatePopup(\"{$row['UserID']}\")' style='background-color: #bac526;'>Deactivate</button>
                        <button onclick='showPopup(\"{$row['UserID']}\")'>Delete</button>
                    </td>
            </tr>";
        }
        ?>
    </tbody>
</table>
        <!-- Delete User Account Popup Form -->
<div id="deletePopup" class="popup" style="display:none;">
    <form id="deleteForm" action='admin_delete.php' method='post'>
        <input type='hidden' id='deleteUser' name='userID' value=''>
        <p>Are you sure to delete this user?</p>
        <input type='password' name='admin_password' placeholder='Enter Admin Password' required>
        <input type='submit' value='Delete'>
    </form>
    <button onclick='hidePopup()'>Cancel</button>
</div>

        <!-- Activate User Account Popup Form -->
<div id="activatePopup" class="popup" style="display: none;">
    <form id="activateForm" action='admin_activate.php' method='post'>
        <input type='hidden' id='activateUser' name='userID' value=''>
        <p>Are you sure you want to activate this user?</p>
        <input type='submit' value='OK'>
    </form>
    <button onclick='hideActivatePopup()'>Cancel</button>
</div>

        <!-- Deactivate User Account Popup Form -->
<div id="deactivatePopup" class="popup" style="display: none;">
    <form id="deactivateForm" action='admin_deactivate.php' method='post'>
        <input type='hidden' id='deactivateUser' name='userID' value=''>
        <p>Are you sure you want to Deactivate this user?</p>
        <input type='submit' value='OK'>
    </form>
    <button onclick='hideDeactivatePopup()'>Cancel</button>
</div>

        <!-- Add User Account Popup Form -->
<div id="addUserPopup" class="popup" style="display: none;">
    <form id="addUserForm" action='admin_add.php' method='post'>
        <h3>Add User Account</h3>
        
        <label for='idNum'>ID Number</label>
        <input type='text' id='idNum' name='idNum' required>
        <label for='fName'>First Name:</label>
        <input type='text' id='fName' name='fName' required>
        <label for='lName'>Last Name:</label>
        <input type='text' id='lName' name='lName' required>
       
        <label for="program">Program</label>
        <select id="program" name="program" required>
            <option value=""></option>
            <option value="BSCS">BSCS</option>
            <option value="BSIT">BSIT</option>
            <option value="BMMA">BMMA</option>
            <option value="IT/CS">IT/CS</option>
        </select>
        
        <label for="role">Role</label>
        <select id="role" name="role" required>
            <option value=""></option>
            <option value="Student">Student</option>
            <option value="TRIL">TRIL</option>
        </select>

        <button class="addu" onclick="showAddUserPopup()">Add User</button>

    </form>
    <button class="cancel" onclick='hideAddUserPopup()'>Cancel</button>
</div>

<p><strong><?php echo htmlspecialchars($name); ?></strong></p>
<p><strong><?php echo htmlspecialchars($role); ?></strong></p>

</div>