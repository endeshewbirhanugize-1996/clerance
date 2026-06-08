<?php
// status_form.php
session_start();
include("database.php");

$success = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST["student_id"];
    $name       =  $_POST["name"];
    $pass       = $_POST["pass"];
    $department = $_POST["department"];
    if ($student_id === "" || $name === "" || $pass === "" || $department === "") {
        $error = "All fields are required.";
    } else {
        // Hash the password before saving
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `status_table` (`stat_id`, `stut_department`, `Stut_Full_name`, `password`) VALUES ('$student_id',
         '$department', '$name',  '$hashed_pass')";
        $stmt = mysqli_query($conn, $sql);
        if ($stmt) {
            echo"hello ethiopia";

         } else {
                $error = "Error saving status: " . mysqli_stmt_error($stmt);
            }

    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Online Clearance Status Form</title>
    <style>
        body { font-family: Arial; background: rgba(100, 193, 252, 0.41); padding: 20px; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 20px;
                     border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.2);  margin-top: 100px;}
        input, select, textarea { width: 90%; padding: 10px; margin-top: 8px; outline: none; border-radius: 5px; }
        input:hover, select:hover, textarea:hover { box-shadow: 0 0 8px aqua; }
        button { padding: 10px 15px; background: #007bff; color: #fff; border: none; cursor: pointer; margin-top: 15px; }
        button:hover { background: #0056b3; }
        .success { color: green; margin-bottom: 10px; }
        .error { color: red; margin-bottom: 10px; }
        h2 {
            text-align: center;
            font-size: 1.8em;
            font-weight: bold;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-transform: capitalize;
            color: blue;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Clearance Status Update</h2>
    <?php if ($success): ?><div class="success"><?= $success ?></div><?php endif; ?>
    <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <label>Status ID</label><br>
        <input type="text" name="student_id" placeholder="e.g., CSE/1234/12">
<br>
        <label>Status Name</label><br>
        <input type="text" name="name" placeholder="Status Name"><br>
        <label>Status Password</label><br>
        <input type="password" name="pass" placeholder="Status Password"><br>
        <label>Department</label><br>
        <select name="department">
            <option value="">Select Department</option>
            <option value="Library">Library</option>
            <option value="Finance">Finance</option>
            <option value="Registrar">Registrar</option>
            <option value="Dormitory">Dormitory</option>
            <option value="Department Head">Department Head</option>
        </select>
        <button type="submit" value="submit">Submit Status</button>
    </form>
</div>

</body>
</html>
