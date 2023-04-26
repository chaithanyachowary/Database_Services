<?php
// Include config file
require_once "../db/config.php";

// Define variables and initialize with empty values
$employee_id = $salary_amount = $start_date = $end_date = $paytype = $currency = "";
$employee_id_err = $salary_amount_err = $start_date_err = $end_date_err = $paytype_err = $currency_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Salary ID
    $input_salaryID = trim($_POST["id"]);
    if (empty($input_salaryID)) {
        echo "Invalid request.";
        exit();
    } else {
        $salary_id = $input_salaryID;
    }

    // Validate Employee ID
    $input_employeeID = trim($_POST["employee_id"]);
    if (empty($input_employeeID)) {
        $employee_id_err = "Please enter an employee ID.";
    } else {
        $employee_id = $input_employeeID;
    }

    // Validate salary amount
    $input_salaryAmount = trim($_POST["salary_amount"]);
    if (empty($input_salaryAmount)) {
        $salary_amount_err = "Please enter a salary amount.";
    } elseif (!is_numeric($input_salaryAmount)) {
        $salary_amount_err = "Please enter a valid salary amount.";
    } else {
        $salary_amount = $input_salaryAmount;
    }

    // Validate start date
    $input_startDate = trim($_POST["start_date"]);
    if (empty($input_startDate)) {
        $start_date_err = "Please enter a start date.";
    } else {
        $start_date = $input_startDate;
    }

    // Validate end date
    $input_endDate = trim($_POST["end_date"]);
    if (empty($input_endDate)) {
        $end_date_err = "Please enter an end date.";
    } else {
        $end_date = $input_endDate;
    }

    // Validate pay type
    $input_paytype = trim($_POST["paytype"]);
    if (empty($input_paytype)) {
        $paytype_err = "Please select a pay type.";
    } else {
        $paytype = $input_paytype;
    }

    // Validate currency
    $input_currency = trim($_POST["currency"]);
    if (empty($input_currency)) {
        $currency_err = "Please select a currency.";
    } else {
        $currency = $input_currency;
    }

    // Check input errors before updating the database
    if (empty($employee_id_err) && empty($salary_amount_err) && empty($start_date_err) && empty($end_date_err) && empty($paytype_err) && empty($currency_err)) {
        // Prepare an update statement
        $sql = "UPDATE salaries SET EmployeeID=?, SalaryAmount=?, StartDate=?, EndDate=?, PayType=?, Currency=? WHERE SalaryID=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "idssssi", $param_employeeID, $param_salaryAmount, $param_startDate, $param_endDate, $param_payType, $param_currency, $param_salaryID);

            // Set parameters
            $param_employeeID = $employee_id;
            $param_salaryAmount = $salary_amount;
            $param_startDate = $start_date;
            $param_endDate = $end_date;
            $param_salaryID = $salary_id;
            $param_payType = $paytype;
            $param_currency = $currency;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Close statement
                mysqli_stmt_close($stmt);
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {

        }

    }

    // Close connection
    mysqli_close($link);
} else {
    // Check existence of SalaryID parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $salary_id = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM salaries WHERE SalaryID = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_salaryID);

            // Set parameters
            $param_salaryID = $salary_id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $salary_id = $row['SalaryID'];
                    $employee_id = $row['EmployeeID'];
                    $salary_amount = $row['SalaryAmount'];
                    $start_date = $row['StartDate'];
                    $end_date = $row['EndDate'];
                    $paytype = $row["PayType"];
                    $currency = $row["Currency"];
                } else {

                    // Close statement
                    mysqli_stmt_close($stmt);

                    // URL doesn't contain valid SalaryID. Redirect to error page
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
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Record</title>
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="id" class="form-control" value="<?php echo $salary_id; ?>">
                        <div class="form-group <?php echo (!empty($employee_id_err)) ? 'has-error' : ''; ?>">
                            <label>Employee ID</label>
                            <input type="text" name="employee_id" class="form-control"
                                value="<?php echo $employee_id; ?>">
                            <span class="help-block">
                                <?php echo $employee_id_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_amount_err)) ? 'has-error' : ''; ?>">
                            <label>Salary Amount</label>
                            <input type="text" name="salary_amount" class="form-control"
                                value="<?php echo $salary_amount; ?>">
                            <span class="help-block">
                                <?php echo $salary_amount_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($start_date_err)) ? 'has-error' : ''; ?>">
                            <label>Start Date</label>
                            <input type="text" name="start_date" class="form-control"
                                value="<?php echo $start_date; ?>">
                            <span class="help-block">
                                <?php echo $start_date_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($end_date_err)) ? 'has-error' : ''; ?>">
                            <label>End Date</label>
                            <input type="text" name="end_date" class="form-control" value="<?php echo $end_date; ?>">
                            <span class="help-block">
                                <?php echo $end_date_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($paytype_err)) ? 'has-error' : ''; ?>">
                            <label>Pay Type</label>
                            <input type="text" name="paytype" class="form-control" value="<?php echo $paytype; ?>">
                            <span class="help-block">
                                <?php echo $paytype_err; ?>
                            </span>
                        </div>

                        <div class="form-group <?php echo (!empty($currency_err)) ? 'has-error' : ''; ?>">
                            <label>Currency</label>
                            <input type="text" name="currency" class="form-control" value="<?php echo $currency; ?>">
                            <span class="help-block">
                                <?php echo $currency_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>


</html>