<?php
include "connection.php";

$title = $url = $content = $status = "";
$titleErr = $urlErr = $contentErr = $statusErr = "";
$error = $success = "";

// Check if cms_id parameter is provided in the URL
if (isset($_GET['cms_id'])) {
    $id = $_GET['cms_id'];

    // Fetch CMS entry based on provided ID
    $sql = "SELECT * FROM cms WHERE cms_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['cms_title'];
        $url = $row['cms_url'];
        $content = $row['cms_content'];
        $status = $row['cms_status'];
    } else {
        $error = "CMS entry not found with provided ID";
    }
    $stmt->close();
} else {
    $error = "CMS ID not provided in the URL";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = test_input($_POST['Title']);
    $url = test_input($_POST['Page_URL']);
    $content = test_input($_POST['content']);
    $status = isset($_POST['flexSwitchCheckChecked']) ? $status = 1 : $status = 0; // Set status based on checkbox

    // Validate inputs
    if (empty($title)) {
        $titleErr = "Title is required";
    }

    if (empty($url)) {
        $urlErr = "URL is required";
    }

    if (empty($content)) {
        $contentErr = "Content is required";
    }

    // If no errors, proceed with updating the CMS entry
    if (empty($titleErr) && empty($urlErr) && empty($contentErr)) {
        $sql = "UPDATE cms SET cms_title=?, cms_url=?, cms_content=?, cms_status=? WHERE cms_id=?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssii", $title, $url, $content, $status, $id);
            if ($stmt->execute()) {
                $success = "Record updated successfully";
                header("Location: cms.php");
                exit;
            } else {
                $error = "Error updating record: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Error in prepared statement: " . $conn->error;
        }
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
    <title>Edit CMS</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
    <style>
        span {
            color: red;
        }

        .body {
            background-color: rgb(229 232 237);
        }
    </style>
</head>

<body>

    <?php include "Daskbord/header.php"; ?>

    <div id="layoutSidenav">
        <?php include "Daskbord/sidebar.php"; ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit CMS</h1>
                    <div class="container mt-5 mb-5">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg">
                                    <div class="card-body">
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Add hidden input for ID -->
                                            <div class="form-group">
                                                <label for="Title">Page Title</label>
                                                <input type="text" name="Title" id="Title" value="<?php echo $title; ?>" class="form-control" placeholder="Enter Page Title">
                                                <span class="error"><?php echo $titleErr; ?></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="Page_URL">Page URL</label>
                                                <input type="text" name="Page_URL" id="Page_URL" value="<?php echo $url; ?>" class="form-control" placeholder="Enter Page URL">
                                                <span class="error"><?php echo $urlErr; ?></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="content">Page content</label>
                                                <textarea name="content" id="editor"><?php echo $content; ?></textarea>
                                                <script>
                                                    CKEDITOR.replace('editor');
                                                </script>
                                                <span class="error"><?php echo $contentErr; ?></span>
                                            </div>

                                            <div class="form-group form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="flexSwitchCheckChecked" id="flexSwitchCheckChecked" value="1" <?php if ($status == 1) echo "checked"; ?>>
                                                <label class="form-check-label" for="flexSwitchCheckChecked"> Is Active?</label>
                                            </div>

                                            <div class="form-group mt-4">
                                                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                                <a class="btn btn-secondary" href="cms.php">Cancel</a> <!-- Changed button color to secondary -->
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

<script>
    // JavaScript to generate CMS URL automatically
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('Title').addEventListener('input', function() {
            var title = this.value.trim().toLowerCase().replace(/\s+/g, '-');
            document.getElementById('Page_URL').value = title;
        });
    });
</script>