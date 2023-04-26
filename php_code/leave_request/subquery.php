<?php
// Include config file
require_once "../db/config.php";

// Attempt join query execution
$sql = "SELECT Employees.EmployeeID, Employees.FirstName, Employees.LastName, leave_req_count.num_requests AS Total
FROM Employees
INNER JOIN (
    SELECT EmployeeID, COUNT(*) as num_requests
    FROM LeaveRequests
    GROUP BY EmployeeID
) AS leave_req_count ON Employees.EmployeeID = leave_req_count.EmployeeID;

";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>Employee ID</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Total Leave Requests</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $count = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $count . "</td>";
            echo "<td>" . $row['EmployeeID'] . "</td>";
            echo "<td>" . $row['FirstName'] . "</td>";
            echo "<td>" . $row['LastName'] . "</td>";
            echo "<td>" . $row['Total'] . "</td>";
            echo "</tr>";
            $count++;
        }
        echo "</tbody>";
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else {
        echo "<p class='lead'><em>No Record Found.</em></p>";
    }
} else {
    echo "Error: " . mysqli_error($link);
}

// Close connection
mysqli_close($link);

?>