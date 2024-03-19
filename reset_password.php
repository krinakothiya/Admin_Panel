<?php
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password - SB Admin</title>
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
                        <h3 class="text-center font-weight-light my-4">Reset Password</h3>
                    </div>

                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-row">

                                <div class="form-group col-md-12">
                                    <label for="Password">New Password</label>
                                    <input type="password" name="Password" id="Password" class="form-control">
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="Cpassword">Confirm New Password</label>
                                    <input type="password" name="Cpassword" id="Cpassword" class="form-control">
                                </div>

                                <div class="form-group">
                                    <!-- <button class="btn btn-primary" type="submit" name="submit">Submit</button> -->
                                    <a class='btn btn-primary' href='index.php'>Submit</a>
                                </div>
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