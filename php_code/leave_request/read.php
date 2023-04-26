<?php
// Check existence of LeaveRequestID parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "../db/config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM LeaveRequests WHERE LeaveRequestID = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_leaveRequestID);

        // Set parameters
        $param_leaveRequestID = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                $LeaveRequestID = $row["LeaveRequestID"];
                $EmployeeID = $row["EmployeeID"];
                $StartDate = $row["StartDate"];
                $EndDate = $row["EndDate"];
                $RequestStatus = $row["RequestStatus"];
            } else {
                // URL doesn't contain valid LeaveRequestID parameter. Redirect to error page
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
    // URL doesn't contain LeaveRequestID parameter. Redirect to error page
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
                        <h1>View Leave Request Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Leave Request ID</label>
                        <p class="form-control-static">
                            <?php echo $row["LeaveRequestID"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Employee ID</label>
                        <div>
                            <p class="form-control-static">
                                <?php echo $row["EmployeeID"]; ?>
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
                            <label>Request Status</label>
                            <p class="form-control-static">
                                <?php echo $row["RequestStatus"]; ?>
                            </p>
                        </div>
                        <p><a href="index.php" class="btn btn-primary">Back</a></p>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>