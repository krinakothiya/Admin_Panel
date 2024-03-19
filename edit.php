<?php
include "connection.php";

$id = $fname = $lname = $email = "";
$error = "";
$success = "";

$id = $_GET['id'];
$sql = "SELECT * FROM dashboard WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$fname = $row['Fname'];
$lname = $row['Lname'];
$email = $row['Email'];


if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $id = $_POST['id'];
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $email = $_POST['Email'];


    $sql = "UPDATE dashboard SET fname=?, lname=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssi", $fname, $lname, $email, $id); // Corrected bind_param()

        if ($stmt->execute()) {
            $success = "Record updated successfully";
            header("Location: index.php");
            exit;
        } else {
            $error = "Error updating record: " . $stmt->error;
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
    <title>edit Admin</title>
    <link href="css/styles.css" rel="stylesheet" />

    <style>
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
                        <h3 class="text-center font-weight-light my-4">Update Profile</h3>
                    </div>

                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-row">
                                <input type="hidden" name="id" value="<?php echo $id; ?>" class="form-control" required> <br>

                                <div class="form-group col-md-6">
                                    <label for="Fname">First Name</label>
                                    <input type="text" name="Fname" id="Fname" value="<?php echo $fname; ?>" class="form-control">

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Lname">Last Name</label>
                                    <input type="text" name="Lname" id="Lname" value="<?php echo $lname; ?>" class="form-control">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Email">Email Address</label>
                                <input type="email" name="Email" id="Email" value="<?php echo $email; ?>" class="form-control">

                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button class="btn btn-primary " type="submit" name="Update"> Update </button>
                                <a class="btn btn-primary" href="index.php">cancle</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>