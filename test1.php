<?php
include "connection.php";

session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit;
}

$id = $fname = $lname = $email = "";
$error = "";
$success = "";

// Fetch the current user's information from the database
$userEmail = $_SESSION['Email'];
$sql = "SELECT * FROM dashboard WHERE Email = '$userEmail'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $fname = $row['Fname'];
    $lname = $row['Lname'];
    $email = $row['Email'];
} else {
    // Handle the case where user data is not found
    echo "User data not found!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $id = $row['id'];
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $email = $_POST['Email'];

    $sql = "UPDATE dashboard SET Fname=?, Lname=?, Email=? WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssi", $fname, $lname, $email, $id);

        if ($stmt->execute()) {
            $success = "Profile updated successfully";
            // Refresh the page after updating the profile
            header("Location: index.php");
            exit;
        } else {
            $error = "Error updating profile: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error = "Error in prepared statement: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
                    <h1 class="mt-4">Edit Profile</h1>
                    <div class="container mt-5 mb-5">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Edit Profile </h3>
                                    </div>
                                    <div class="card-body">

                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="Fname">First Name</label>
                                                <input type="text" name="Fname" id="Fname" class="form-control" value="<?php echo $fname; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="Lname">Last Name</label>
                                                <input type="text" name="Lname" id="Lname" class="form-control" value="<?php echo $lname; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="Email">Email Address</label>
                                                <input type="email" name="Email" id="Email" class="form-control " value="<?php echo $email; ?>">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit" name="submit">Update Profile</button>
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