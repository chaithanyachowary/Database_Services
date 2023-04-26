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
    // Validate department ID
    $input_departmentID = trim($_POST["id"]);
    if (empty($input_departmentID)) {
        echo "Invalid request.";
        exit();
    } else {
        $department_id = $input_departmentID;
    }

    // Validate department name
    $input_departmentName = trim($_POST["department_name"]);
    if (empty($input_departmentName)) {
        $department_name_err = "Please enter a department name.";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $input_departmentName)) {
        $department_name_err = "Please enter a valid department name.";
    } else {
        $department_name = $input_departmentName;
    }

    // Validate department budget
    $input_departmentBudget = trim($_POST["department_budget"]);
    if (empty($input_departmentBudget)) {
        $department_budget_err = "Please enter a department budget.";
    } elseif (!preg_match("/^\d+(\.\d{1,2})?$/", $input_departmentBudget)) {
        $department_budget_err = "Please enter a valid department budget value.";
    } else {
        $department_budget = $input_departmentBudget;
    }

    // Check input errors before updating the database
    if (empty($department_name_err) && empty($department_budget_err)) {
        // Prepare an update statement
        $sql = "UPDATE departments SET DepartmentName=?, Budget=? WHERE DepartmentID=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sdi", $param_departmentName, $param_departmentBudget, $param_departmentID);

            // Set parameters
            $param_departmentName = $department_name;
            $param_departmentBudget = $department_budget;
            $param_departmentID = $department_id;

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
    // Check existence of EmployeeID parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $departmentID = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM departments WHERE DepartmentID = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_departmentID);

            // Set parameters
            $param_departmentID = $departmentID;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $department_id = $row['DepartmentID'];
                    $department_name = $row['DepartmentName'];
                    $department_budget = $row['Budget'];
                } else {

                    // Close statement
                    mysqli_stmt_close($stmt);

                    // URL doesn't contain valid EmployeeID. Redirect to error page
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
        // URL doesn't contain EmployeeID parameter. Redirect to error page
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
                        <input type="hidden" name="id" class="form-control" value="<?php echo $department_id; ?>">
                        <div class="form-group <?php echo (!empty($department_name_err)) ? 'has-error' : ''; ?>">
                            <label>Department Name</label>
                            <input type="text" name="department_name" class="form-control"
                                value="<?php echo $department_name; ?>">
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
            </div>
        </div>
    </div>
</body>

</html>