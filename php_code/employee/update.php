<?php
// Include config file
require_once "../db/config.php";

// Define variables and initialize with empty values
// Define variables and initialize with empty values
$first_name = $last_name = $email = $phone = $address = $department_id = $manager_id = $hire_date = $gender = $date_of_birth = "";
$first_name_err = $last_name_err = $email_err = $phone_err = $address_err = $department_id_err = $manager_id_err = $hire_date_err = $gender_err = $date_of_birth_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Employee ID
    $input_employeeID = trim($_POST["id"]);
    if (empty($input_employeeID)) {
        echo "Invalid request.";
        exit();
    } else {
        $employee_id = $input_employeeID;
    }

    // Validate first name
    $input_firstName = trim($_POST["first_name"]);
    if (empty($input_firstName)) {
        $first_name_err = "Please enter a first name.";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $input_firstName)) {
        $first_name_err = "Please enter a valid first name.";
    } else {
        $first_name = $input_firstName;
    }

    // Validate last name
    $input_lastName = trim($_POST["last_name"]);
    if (empty($input_lastName)) {
        $last_name_err = "Please enter a last name.";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $input_lastName)) {
        $last_name_err = "Please enter a valid last name.";
    } else {
        $last_name = $input_lastName;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = $input_email;
    }

    // Validate phone
    $input_phone = trim($_POST["phone"]);
    if (empty($input_phone)) {
        $phone_err = "Please enter a phone number.";
    } elseif (!preg_match("/^[0-9]*$/", $input_phone)) {
        $phone_err = "Please enter a valid phone number.";
    } else {
        $phone = $input_phone;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Please enter an address.";
    } else {
        $address = $input_address;
    }

    // Validate department ID
    $input_departmentID = trim($_POST["department_id"]);
    if (empty($input_departmentID)) {
        $department_id_err = "Please enter a department ID.";
    } elseif (!preg_match("/^[0-9]*$/", $input_departmentID)) {
        $department_id_err = "Please enter a valid department ID.";
    } else {
        $department_id = $input_departmentID;
    }

    // Validate manager ID
    $input_managerID = trim($_POST["manager_id"]);
    if (!preg_match("/^[0-9]*$/", $input_managerID)) {
        $manager_id_err = $input_managerID;
    } else {
        $manager_id = $input_managerID;
    }

    // Validate hire date
    $input_hireDate = trim($_POST["hire_date"]);
    if (empty($input_hireDate)) {
        $start_date_err = "Please enter a hire date.";
    } else {
        $hire_date = $input_hireDate;
    }

    // Validate gender
    $input_gender = trim($_POST["gender"]);
    if (empty($input_gender)) {
        $gender_err = "Please select a gender.";
    } else {
        $gender = $input_gender;
    }

    // Validate date of birth
    $input_dob = trim($_POST["date_of_birth"]);
    if (empty($input_dob)) {
        $date_of_birth_err = "Please enter a date of birth.";
    } else {
        $date_of_birth = $input_dob;
    }


    // Check input errors before updating the database
    if (empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($phone_err) && empty($address_err) && empty($departmentID_err) && empty($manager_id_err) && empty($hire_date_err) && empty($gender_err) && empty($date_of_birth_err)) {
        // Prepare an update statement
        $sql = "UPDATE employees SET FirstName=?, LastName=?, Email=?, Phone=?, Address=?, DepartmentID=?, ManagerID=?, Gender=?, HireDate=?, DateOfBirth=? WHERE EmployeeID=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssiisssi", $param_firstName, $param_lastName, $param_email, $param_phone, $param_address, $param_departmentID, $param_managerID, $param_gender, $param_hireDate, $param_dateOfBirth, $param_employeeID);

            // Set parameters
            $param_firstName = $first_name;
            $param_lastName = $last_name;
            $param_email = $email;
            $param_phone = $phone;
            $param_address = $address;
            $param_departmentID = $department_id;
            $param_employeeID = $employee_id;
            $param_managerID = $manager_id;
            $param_gender = $gender;
            $param_hireDate = $hire_date;
            $param_dateOfBirth = $date_of_birth;

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
        $employeeID = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM employees WHERE EmployeeID = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_employeeID);

            // Set parameters
            $param_employeeID = $employeeID;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $employee_id = $row["EmployeeID"];
                    $first_name = $row["FirstName"];
                    $last_name = $row["LastName"];
                    $email = $row["Email"];
                    $phone = $row["Phone"];
                    $address = $row["Address"];
                    $department_id = $row["DepartmentID"];
                    $manager_id = $row["ManagerID"];
                    $hire_date = $row["HireDate"];
                    $gender = $row["Gender"];
                    $date_of_birth = $row["DateOfBirth"];
                } else {
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
                        <input type="hidden" name="id" class="form-control" value="<?php echo $employee_id; ?>">
                        <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control"
                                value="<?php echo $first_name; ?>">
                            <span class="help-block">
                                <?php echo $first_name_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
                            <span class="help-block">
                                <?php echo $last_name_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block">
                                <?php echo $email_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                            <span class="help-block">
                                <?php echo $phone_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block">
                                <?php echo $address_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($department_id_err)) ? 'has-error' : ''; ?>">
                            <label>Department ID</label>
                            <input type="number" name="department_id" class="form-control"
                                value="<?php echo $department_id; ?>">
                            <span class="help-block">
                                <?php echo $department_id_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($manager_id_err)) ? 'has-error' : ''; ?>">
                            <label>Manager ID</label>
                            <input type="number" name="manager_id" class="form-control"
                                value="<?php echo $manager_id; ?>">
                            <span class="help-block">
                                <?php echo $manager_id_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($hire_date_err)) ? 'has-error' : ''; ?>">
                            <label>Hire Date</label>
                            <input type="date" name="hire_date" class="form-control" value="<?php echo $hire_date; ?>">
                            <span class="help-block">
                                <?php echo $hire_date_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                            <label>Gender</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" value="M" <?php if ($gender == "M")
                                        echo "checked"; ?>>Male
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" value="F" <?php if ($gender == "F")
                                        echo "checked"; ?>>Female
                                </label>
                            </div>
                            <span class="help-block">
                                <?php echo $gender_err; ?>
                            </span>
                        </div>
                        <div class="form-group <?php echo (!empty($date_of_birth_err)) ? 'has-error' : ''; ?>">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control"
                                value="<?php echo $date_of_birth; ?>">
                            <span class="help-block">
                                <?php echo $date_of_birth_err; ?>
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