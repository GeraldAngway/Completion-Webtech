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

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the search values from the form
        $searchIDNumber = $_POST["searchIDNumber"];
        $searchStudentName = $_POST["searchStudentName"];
        $searchPurpose = $_POST["searchPurpose"];
        $searchProgram = $_POST["searchProgram"];
        
        // SQL query with search conditions
        $sql = "SELECT users.FirstName, users.LastName, users.ID_Number, users.Program, utilization.Purpose, utilization.Room, utilization.Date, utilization.Time
                FROM utilization
                INNER JOIN users ON utilization.UserID = users.UserID
                WHERE users.ID_Number LIKE '%$searchIDNumber%'
                AND CONCAT(users.FirstName, ' ', users.LastName) LIKE '%$searchStudentName%'
                AND utilization.Purpose LIKE '%$searchPurpose%'
                AND users.Program LIKE '%$searchProgram%'
                ORDER BY utilization.Date DESC, utilization.Time DESC";

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
    } else {
        // If no search is performed, display all users initially
        $sql = "SELECT users.FirstName, users.LastName, users.ID_Number, users.Program, utilization.Purpose, utilization.Room, utilization.Date, utilization.Time
                FROM utilization
                INNER JOIN users ON utilization.UserID = users.UserID
                ORDER BY utilization.Date DESC, utilization.Time DESC";

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
    }

    // Close the connection
    $conn->close();
?>

<!-- HTML Form for Search -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="searchIDNumber">ID Number:</label>
    <input type="text" name="searchIDNumber" value="<?php echo $searchIDNumber; ?>">

    <label for="searchStudentName">Student Name:</label>
    <input type="text" name="searchStudentName" value="<?php echo $searchStudentName; ?>">

    <label for="searchPurpose">Purpose:</label>
    <input type="text" name="searchPurpose" value="<?php echo $searchPurpose; ?>">

    <label for="searchProgram">Program:</label>
    <input type="text" name="searchProgram" value="<?php echo $searchProgram; ?>">

    <input type="submit" value="Search">

    <!-- Reset Button (Hyperlink to reset search parameters) -->
    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">Reset</a>
</form>
