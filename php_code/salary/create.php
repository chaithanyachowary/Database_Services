<?php
// Include config file
require_once "../db/config.php";

// Define variables and initialize with empty values
$employee_id = $salary_amount = $start_date = $end_date = $pay_type = $currency = "";
$employee_id_err = $salary_amount_err = $start_date_err = $end_date_err = $pay_type_err = $currency_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate employee id
    $input_employee_id = trim($_POST["employee_id"]);
    if (empty($input_employee_id)) {
        $employee_id_err = "Please select an employee.";
    } else {
        $employee_id = $input_employee_id;
    }

    // Validate salary amount
    $input_salary_amount = trim($_POST["salary_amount"]);
    if (empty($input_salary_amount)) {
        $salary_amount_err = "Please enter a salary amount.";
    } elseif (!is_numeric($input_salary_amount)) {
        $salary_amount_err = "Salary amount must be a number.";
    } else {
        $salary_amount = $input_salary_amount;
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

    // Validate pay type
    $input_pay_type = trim($_POST["pay_type"]);
    if (empty($input_pay_type)) {
        $pay_type_err = "Please select a pay type.";
    } else {
        $pay_type = $input_pay_type;
    }

    // Validate currency
    $input_currency = trim($_POST["currency"]);
    if (empty($input_currency)) {
        $currency_err = "Please select a currency.";
    } else {
        $currency = $input_currency;
    }

    // Check input errors before inserting in database
    if (empty($employee_id_err) && empty($salary_amount_err) && empty($start_date_err) && empty($end_date_err) && empty($pay_type_err) && empty($currency_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO Salaries (EmployeeID, SalaryAmount, StartDate, EndDate, PayType, Currency) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "idssss", $param_employee_id, $param_salary_amount, $param_start_date, $param_end_date, $param_pay_type, $param_currency);

            // Set parameters
            $param_employee_id = $employee_id;
            $param_salary_amount = $salary_amount;
            $param_start_date = $start_date;
            $param_end_date = $end_date;
            $param_pay_type = $pay_type;
            $param_currency = $currency;

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
                <label>Employee ID</label>
                <input type="text" name="employee_id" class="form-control" value="<?php echo $employee_id; ?>">
                <span class="help-block">
                    <?php echo $employee_id_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($salary_amount_err)) ? 'has-error' : ''; ?>">
                <label>Salary Amount</label>
                <input type="text" name="salary_amount" class="form-control" value="<?php echo $salary_amount; ?>">
                <span class="help-block">
                    <?php echo $salary_amount_err; ?>
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
            <div class="form-group <?php echo (!empty($pay_type_err)) ? 'has-error' : ''; ?>">
                <label>Pay Type</label>
                <input type="text" name="pay_type" class="form-control" value="<?php echo $pay_type; ?>">
                <span class="help-block">
                    <?php echo $pay_type_err; ?>
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
</body>

</html>