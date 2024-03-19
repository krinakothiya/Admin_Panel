<?php
include "connection.php";

$emailErr = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["Email"])) {
        $emailErr = "Email Address is required";
    } elseif (!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        $email = $_POST["Email"];

        // Check if the email exists in the database
        $query = "SELECT * FROM dashboard WHERE Email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Check if the reset_token column already exists in the table
            $check_column_query = "SHOW COLUMNS FROM dashboard LIKE 'reset_token'";
            $check_column_result = mysqli_query($conn, $check_column_query);

            if (mysqli_num_rows($check_column_result) == 0) {
                // Generate a unique token
                $token = bin2hex(random_bytes(32));

                // Add the reset_token column to the dashboard table
                $alter_query = "ALTER TABLE dashboard ADD COLUMN reset_token VARCHAR(255)";
                mysqli_query($conn, $alter_query);

                // Store the token in the database
                $update_query = "UPDATE dashboard SET reset_token = '$token' WHERE Email = '$email'";
                mysqli_query($conn, $update_query);

                // Send an email with the password reset link
                $reset_link = "http://example.com/reset_password.php?token=$token";
                $subject = "Password Reset";
                $message = "Hello,\r\n\r\nYou have requested to reset your password. Please click the link below to reset your password:\r\n$reset_link\r\n\r\nIf you didn't request this, you can safely ignore this email.\r\n\r\nBest regards,\r\nYour Website Team";
                $headers = "From: Your Website <noreply@example.com>\r\n";
                $headers .= "Reply-To: noreply@example.com\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                if (mail($email, $subject, $message, $headers)) {
                    echo "Password reset link has been sent to your email.";
                } else {
                    echo "Failed to send password reset email.";
                }
            } else {
                echo "Password reset link has been sent to your email.";
            }
        } else {
            echo "Email address not found.";
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
    <title>Password Reset - SB Admin</title>
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
                                    <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
                                </div>
                                <div class="card-body">
                                    <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div>
                                    <form method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" name="Email" placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                            <span class="error"><?php echo $emailErr; ?></span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="login.php">Return to login</a>
                                            <input type="submit" name="submit" value="Submit">
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