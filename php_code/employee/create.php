<?php
// Include config file
require_once "../db/config.php";

// Define variables and initialize with empty values
$first_name = $last_name = $email = $phone = $address = $department_id = $manager_id = $hire_date = $gender = $dob = "";
$first_name_err = $last_name_err = $email_err = $phone_err = $address_err = $department_id_err = $manager_id_err = $hire_date_err = $gender_err = $dob_err = "";



// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate first name
    $input_first_name = trim($_POST["first_name"]);
    if (empty($input_first_name)) {
        $first_name_err = "Please enter a first name.";
    } else {
        $first_name = $input_first_name;
    }

    // Validate last name
    $input_last_name = trim($_POST["last_name"]);
    if (empty($input_last_name)) {
        $last_name_err = "Please enter a last name.";
    } else {
        $last_name = $input_last_name;
    }

    // Validate email
    $input_email = trim($_POST["email"]);

    if (empty($input_email)) {
        $email_err = "Please enter an email.";
    } else {
        // Check if email already exists
        $sql = "SELECT EmployeeID FROM employees WHERE Email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = $input_email;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = $input_email;
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Validate phone
    $input_phone = trim($_POST["phone"]);
    if (empty($input_phone)) {
        $phone_err = "Please enter a phone number.";
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

    // Validate manager ID
    // $input_manager_id = trim($_POST["manager_id"]);
    // if (empty($input_manager_id)) {
    //     $manager_id_err = "Please select a manager.";
    // } else {
    //     $manager_id = $input_manager_id;
    // }


    // Validate department ID
    $input_department_id = trim($_POST["department_id"]);
    if (empty($input_department_id)) {
        $department_id_err = "Please select a department.";
    } else {
        $department_id = $input_department_id;
    }

    // Validate hire date
    $input_hire_date = trim($_POST["hire_date"]);
    if (empty($input_hire_date)) {
        $hire_date_err = "Please enter a hire date.";
    } else {
        $hire_date = $input_hire_date;
    }

    // Validate gender
    $input_gender = trim($_POST["gender"]);
    if (empty($input_gender)) {
        $gender_err = "Please select a gender.";
    } else {
        $gender = $input_gender;
    }

    // Validate date of birth
    $input_dob = trim($_POST["dob"]);
    if (empty($input_dob)) {
        $dob_err = "Please enter a date of birth.";
    } else {
        $dob = $input_dob;
    }


    // Check input errors before inserting in database
    if (empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($phone_err) && empty($address_err) && empty($department_id_err) && empty($manager_id_err) && empty($hire_date_err) && empty($gender_err) && empty($dob_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO employees (FirstName, LastName, Email, Phone, Address, DepartmentID, ManagerID, HireDate, Gender, DateOfBirth) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        echo "\n" . $manager_id . "\n";
        if (empty($manager_id)) {
            $manager_id = NULL;
        }
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssiisss", $param_first_name, $param_last_name, $param_email, $param_phone, $param_address, $param_department_id, $param_manager_id, $param_hire_date, $param_gender, $param_dob);

            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_email = $email;
            $param_phone = $phone;
            $param_address = $address;
            $param_department_id = $department_id;
            $param_manager_id = $manager_id;
            $param_hire_date = $hire_date;
            $param_gender = $gender;
            $param_dob = $dob;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                // echo "Error: " . mysqli_error($link);
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
    <title>Create Record</title>
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
        <h2>Create Record</h2>
        <p>Please fill this form and submit to add employee record to the database.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
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
            <div class="form-group <?php echo (!empty($manager_id_err)) ? 'has-error' : ''; ?>">
                <label>Manager</label>
                <input type="number" name="manager_id" class="form-control" value="<?php echo $manager_id; ?>">
                <span class="help-block">
                    <?php echo $manager_id_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($department_id_err)) ? 'has-error' : ''; ?>">
                <label>Department</label>
                <input type="number" name="department_id" class="form-control" value="<?php echo $department_id; ?>">
                <span class="help-block">
                    <?php echo $department_id_err; ?>
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
            <div class="form-group <?php echo (!empty($dob_err)) ? 'has-error' : ''; ?>">
                <label>Date of Birth</label>
                <input type="date" name="dob" class="form-control" value="<?php echo $dob; ?>">
                <span class="help-block">
                    <?php echo $dob_err; ?>
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