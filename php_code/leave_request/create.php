<?php
// Include config file
require_once "../db/config.php";

// Define variables and initialize with empty values
$employee_id = $start_date = $end_date = $request_status = "";
$employee_id_err = $start_date_err = $end_date_err = $request_status_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate employee ID
    $input_employee_id = trim($_POST["employee_id"]);
    if (empty($input_employee_id)) {
        $employee_id_err = "Please select an employee.";
    } else {
        $employee_id = $input_employee_id;
    }

    // Validate start date
    $input_start_date = trim($_POST["start_date"]);
    if (empty($input_start_date)) {
        $start_date_err = "Please enter a start date.";
    } else {
        $start_date = $input_start_date;
    }

    // Validate end date
    $input_end_date = trim($_POST["end_date"]);
    if (empty($input_end_date)) {
        $end_date_err = "Please enter an end date.";
    } else {
        $end_date = $input_end_date;
    }

    // Validate request status
    $input_request_status = trim($_POST["request_status"]);
    if (empty($input_request_status)) {
        $request_status_err = "Please select a request status.";
    } else {
        $request_status = $input_request_status;
    }

    // Check input errors before inserting in database
    if (empty($employee_id_err) && empty($start_date_err) && empty($end_date_err) && empty($request_status_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO LeaveRequests (EmployeeID, StartDate, EndDate, RequestStatus) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isss", $param_employee_id, $param_start_date, $param_end_date, $param_request_status);

            // Set parameters
            $param_employee_id = $employee_id;
            $param_start_date = $start_date;
            $param_end_date = $end_date;
            $param_request_status = $request_status;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Leave Request</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Create Leave Request</h2>
        <p>Please fill this form and submit to add a new leave request to the database.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($employee_id_err)) ? 'has-error' : ''; ?>">
                <label>Employee</label>
                <select name="employee_id" class="form-control">
                    <?php
                    // Attempt select query execution
                    $sql = "SELECT EmployeeID, FirstName, LastName FROM Employees";
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $selected = "";
                                if ($row['EmployeeID'] == $employee_id) {
                                    $selected = "selected";
                                }
                                echo "<option value='" . $row['EmployeeID'] . "' " . $selected . ">" . $row['FirstName'] . " " . $row['LastName'] . "</option>";
                            }
                            // Free result set
                            mysqli_free_result($result);
                        } else {
                            echo "<option value=''>No employees found.</option>";
                        }
                    } else {
                        echo "ERROR: Could not execute $sql. " . mysqli_error($link);
                    }
                    ?>
                </select>
                <span class="help-block">
                    <?php echo $employee_id_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($start_date_err)) ? 'has-error' : ''; ?>">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" value="<?php echo $start_date; ?>">
                <span class="help-block">
                    <?php echo $start_date_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($end_date_err)) ? 'has-error' : ''; ?>">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" value="<?php echo $end_date; ?>">
                <span class="help-block">
                    <?php echo $end_date_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($request_status_err)) ? 'has-error' : ''; ?>">
                <label>Request Status</label>
                <select name="request_status" class="form-control">
                    <option value="Pending" <?php if ($request_status == 'Pending')
                        echo 'selected="selected"'; ?>>Pending
                    </option>
                    <option value="Approved" <?php if ($request_status == 'Approved')
                        echo 'selected="selected"'; ?>>
                        Approved</option>
                    <option value="Rejected" <?php if ($request_status == 'Rejected')
                        echo 'selected="selected"'; ?>>
                        Rejected</option>
                </select>
                <span class="help-block">
                    <?php echo $request_status_err; ?>
                </span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="index.php" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>