<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper {
            width: 850px;
            margin: 0 auto;
        }

        .page-header h2 {
            margin-top: 0;
        }

        table tr td:last-child a {
            margin-right: 15px;
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Employee Admin Panel</h2>
                        <a href="create.php" class="btn btn-primary pull-right">Add New Employee</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "../db/config.php";
                    // Attempt select query execution
                    $sql = "SELECT * FROM employees";
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>#</th>";
                            echo "<th>First Name</th>";
                            echo "<th>Last Name</th>";
                            echo "<th>Email</th>";
                            echo "<th>Phone</th>";
                            echo "<th>Address</th>";
                            echo "<th>Department ID</th>";
                            echo "<th>Manager ID</th>";
                            echo "<th>Hire Date</th>";
                            echo "<th>Gender</th>";
                            echo "<th>DOB</th>";
                            echo "<th>Action</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['EmployeeID'] . "</td>";
                                echo "<td>" . $row['FirstName'] . "</td>";
                                echo "<td>" . $row['LastName'] . "</td>";
                                echo "<td>" . $row['Email'] . "</td>";
                                echo "<td>" . $row['Phone'] . "</td>";
                                echo "<td>" . $row['Address'] . "</td>";
                                echo "<td>" . $row['DepartmentID'] . "</td>";
                                echo "<td>" . $row['ManagerID'] . "</td>";
                                echo "<td>" . $row['HireDate'] . "</td>";
                                echo "<td>" . $row['Gender'] . "</td>";
                                echo "<td>" . $row['DateOfBirth'] . "</td>";
                                echo "<td>";
                                echo "<a href='read.php?id=" . $row['EmployeeID'] . "' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                echo "<a href='update.php?id=" . $row['EmployeeID'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                echo "<a href='delete.php?id=" . $row['EmployeeID'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else {
                            echo "<p class='lead'><em>No Record Found.</em></p>";
                        }
                    } else {
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="page-header clearfix">
                            <h4 class="pull-left">Tables Available:</h4>
                        </div>
                        <a href="../employee" class="btn btn-primary">Employee</a>
                        <a href="../department" class="btn btn-primary">Department</a>
                        <a href="../salary" class="btn btn-primary">Salary</a>
                        <a href="../leave_request" class="btn btn-primary">Leave Request</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="page-header clearfix">
                            <h4 class="pull-left">Queries:</h4>
                        </div>
                        <button type="button" class="btn btn-primary" id="btn-join">Get salary and department for every
                            employee</button>
                        <button type="button" class="btn btn-primary" id="btn-subquery">Get employee details of sales
                            department</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Handler for "Join Employees and Departments" button click
            $("#btn-join").click(function () {
                // Send AJAX request to execute SQL query
                $.ajax({
                    url: "join.php",
                    type: "POST",
                    dataType: "html",
                    success: function (result) {
                        // Show the result in a popup
                        showPopup(result);
                    },
                    error: function (xhr, status, error) {
                        alert("An error occurred while executing the SQL query: " + error);
                    }
                });
            });

            // Handler for "Get Employees with Highest Salary" button click
            $("#btn-subquery").click(function () {
                // Send AJAX request to execute SQL query
                $.ajax({
                    url: "subquery.php",
                    type: "POST",
                    dataType: "html",
                    success: function (result) {
                        // Show the result in a popup
                        showPopup(result);
                    },
                    error: function (xhr, status, error) {
                        alert("An error occurred while executing the SQL query: " + error);
                    }
                });
            });

            // Function to show the result in a popup
            function showPopup(result) {
                var popup = window.open("", "", "width=800,height=600");
                popup.document.write(`
            <html>
                <head>
                    <title>SQL Query Result</title>
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
                </head>
                <body>
                    <div class="container-fluid">
                        <table class="table table-bordered table-striped">
                            ${result}
                        </table>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"><\/script>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"><\/script>
                        </body>
                    </html>
`);
                popup.document.close();
            }

        });
    </script>

</body>

</html>