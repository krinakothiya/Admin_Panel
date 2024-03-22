<?php
include "connection.php";

$titleErr = $urlErr = $contentErr = "";

$title = $url  = $content = $status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = test_input($_POST['Title']); // Corrected input name
    $url = test_input($_POST['Page_URL']); // Corrected input name
    $content = test_input($_POST['content']); // Corrected input name
    $status = isset($_POST['flexSwitchCheckChecked']) ? 1 : 0; // Checked status

    // Validations
    if (empty($_POST["Title"])) {
        $titleErr = "Title is required";
    }

    if (empty($_POST["Page_URL"])) {
        $urlErr = "URL is required";
    }

    if (empty($_POST["content"])) {
        $contentErr = "Content is required";
    }

    // If no errors, proceed with insertion
    if (!empty($title) && !empty($url) && !empty($content)) {

        $q = "INSERT INTO `cms`(`cms_title`, `cms_url`, `cms_content`, `cms_status`) VALUES ('$title', '$url', '$content', '$status')";

        if (mysqli_query($conn, $q)) {
            echo "New record created successfully";
            header("Location: cms.php");
            exit;
        } else {
            echo "Error: " . $q . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: All data fields are required";
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
    <title>Create CMS</title>
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
                    <h1 class="mt-4">Create CMS</h1>
                    <div class="container mt-5 mb-5">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg">

                                    <div class="card-body">

                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="Title">Page Title</label>
                                                <input type="text" name="Title" id="Title" class="form-control" placeholder="Enter Page Title">
                                                <span class="error"><?php echo $titleErr; ?></span>

                                            </div>

                                            <div class="form-group">
                                                <label for="Page_URL">Page URL</label>
                                                <input type="text" name="Page_URL" id="Page_URL" class="form-control" placeholder="Enter Page URL">
                                                <span class="error"><?php echo $urlErr; ?></span>

                                            </div>

                                            <div class="form-group">
                                                <label for="content">Page content</label>
                                                <textarea name="content" id="editor"></textarea> <!-- Corrected name -->
                                                <script>
                                                    CKEDITOR.replace('editor');
                                                </script>
                                                <span class="error"><?php echo $contentErr; ?></span>

                                            </div>

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="flexSwitchCheckChecked" id="flexSwitchCheckChecked" checked>
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Is Active? </label>
                                            </div>

                                            <div class="form-group mt-4">
                                                <button class="btn btn-primary" type="submit" name="submit"> Submit</button>
                                                <a class="btn btn-primary" href="cms.php">cancel</a>
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