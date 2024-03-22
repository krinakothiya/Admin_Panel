<!--=========  delete data ============== -->
<?php
include "connection.php";

$id = $_GET['cms_id'];

$sql = "DELETE FROM cms WHERE cms_id = '$id'";
$result = mysqli_query($conn, $sql); //query ne excuted krva mate..

if ($result) {
    echo "<script>alert('Record Deleted')</script>";
?>

    <meta http-equiv="refresh" content="0; url = http://localhost/admin_panel/cms.php" />

<?php
} else {
    echo "<script>alert('Failed To Delete')</script>";
}
exit;
?>