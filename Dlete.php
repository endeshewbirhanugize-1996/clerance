<?php
session_start();
/* 🔒 BLOCK anyone not logged in */
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}?>
<?php
include("database.php");
if (isset($_GET["deletid"])) {

    $id = $_GET["deletid"];

    // DELETE query
    $sql = "DELETE FROM student_table WHERE stu_id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Deleted Successfully";
        // Redirect back after delete
        header("Location: update.php");
        exit;
    } else {
        echo "Not Deleted Successfully";
    }
}
?>


