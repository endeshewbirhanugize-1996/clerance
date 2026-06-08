<?php
session_start();
/* 🔒 BLOCK anyone not logged in */
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}?>
<?php
include("database.php");
/* ✅ Check login */
if (!isset($_SESSION["user_id"])) {
    die("Access denied");
}
/* ✅ Get student id from URL */
if (!isset($_GET['stuid'])) {
    die("Student ID not found");
}
$stuid = $_GET['stuid'];
$session_id = $_SESSION["user_id"];

/* ✅ Allow update only for own record */
if ($stuid != $session_id) {
    die("Unauthorized access");

}
/* ✅ Fetch old data */
$sql = "SELECT * FROM case_tabe WHERE stat_id='$stuid'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) != 1) {
    die("Record not found");
}
$row = mysqli_fetch_assoc($result);
/* ✅ Update data */
if (isset($_POST['Update'])) {
    $statid  = $_POST['statid'];   
    $Signitured= $_POST['Signitured'];
    $update = "UPDATE case_tabe 
               SET stat_id='$statid',
                   Signitured='$Signitured'
               WHERE stat_id='$stuid'";
    if (mysqli_query($conn, $update)) {
        header("Location: Casetable.php");
        exit;
    } else {
        echo "Update failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Case</title>
</head>
<body>
<h2>Update Case</h2>
<form method="post">
    <label>Student ID</label><br>
    <input type="text" value="<?php echo $row['stu_id']; ?>" readonly>
    <br><br>t
    <label>Status ID</label><br>
    <input type="text" name="statid" value="<?php echo $row['stat_id']; ?>" required>
    <br><br>
    <label>Problem</label><br>
    <textarea name="problem" required><?php echo $row['problem_insert']; ?></textarea>
    <br><br>
    <input type="submit" name="Update" value="Update">
</form>
</body>
</html>
