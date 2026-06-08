<?php
session_start();

/* 🔒 BLOCK anyone not logged in */
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}
?>
<?php
include("database.php");

// ===============================
// 1. FETCH OLD DATA FOR EDIT FORM
// ===============================
$old = null;

if (isset($_GET["updateid"])) {
    $id = $_GET["updateid"];

    $sql = "SELECT * FROM student_table WHERE stu_id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $old = mysqli_fetch_assoc($result);
    } else {
        die("Invalid ID.");
    }
}

// =======================================
// 2. UPDATE DATA WHEN FORM IS SUBMITTED
// =======================================
if (isset($_POST["Update"])) {

    $ide = $_POST["updateid"];  // Old ID
    $id  = $_POST["ID"];
    $name = $_POST["name"];
    $college = $_POST["college"];
    $dep = $_POST["dep"];
    $pass = $_POST["pass"];
    $gender = $_POST["gender"];
    $program = $_POST["program"];
    $enroll = $_POST["enroll"];
    $Year1 = $_POST["Year1"];
    $Semester = $_POST["Semester"];
    $end = $_POST["end"];

    // Check Required
    if (
        empty($id) || empty($name) || empty($college) || empty($dep) ||
        empty($pass) || empty($gender) || empty($program) ||
        empty($enroll) || empty($Year1) || empty($Semester) || empty($end)
    ) {
        echo "Please fill all fields!";
        exit;
    }
// Update Query
    $sql = "UPDATE student_table SET 
               stu_id = '$id',
               Full_name= '$name',
                College= '$college',
               depa_name= '$dep',
                password= '$pass',
                sex = '$gender',
                Program_type= '$program',
               Enrolment_type= '$enroll',
                Class_year= '$Year1',
               Semster= '$Semester',
               Reason_of_clearance= '$end'
            WHERE stu_id = '$ide'";

    if (mysqli_query($conn, $sql)) {
        header("Location: Student_table.php");
        exit;
    } else {
        echo "Update Failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update MAU Student</title>
<style>
/* Your existing styles here (same as before) */
body{ margin:0; padding:0px; height:170vh; display:flex; font-family:Arial, Helvetica, sans-serif; justify-content:center; align-items:center; background:#f0f4f8; }
.card{ width:90%; max-width:1000px; margin-top:25px; color:hsl(60,11%,4%); background:#fff; border-radius:10px; padding:20px; }
.b{ padding:10px; margin-top:10px; outline:none; border-radius:5px 4px; border:1px solid; font-weight:bold; font-size:0.7em; }
.f{ width:250px; padding:10px; margin-left:50%; margin-bottom:15px; border-radius:10px; color:white; font-size:1.5em; border:none; background-color:aqua; cursor:pointer; }
.f:hover{ background-color: rgb(11, 173, 173);}
</style>
</head>
<body>
<div class="card">
<h1>Update MAU Student</h1>
<form action="update.php" method="post">
    <input type="hidden" name="updateid" value="<?php echo $old['stu_id']; ?>">
    <div class="box1">
        <input type="text" placeholder="user ID" class="b" name="ID" value="<?php echo $old['stu_id']; ?>">
        <input type="text" placeholder="Full Name" class="b" name="name" value="<?php echo $old['Full_name']; ?>">
        <input type="text" placeholder="College" class="b" name="college" value="<?php echo $old['College']; ?>">
        <input type="text" placeholder="Department" class="b" name="dep" value="<?php echo $old['depa_name']; ?>">
        <input type="password" placeholder="Password" class="b" name="pass" value="<?php echo $old['password']; ?>">
    </div>
    <div class="box">
        <div class="section-title">Gender</div>
        <label><input type="radio" name="gender" value="Male" <?php if($old['sex']=='Male') echo 'checked'; ?>> Male</label>
        <label><input type="radio" name="gender" value="Female" <?php if($old['sex']=='Female') echo 'checked'; ?>> Female</label>
    </div>
    <div class="box">
        <div class="section-title">Program Type</div>
        <?php
        $programs = ['Postgraduate','Graduate','Postgraduate Diploma','Undergraduate'];
        foreach($programs as $p){
            $checked = ($old['Program_type']==$p)? 'checked':'';
            echo "<label><input type='radio' name='program' value='$p' $checked> $p</label> ";
        }
        ?>
    </div>
    <div class="box">
        <div class="section-title">Enrollment Type</div>
        <?php
        $enrollments = ['Regular Full Time','Regular Part Time','Extension','Summer','Distance Education'];
        foreach($enrollments as $e){
            $checked = ($old['Enrolment_type']==$e)? 'checked':'';
            echo "<label><input type='radio' name='enroll' value='$e' $checked> $e</label> ";
        }
        ?>
    </div>

    <div class="box">
        <div class="section-title">Class Year</div>
        <select name="Year1">
            <?php
            for($y=1;$y<=7;$y++){
                $sel = ($old['Class_Year']==$y.' Year')? 'selected':'';
                echo "<option value='{$y} Year' $sel>{$y} Year</option>";
            }
            ?>
        </select>
        <select name="Semester">
            <option value="1st Semester" <?php if($old['Semster']=='1st Semester') echo 'selected'; ?>>1st Semester</option>
            <option value="2nd Semester" <?php if($old['Semster']=='2nd Semester') echo 'selected'; ?>>2nd Semester</option>
        </select>
    </div>
    <div class="box">
        <div class="section-title">Reason for Clearance</div>
        <select name="end">
            <?php
            $reasons = ['End of Academic Year','Disciplinary Case','Forced Withdrawal','Withdrawal Due to Health/Family Problem','Academic Dismissal','Graduation','ID Replacement'];
            foreach($reasons as $r){
                $sel = ($old['Reason_Clearance']==$r)? 'selected':'';
                echo "<option value='$r' $sel>$r</option>";
            }
            ?>
        </select>
    </div>
    <input type="submit" value="Update" name="Update" class="f">
</form>
</div>
</body>
</html>
