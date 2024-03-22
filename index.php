<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['Email'])) {
    header("Location: login.php");
    exit;
}

?>

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
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>


                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "connection.php";

                        // Pagination
                        $limit = 20;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $start = ($page - 1) * $limit;
                        $sql = "SELECT * FROM dashboard LIMIT $start, $limit";
                        $result = $conn->query($sql) or die("connection is fail");

                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['Fname']; ?></td>
                                <td><?php echo $row['Lname']; ?></td>
                                <td><?php echo $row['Email']; ?></td>

                                <td>
                                    <a class='btn btn-success' href='edit.php?id=<?php echo $row['id']; ?>'>Edit</a>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
</body>

</html>