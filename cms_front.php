<?php
include "connection.php";
// Initialize variables
$title = "";
$content = "";
$error = "";

// Check if cms_url parameter is set
if (isset($_GET['cms_url'])) {
    // Sanitize the input
    $cms_url = mysqli_real_escape_string($conn, $_GET['cms_url']);

    // Fetch CMS entry based on provided URL
    $sql = "SELECT * FROM cms WHERE cms_url = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cms_url);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['cms_title'];
        $content = $row['cms_content'];
    } else {
        $error = "CMS entry not found with provided ID";
    }

    $stmt->close();

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> CMS page</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
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
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="container mt-5 mb-5">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="card shadow-lg border-0 rounded-lg">
                                        <div class="card-body">
                                            <?php if ($error) : ?>
                                                <p><?php echo $error; ?></p>
                                            <?php else : ?>

                                                <h2 class="text-center mb-3"><?php echo $title; ?></h2>
                                                <div><?php echo nl2br(htmlspecialchars_decode($content)); ?></div>
                                            <?php endif; ?>
                                        </div>
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
<?php
} else {
    $error = "No CMS ID provided";
}
?>