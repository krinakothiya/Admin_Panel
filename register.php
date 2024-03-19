<?php
include "connection.php";

$fnameErr = $lnameErr = $emailErr = $passwordErr = $cpasswordErr = "";

$fname = $lname = $email = $password = $cpassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = test_input($_POST['Fname']);
    $lname = test_input($_POST['Lname']);
    $email = test_input($_POST['Email']);
    $password = test_input($_POST['Password']);
    $cpassword = test_input($_POST['Cpassword']);

    // Validations
    if (empty($fname)) {
        $fnameErr = "First Name is required";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
        $fnameErr = "Only letters and white space allowed";
    }

    if (empty($lname)) {
        $lnameErr = "Last Name is required";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
        $lnameErr = "Only letters and white space allowed";
    }

    if (empty($email)) {
        $emailErr = "Email Address is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    if (empty($password)) {
        $passwordErr = "Password is required";
    }

    if (empty($cpassword)) {
        $cpasswordErr = "Confirm Password is required";
    } elseif ($cpassword !== $password) {
        $cpasswordErr = "Passwords do not match";
    }

    // If no errors, proceed with insertion
    if (empty($fnameErr) && empty($lnameErr) && empty($emailErr) && empty($passwordErr) && empty($cpasswordErr)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepared statement to prevent SQL injection
        $q = "INSERT INTO `dashboard`(`Fname`, `Lname`, `Email`, `Password`, `Cpassword`) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $q);
        mysqli_stmt_bind_param($stmt, "sssss", $fname, $lname, $email, $hashed_password, $cpassword);

        if (mysqli_stmt_execute($stmt)) {
            echo "New record created successfully";
            // header("Location: login.php");
            // exit;
        } else {
            echo "Error: " . $q . "<br>" . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />

    <style>
        span {
            color: red;
        }

        .body {
            background-color: rgb(229 232 237);
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body class="body">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Create Account</h3>
                    </div>

                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="Fname">First Name</label>
                                    <input type="text" name="Fname" id="Fname" class="form-control">
                                    <span class="error"><?php echo $fnameErr; ?></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Lname">Last Name</label>
                                    <input type="text" name="Lname" id="Lname" class="form-control">
                                    <span class="error"><?php echo $lnameErr; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Email">Email Address</label>
                                <input type="email" name="Email" id="Email" class="form-control">
                                <span class="error"><?php echo $emailErr; ?></span>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="Password">Password</label>
                                    <input type="password" name="Password" id="Password" class="form-control">
                                    <span class="error"><?php echo $passwordErr; ?></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Cpassword">Confirm Password</label>
                                    <input type="password" name="Cpassword" id="Cpassword" class="form-control">
                                    <span class="error"><?php echo $cpasswordErr; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>