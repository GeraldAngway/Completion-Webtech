<?php
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "management_system";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Initialize variables for search
    $searchIDNumber = "";
    $searchStudentName = "";
    $searchPurpose = "";
    $searchProgram = "";
    $sortField = isset($_POST['sortField']) ? $_POST['sortField'] : 'utilization.Date';
    $sortOrder = isset($_POST['sortOrder']) ? $_POST['sortOrder'] : 'DESC';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the search values from the form
        $searchIDNumber = $_POST["searchIDNumber"];
        $searchStudentName = $_POST["searchStudentName"];
        $searchPurpose = $_POST["searchPurpose"];
        $searchProgram = $_POST["searchProgram"];
        $sortField = $_POST['sortField'];
        $sortOrder = $_POST['sortOrder'];
    }

    // SQL query with search conditions, sorting, and filtering
    $sql = "SELECT users.FirstName, users.LastName, users.ID_Number, users.Program, utilization.Purpose, utilization.Room, utilization.Date, utilization.Time
            FROM utilization
            INNER JOIN users ON utilization.UserID = users.UserID
            WHERE users.ID_Number LIKE '%$searchIDNumber%'
            AND CONCAT(users.FirstName, ' ', users.LastName) LIKE '%$searchStudentName%'
            AND utilization.Purpose LIKE '%$searchPurpose%'
            AND users.Program LIKE '%$searchProgram%'
            ORDER BY $sortField $sortOrder";

    // Perform the query
    $result = $conn->query($sql);

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
                    <td>{$row['ID_Number']}</td>
                    <td>{$row['Program']}</td>
                    <td>{$row['Purpose']}</td>
                    <td>{$row['Room']}</td>
                    <td>{$row['Date']}</td>
                    <td>{$row['Time']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No utilization records found.";
    }

    // Close the connection
    $conn->close();
?>

<!-- Sorting, and Filtering -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="searchIDNumber">ID Number:</label>
    <input type="text" name="searchIDNumber" value="<?php echo $searchIDNumber; ?>">

    <label for="searchStudentName">Student Name:</label>
    <input type="text" name="searchStudentName" value="<?php echo $searchStudentName; ?>">

    <label for="searchPurpose">Purpose:</label>
    <input type="text" name="searchPurpose" value="<?php echo $searchPurpose; ?>">

    <label for="searchProgram">Program:</label>
    <input type="text" name="searchProgram" value="<?php echo $searchProgram; ?>">

    <label for="sortField">Sort By:</label>
    <select name="sortField">
        <option value="users.FirstName" <?php echo ($sortField == 'users.FirstName') ? 'selected' : ''; ?>>Name</option>
        <option value="users.ID_Number" <?php echo ($sortField == 'users.ID_Number') ? 'selected' : ''; ?>>ID</option>
        <option value="users.Program" <?php echo ($sortField == 'users.Program') ? 'selected' : ''; ?>>Program</option>
        <option value="utilization.Purpose" <?php echo ($sortField == 'utilization.Purpose') ? 'selected' : ''; ?>>Purpose</option>
        <option value="utilization.Room" <?php echo ($sortField == 'utilization.Room') ? 'selected' : ''; ?>>Room</option>
        <option value="utilization.Date" <?php echo ($sortField == 'utilization.Date') ? 'selected' : ''; ?>>Date</option>
        <option value="utilization.Time" <?php echo ($sortField == 'utilization.Time') ? 'selected' : ''; ?>>Time</option>
        <!-- Add more options for other fields as needed -->
    </select>

    <label for="sortOrder">Sort Order:</label>
    <select name="sortOrder">
        <option value="ASC" <?php echo ($sortOrder == 'ASC') ? 'selected' : ''; ?>>Ascending</option>
        <option value="DESC" <?php echo ($sortOrder == 'DESC') ? 'selected' : ''; ?>>Descending</option>
    </select>

    <input type="submit" value="Search">
</form>