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
        header("Location: Student_table.php");
        exit;
    } else {
        echo "Not Deleted Successfully";
    }
}
?>