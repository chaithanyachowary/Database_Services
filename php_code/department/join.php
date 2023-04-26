<?php
// Include config file
require_once "../db/config.php";

// Attempt join query execution
$sql = "SELECT Departments.DepartmentID, Departments.DepartmentName, SUM(Salaries.SalaryAmount) AS TotalBudget
FROM Departments
LEFT JOIN Employees ON Departments.DepartmentID = Employees.DepartmentID
LEFT JOIN Salaries ON Employees.EmployeeID = Salaries.EmployeeID
GROUP BY Departments.DepartmentID
";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>Department ID</th>";
        echo "<th>Department Name</th>";
        echo "<th>Total Salary Budget</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $count = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $count . "</td>";
            echo "<td>" . $row['DepartmentID'] . "</td>";
            echo "<td>" . $row['DepartmentName'] . "</td>";
            echo "<td>" . $row['TotalBudget'] . "</td>";
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