<?php
    require('../database/db.php');
    require('../otherpages/require_session.php');

    // Get the current date
    $currentDate = date("Y-m-d");

    // Initialize variables for search
    $searchIDNumber = "";
    $searchStudentName = "";
    $searchPurpose = "";
    $searchProgram = "";
    $sortField = isset($_POST['sortField']) ? $_POST['sortField'] : 'utilization.Date';
    $sortOrder = isset($_POST['sortOrder']) ? $_POST['sortOrder'] : 'DESC';

    //if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the search values from the form
        $searchIDNumber = $_POST["searchIDNumber"];
        $searchStudentName = $_POST["searchStudentName"];
        $searchPurpose = $_POST["searchPurpose"];
        $searchProgram = $_POST["searchProgram"];
        $sortField = $_POST['sortField'];
        $sortOrder = $_POST['sortOrder'];

        if (isset($_POST['clearFields'])) {
            // Reset search fields to initial values
            $searchIDNumber = "";
            $searchStudentName = "";
            $searchPurpose = "";
            $searchProgram = "";
        }
    }

    //search conditions, sorting, and filtering
    $sql = "SELECT users.FirstName, users.LastName, users.IDNum, users.Program, utilization.Purpose, utilization.Room, utilization.Date, utilization.Time
        FROM utilization
        INNER JOIN users ON utilization.UserID = users.UserID
        WHERE users.IDNum LIKE '%$searchIDNumber%'
        AND CONCAT(users.FirstName, ' ', users.LastName) LIKE '%$searchStudentName%'
        AND utilization.Purpose LIKE '%$searchPurpose%'
        AND users.Program LIKE '%$searchProgram%'
        AND utilization.Date = '$currentDate' 
        ORDER BY $sortField $sortOrder";

    // Perform the query
    $result = $db->query($sql);

   
    //number of users on the current date
    $countUsersSQL = "SELECT COUNT(DISTINCT UserID) as userCount FROM utilization WHERE Date = '$currentDate'";
    $userCountResult = $db->query($countUsersSQL);

    // Check if there are results
    if ($userCountResult->num_rows > 0) {
        $row = $userCountResult->fetch_assoc();
        $userCount = $row['userCount'];
        $cnt = "<p>Total Users Today: $userCount</p>";
    } else {
        echo "Error counting users.";
    }

    // Close the connection
    $db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Tril_dashboard.css">
    <title>Dashboard</title>
</head>
<body>
<div class="container">
    <h1>TRIL Module</h1>
    <!-- Sorting, and Filtering -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="searchIDNumber">ID Number:</label>
        <input type="text" name="searchIDNumber" value="<?php echo $searchIDNumber; ?>">

        <label for="searchStudentName">Student Name:</label>
        <input type="text" name="searchStudentName" value="<?php echo $searchStudentName; ?>">

        <label for="searchPurpose">Purpose:</label>
        <input type="text" name="searchPurpose" value="<?php echo $searchPurpose; ?>">

        <label for="searchProgram">Program:</label>
        <select name="searchProgram">
            <option value="BSIT" <?php echo ($searchProgram == 'BSIT') ? 'selected' : ''; ?>>BSIT</option>
            <option value="BSCS" <?php echo ($searchProgram == 'BSCS') ? 'selected' : ''; ?>>BSCS</option>
            <option value="BMMA" <?php echo ($searchProgram == 'BMMA') ? 'selected' : ''; ?>>BMMA</option>
        </select>

        <label for="sortField">Sort By:</label>
        <select name="sortField">
            <option value="users.FirstName" <?php echo ($sortField == 'users.FirstName') ? 'selected' : ''; ?>>Name</option>
            <option value="users.IDNum" <?php echo ($sortField == 'users.IDNum') ? 'selected' : ''; ?>>ID</option>
            <option value="users.Program" <?php echo ($sortField == 'users.Program') ? 'selected' : ''; ?>>Program</option>
            <option value="utilization.Purpose" <?php echo ($sortField == 'utilization.Purpose') ? 'selected' : ''; ?>>Purpose</option>
            <option value="utilization.Room" <?php echo ($sortField == 'utilization.Room') ? 'selected' : ''; ?>>Room</option>
            
        </select>

        <label for="sortOrder">Sort Order:</label>
        <select name="sortOrder">
            <option value="ASC" <?php echo ($sortOrder == 'ASC') ? 'selected' : ''; ?>>Ascending</option>
            <option value="DESC" <?php echo ($sortOrder == 'DESC') ? 'selected' : ''; ?>>Descending</option>
        </select>
        <input type="submit" value="Search">
        <hr>
        <input type="submit" name="clearFields" value="Clear Fields">
    </form>

    <div class="logs">
    <?php
    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Program</th>
                    <th>Purpose</th>
                    <th>Room</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>";

        // Output data for each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['FirstName']} {$row['LastName']}</td>
                    <td>{$row['IDNum']}</td>
                    <td>{$row['Program']}</td>
                    <td>{$row['Purpose']}</td>
                    <td>{$row['Room']}</td>
                    <td>{$row['Date']}</td>
                    <td>{$row['Time']}</td>
                </tr>";
        }
        echo "</table>";
    } else {
        if (!empty($searchIDNumber)) {
            echo "No utilization records found for ID Number: $searchIDNumber.";
        } elseif (!empty($searchStudentName)) {
            echo "No utilization records found for Student Name: $searchStudentName.";
        } elseif (!empty($searchPurpose)) {
            echo "No utilization records found for Purpose: $searchPurpose.";
        } elseif (!empty($searchProgram)) {
            echo "No utilization records found for Program: $searchProgram.";
        } else {
            echo "No utilization records found.";
        }
    }
    ?>
    </div>

    <?php if (!empty($cnt)) : ?>
        <h5><?php echo $cnt; ?></h5>
    <?php endif; ?>


    <hr>
    <!-- Logout form -->
    <form method="post" action="logout.php">
        <input type="submit" name="logout" value="Logout">
    </form>
    <hr>
    <!-- Display current date -->
    <p>Current Date: <?php echo date("Y-m-d"); ?></p>

    <!-- Display current time -->
    <p>Current Time: <?php echo date("H:i:s"); ?></p>
</div>
</body>
</html>
