<?php
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "../db/config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE EmployeeID = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                $firstName = $row["FirstName"];
                $lastName = $row["LastName"];
                $email = $row["Email"];
                $phone = $row["Phone"];
                $address = $row["Address"];
                $departmentID = $row["DepartmentID"];
                $manager_id = $row["ManagerID"];
                $hire_date = $row["HireDate"];
                $gender = $row["Gender"];
                $dob = $row["DateOfBirth"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
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
    // URL doesn't contain id parameter. Redirect to error page
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
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <p class="form-control-static">
                            <?php echo $row["FirstName"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <p class="form-control-static">
                            <?php echo $row["LastName"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <p class="form-control-static">
                            <?php echo $row["Email"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <p class="form-control-static">
                            <?php echo $row["Phone"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p class="form-control-static">
                            <?php echo $row["Address"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Department ID</label>
                        <p class="form-control-static">
                            <?php echo $row["DepartmentID"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Manager ID</label>
                        <p class="form-control-static">
                            <?php echo $row["ManagerID"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Hire Date</label>
                        <p class="form-control-static">
                            <?php echo $row["HireDate"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <p class="form-control-static">
                            <?php echo $row["Gender"]; ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <p class="form-control-static">
                            <?php echo $row["DateOfBirth"]; ?>
                        </p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>