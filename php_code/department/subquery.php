<?php
// Include config file
require_once "../db/config.php";

// Attempt join query execution
$sql = "SELECT DepartmentID, DepartmentName
FROM Departments
WHERE DepartmentID IN (
  SELECT Employees.DepartmentID
  FROM Employees
  INNER JOIN Salaries ON Employees.EmployeeID = Salaries.EmployeeID
  WHERE Salaries.SalaryAmount > (
    SELECT AVG(SalaryAmount)
    FROM Salaries
  )
)

";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>Department ID</th>";
        echo "<th>Department Name</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $count = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $count . "</td>";
            echo "<td>" . $row['DepartmentID'] . "</td>";
            echo "<td>" . $row['DepartmentName'] . "</td>";
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