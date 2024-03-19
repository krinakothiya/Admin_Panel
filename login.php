<?php
session_start();

include("connection.php");

$emailErr = $passwordErr = "";

$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    if (empty($email)) {
        $emailErr = "Email Address is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    if (empty($password)) {
        $passwordErr = "Password is required";
    }

    if (empty($emailErr) && empty($passwordErr)) {
        $query = "SELECT * FROM dashboard WHERE Email ='$email'";
        $data = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($data);

        if ($row) {
            $hashed_password = $row['Password'];
            if (password_verify($password, $hashed_password)) {
                $_SESSION['Email'] = $email;
                header('location:index.php');
                exit;
            } else {
                echo '<script>alert("Incorrect password")</script>';
            }
        } else {
            echo '<script>alert("User not found")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: grey;
        }

        span {
            color: red;
        }
    </style>

</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">

                                    <!-- action="login-check.php" -->
                                    <form class="login-form" method="POST" enctype="multipart/form-data">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="Email" type="email" name="Email" placeholder="name@example.com" />
                                            <label for="Email">Email address</label>
                                            <span class="error"><?php echo $emailErr; ?></span>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="Password" name="Password" type="password" placeholder="Password" />
                                            <label for="Password">Password</label>
                                            <span class="error"><?php echo $passwordErr; ?></span>
                                        </div>

                                        <!-- <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                            <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                        </div> -->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.php">Forgot Password?</a>

                                            <?php if (isset($error_message)) : ?>
                                                <div class="alert alert-danger"><?php echo $error_message; ?></div>
                                            <?php endif; ?>
                                            <div class="form-group">
                                                <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>

                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>