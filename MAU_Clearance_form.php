<?php
session_start();
define("AES_KEY", "1234567890123456"); // 16 bytes
define("AES_IV", "1234567890123456");
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;}
include("database.php");
$nameerr = "";
$session_id   = $_SESSION["User_id"]  ;
$session_name = $_SESSION["name"];
$session_pass1= $_SESSION["pass1"];
function aes_encrypt($data) {
    return openssl_encrypt($data, "AES-128-CBC", AES_KEY, 0, AES_IV);
}
function test_input($data){
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Id       = test_input($_POST["ID"] ?? "");
    $name     = test_input($_POST["name"] ?? "");
    $college  = test_input($_POST["college"] ?? "");
    $dep      = test_input($_POST["dep"] ?? "");
    $pass     = test_input($_POST["pass"] ?? "");
    $gender   = $_POST["gender"] ?? "";
    $program  = $_POST["program"] ?? "";
    $enroll   = $_POST["enroll"] ?? "";
    $Year1    = $_POST["Year1"] ?? "";
    $Semester = $_POST["Semestr"] ?? "";
    $end      = $_POST["end"] ?? "";
    $_SESSION['Year1']= $Year1;
    $_SESSION['department1']=  $dep ;
    /* ✅ EMPTY CHECK */

  if  (empty($Id) || empty($name) || empty($college) || empty($dep) || empty($pass) || empty($gender) || empty($program) || empty($enroll) || empty($Year1)) {
        $nameerr = "❌ Please fill all required fields";
    }
    /* ✅ FORMAT VALIDATION */
    elseif (!preg_match("/^[A-Za-z\s]+$/",
     $college) || !preg_match("/^[A-Za-z\s]+$/",
      $dep) || strlen($pass) < 6) {
        $nameerr = "❌ Invalid input (password min 6 chars)";
    }
    /* ✅ ID, Name & Password MUST MATCH LOGIN */
    else {
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
        /* ✅ CHECK IF STUDENT ALREADY SUBMITTED THIS YEAR */
        $sql1 = "SELECT Class_year FROM student_table WHERE Full_name = ?";
        $stmt = mysqli_prepare($conn, $sql1);
        if ($stmt === false) {
            die("Prepare failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $existingYear);
        $alreadySubmitted = false;
        while (mysqli_stmt_fetch($stmt)) {
            if ($Year1 === $existingYear) {
                $alreadySubmitted = true;
                break;
            }
        }
        mysqli_stmt_close($stmt);

        if ($alreadySubmitted) {
            $nameerr = "❌ Don't submit data twice in one year!";
        } else {
                       if ($Id !== $session_id || $name !== $session_name || 
                       $hashedPass !== $session_pass1) {
        $nameerr = "❌ ID, Password and Name must match login information";
    }
                $enc_Id = aes_encrypt($Id );
                $enc_college = aes_encrypt($college);
                $enc_dep     = aes_encrypt($dep);
            /* ✅ INSERT DATA */
            $sql2 = "INSERT INTO student_table 
                (stu_id, Full_name, College, depa_name, password, sex,
                 Program_type, Enrolment_type, Class_year,
                  Semester, Reason_of_clearance)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql2);
            if (!$stmt) {
                $nameerr = "❌ Database prepare failed: " . mysqli_error($conn);
            } else {
                mysqli_stmt_bind_param($stmt, "sssssssssss",
                 $enc_Id , $name , $enc_college,
                  $enc_dep  , $hashedPass, $gender,
                 $program, $enroll, $Year1, $Semester, $end);

                if (mysqli_stmt_execute($stmt)) {
                    header("Location: Student_table.php");
                    exit;
                } else {
                    $nameerr = "❌ Database execute failed: " . mysqli_error($conn);
                }

                mysqli_stmt_close($stmt);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MAU Clearance Form</title>
<style>
body{
    background:#f0f4f8;
    font-family: 'Segoe UI', sans-serif;
    margin:0;
    padding:0;
}
.card{
    background:#fff;
    width:90%;
    max-width:1000px;
    margin:40px auto;
    border-radius:12px;
    padding:30px;
    box-shadow:0 15px 30px rgba(0,0,0,.1);
}
h1{
    text-align:center;
    color:#1a3dc1;
}
.box1{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:15px;
}
.b, select{
    padding:12px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:15px;
}
.b:focus, select:focus{
    border-color:#1a3dc1;
    outline:none;
    box-shadow:0 0 5px rgba(26,61,193,.3);
}
.section-title{
    font-weight:bold;
    margin:15px 0 5px;
    color:#1a3dc1;
}
.radio-group label{
    margin-right:15px;
    font-size:14px;
}
.f{
    width:200px;
    padding:12px;
    margin:30px auto 0;
    display:block;
    background:#1a3dc1;
    color:#fff;
    font-size:18px;
    border:none;
    border-radius:10px;
    cursor:pointer;
}
.f:hover{
    background:#1230a5;
}
.erro{
    color:red;
    font-weight:bold;
    text-align:center;
    display:block;
    margin-bottom:10px;
}
</style>
</head>
<body>
<div class="card">
    <h1>MAU Student Clearance Form</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
    <div class="auto-grid">
                   <span class="erro"><?php echo  $nameerr; ?></span>
        <div class="box1">
            <input type="text" placeholder="user ID" class="b" name="ID" value="<?php echo $session_id?>">
            <input type="text" placeholder="Full Name" class="b" name="name" value=" <?php echo $session_name ?>">
            <input type="text" placeholder="College" class="b"   name="college">
            <input type="text" placeholder="Department" class="b" name="dep">
            <input type="password" placeholder="password" class="b" name="pass" value="<?php echo $session_pass1 ?>">
        </div>
        <div class="box">
            <div class="section-title">Gender</div>
            <div class="radio-group">
                <label><input type="radio" name="gender" value="Male"> Male</label>
                <label><input type="radio" name="gender" value="Female"> Female</label>
            </div>
            <div class="section-title" style="margin-top:15px;">Program Type</div>
            <div class="radio-group">
                <label><input type="radio" name="program" value="Postgraduate" checked> Postgraduate</label>
                <label><input type="radio" name="program" value=" Graduate"> Graduate</label>
                <label><input type="radio" name="program"  value="Postgraduate Diploma"> Postgraduate Diploma</label>
                <label><input type="radio" name="program"  value=" Undergraduate"> Undergraduate</label>
            </div>
        </div>
        <div class="box">
            <div class="section-title">Enrollment Type</div>
            <div class="radio-group">
                <label><input type="radio" name="enroll" value="Regular Full Time"> Regular Full Time</label>
                <label><input type="radio" name="enroll"  value="Regular Part Time"> Regular Part Time</label>
                <label><input type="radio" name="enroll"  value=" Extension"> Extension</label>
                <label><input type="radio" name="enroll"   value="Summer"> Summer</label>
                <label><input type="radio" name="enroll"    value=" Distance Education"> Distance Education</label>
            </div>
        </div>
        <div class="box" id="c">
            <div class="section-title" style="height: 10vh; margin-top: 10px;">Class Year</div>
            <select  name="Year1" style="width: 500px; padding: 5px ;font: 0.7em sans-serif;  margin-left: 25px;
            border: 1px solid; outline: none; border-radius: 5px;
          font-family: Arial, Helvetica, sans-serif;font-weight: bold;margin-bottom:20px; " >
                <option  value="1 Year" selected>1 Year</option>
                <option   value="2 Year">2 Year</option>
                <option   value="3 Year">3 Year</option>
                <option   value="4 Year">4 Year</option>
                <option   value="5 Year">5 Year</option>
                <option   value="6 Year">6 Year</option>
                <option   value="7 Year">7 Year</option>
            </select>
            <select   name="Semestr" style="width: 500px; padding: 5px ;font: 0.7em sans-serif; margin-left: 10px;
            border: 1px solid; outline: none; border-radius: 5px;
           margin-left: 0; " >
                <option   value="1st Semester" >1st Semester</option>
                <option   value="2nd Semester" selected>2nd Semester</option>
            </select>
        </div>

        <div class="box" style="grid-column: 1 / -1;">
            <div class="section-title">Reason for Clearance</div>
            <select  name="end"  style=" width: 500px; padding: 5px ;font: 0.7em sans-serif; margin-left: 10px;
            border: 1px solid; outline: none; border-radius: 5px;
            margin-left: 15px; margin-top: 30px; font-family: Arial, Helvetica, sans-serif;
            font-weight: bold; text-transform: capitalize;">
                <option class="j"  value="End of Academic Year" >End of Academic Year</option>
                <option class="j"  value="Disciplinary Case" selected>Disciplinary Case</option>
                <option class="j"   value="Forced Withdrawal">Forced Withdrawal</option>
                <option class="j"   value="Withdrawal Due to Health/Family Problem">Withdrawal Due to Health/Family Problem</option>
                <option class="j"  value="Academic Dismissal">Academic Dismissal</option>
                <option class="j"  value="Graduation">Graduation</option>
                <option class="j"   value="ID Replacement">ID Replacement</option>
            </select>
        </div>
         <input type="submit" value="Submit" name="Submit" class="f">
         <p style="font-family : 'Courier New', Courier, monospace; font-size: 1.5em; margin-top: 10px;
         word-spacing: 0.007em; color : black; font-weight:bold; text-transform:  capitalize;" > you have alreday insert informtion <a href="Clearancedasbord.php">ClearanceViwe</a>  </p>
    </div>
</form>
</div>
</body>
</html>