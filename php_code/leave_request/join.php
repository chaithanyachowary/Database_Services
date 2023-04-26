<?php
// Include config file
require_once "../db/config.php";

// Attempt join query execution
$sql = "SELECT LeaveRequests.LeaveRequestID, Employees.FirstName, Employees.LastName, LeaveRequests.StartDate, LeaveRequests.EndDate, LeaveRequests.RequestStatus
FROM LeaveRequests
INNER JOIN Employees ON LeaveRequests.EmployeeID = Employees.EmployeeID;

";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>LeaveRequest ID</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Start Date</th>";
        echo "<th>End Date</th>";
        echo "<th>Status</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $count = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $count . "</td>";
            echo "<td>" . $row['LeaveRequestID'] . "</td>";
            echo "<td>" . $row['FirstName'] . "</td>";
            echo "<td>" . $row['LastName'] . "</td>";
            echo "<td>" . $row['StartDate'] . "</td>";
            echo "<td>" . $row['EndDate'] . "</td>";
            echo "<td>" . $row['RequestStatus'] . "</td>";
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