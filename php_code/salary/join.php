<?php
// Include config file
require_once "../db/config.php";

// Attempt join query execution
$sql = "SELECT employees.EmployeeID, employees.FirstName, employees.LastName, departments.DepartmentName, salaries.SalaryAmount
FROM employees
JOIN departments ON employees.DepartmentID = departments.DepartmentID
JOIN salaries ON employees.EmployeeID = salaries.EmployeeID;

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
        echo "<th>Department Name</th>";
        echo "<th>Salary</th>";
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
            echo "<td>" . $row['DepartmentName'] . "</td>";
            echo "<td>" . $row['SalaryAmount'] . "</td>";
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