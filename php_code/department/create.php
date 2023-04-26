<?php
// Include config file
require_once "../db/config.php";

// Define variables and initialize with empty values
$department_name = "";
$department_name_err = "";

$department_budget = "";
$department_budget_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate department name
    $input_department_name = trim($_POST["department_name"]);
    if (empty($input_department_name)) {
        $department_name_err = "Please enter a department name.";
    } else {
        // Prepare a select statement
        $sql = "SELECT DepartmentID FROM departments WHERE DepartmentName = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_department_name);

            // Set parameters
            $param_department_name = $input_department_name;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $department_name_err = "This department name is already taken.";
                } else {
                    $department_name = $input_department_name;
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Validate first name
    $input_department_budget = trim($_POST["department_budget"]);
    if (empty($input_department_budget)) {
        $first_name_err = "Please enter a budget value for the department.";
    } else {
        $department_budget = $input_department_budget;
    }

    // Check input errors before inserting in database
    if (empty($department_name_err) && empty($department_budget_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO departments (DepartmentName, Budget) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sd", $param_department_name, $param_department_budget);

            // Set parameters
            $param_department_name = $department_name;
            $param_department_budget = $department_budget;

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
    <title>Create Department</title>
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
        <h2>Create Department</h2>
        <p>Please fill this form and submit to add a new department to the database.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($department_name_err)) ? 'has-error' : ''; ?>">
                <label>Department Name</label>
                <input type="text" name="department_name" class="form-control" value="<?php echo $department_name; ?>">
                <span class="help-block">
                    <?php echo $department_name_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($department_budget_err)) ? 'has-error' : ''; ?>">
                <label>Department Budget</label>
                <input type="text" name="department_budget" class="form-control"
                    value="<?php echo $department_budget; ?>">
                <span class="help-block">
                    <?php echo $department_budget_err; ?>
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