<?php
// Check existence of SalaryID parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "../db/config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM Salaries WHERE SalaryID = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_salaryID);

        // Set parameters
        $param_salaryID = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                $SalaryID = $row["SalaryID"];
                $EmployeeID = $row["EmployeeID"];
                $SalaryAmount = $row["SalaryAmount"];
                $StartDate = $row["StartDate"];
                $EndDate = $row["EndDate"];
                $PayType = $row["PayType"];
                $Currency = $row["Currency"];
            } else {
                // URL doesn't contain valid SalaryID parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else {
    // URL doesn't contain SalaryID parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <style>
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }

        .hh_button {
            display: inline-block;
            text-decoration: none;
            background: linear-gradient(to right, #ff8a00, #da1b60);
            border: none;
            color: white;
            padding: 10px 25px;
            font-size: 1rem;
            border-radius: 3px;
            cursor: pointer;
            font-family: 'Roboto', sans-serif;
            position: relative;
            margin-top: 30px;
            margin: 0px;
            position: absolute;
            right: 20px;
            top: 1.5%;
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Salary Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Salary ID</label>
                        <p class="form-control-static">
                            <?php echo $row["SalaryID"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Employee ID</label>
                        <p class="form-control-static">
                            <?php
                            echo $row["EmployeeID"];
                            ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Salary Amount</label>
                        <p class="form-control-static">
                            <?php echo $row["SalaryAmount"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <p class="form-control-static">
                            <?php echo $row["StartDate"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <p class="form-control-static">
                            <?php echo $row["EndDate"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Pay Type</label>
                        <p class="form-control-static">
                            <?php echo $row["PayType"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Currency</label>
                        <p class="form-control-static">
                            <?php echo $row["Currency"]; ?>
                        </p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>