<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>


    <?php
    include "Daskbord/header.php";
    ?>
    <div id="layoutSidenav">
        <?php
        include "Daskbord/sidebar.php";
        ?>

        <div id="layoutSidenav_content">

            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">CMS List</h1>


                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-dark mb-3 me-5 mt-4" type="button"> <a href="cms_create.php" class="text-white" style="text-decoration : none"> Add New</button> </a>
                    </div>

                    <table class="table  table-striped table-bordered ">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Page TITLES</th>
                                <th>Page URL</th>
                                <th>IS ACTIVE</th>
                                <th>ACTION</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            include "connection.php";

                            // Pagination
                            $limit = 20;
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $start = ($page - 1) * $limit;
                            $sql = "SELECT * FROM cms LIMIT $start, $limit";
                            $result = $conn->query($sql) or die("connection is fail");

                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td> <?php echo $row['cms_id']; ?></td>
                                    <td><?php echo $row['cms_title']; ?></td>
                                    <td>
                                        <?php if ($row['cms_status'] == 1) : ?>
                                            <a target="_blank" class="link-underline link-underline-opacity-0" href='cms_front.php?cms_id=<?php echo $row['cms_id']; ?>'><?php echo $row['cms_url']; ?> </a>
                                        <?php else : ?>
                                            <a href="#" class="link-underline link-underline-opacity-0" onclick="showErrorMessage()"> <?php echo $row['cms_url']; ?> </a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php echo ($row['cms_status'] == 1) ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                        </div>
                                    </td>

                                    <td>
                                        <a class='btn btn-success' href='cms_edit.php?cms_id=<?php echo $row['cms_id']; ?>'>Edit</a>
                                        <a class='btn btn-danger' href='cms_delete.php?cms_id=<?php echo $row['cms_id']; ?>'>Delete</a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>


                    </table>

                </div>
            </main>
            <?php
            include "Daskbord/footer.php";
            ?>
        </div>
    </div>

</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>

<script>
    function showErrorMessage() {
        alert("Error: Please enable the switch to view the content.");
    }
</script>