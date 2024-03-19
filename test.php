<?php
include "connection.php";

session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit;
}

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate if new password and confirm password match
    if ($newPassword !== $confirmPassword) {
        $error = "New password and confirm password do not match.";
    } else {
        // Fetch user's current password from the database
        $userEmail = $_SESSION['Email'];
        $sql = "SELECT Password FROM dashboard WHERE Email = '$userEmail'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['Password'];

            // Verify if the entered current password matches the stored hashed password
            if (password_verify($currentPassword, $hashedPassword)) {
                // Hash the new password before storing it in the database
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the user's password in the database
                $updateSql = "UPDATE dashboard SET Password=? WHERE Email=?";
                $stmt = $conn->prepare($updateSql);
                if ($stmt) {
                    $stmt->bind_param("ss", $hashedNewPassword, $userEmail);
                    if ($stmt->execute()) {
                        $success = "Password changed successfully.";
                    } else {
                        $error = "Error updating password: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $error = "Error in prepared statement: " . $conn->error;
                }
            } else {
                $error = "Current password is incorrect.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <?php include "Daskbord/header.php"; ?>
    <div id="layoutSidenav">
        <?php include "Daskbord/sidebar.php"; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Change Password</h1>
                    <div class="container mt-5 mb-5">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Change Password</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($error) : ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $error; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($success) : ?>
                                            <div class="alert alert-success" role="alert">
                                                <?php echo $success; ?>
                                            </div>
                                        <?php endif; ?>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="currentPassword">Current Password</label>
                                                <input type="password" name="currentPassword" id="currentPassword" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="newPassword">New Password</label>
                                                <input type="password" name="newPassword" id="newPassword" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="confirmPassword">Confirm Password</label>
                                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include "Daskbord/footer.php"; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>