<!--=========  delete data ============== -->
<?php
include "connection.php";

$id = $_GET['id'];

$sql = "DELETE FROM dashboard WHERE id = '$id'";
$result = mysqli_query($conn, $sql); //query ne excuted krva mate..

if ($result) {
    echo "<script>alert('Record Deleted')</script>";
?>

    <meta http-equiv="refresh" content="0; url = http://localhost/admin_panel/index.php" />

<?php
} else {
    echo "<script>alert('Failed To Delete')</script>";
}
exit;
?>