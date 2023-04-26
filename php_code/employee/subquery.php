<?php
// Include config file
require_once "../db/config.php";

// Attempt subquery execution
$sql = "SELECT *
FROM Employees
WHERE DepartmentID = (
  SELECT DepartmentID
  FROM Departments
  WHERE DepartmentName = 'Sales'
);
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