
<?php
session_start();
?>
<?php
include("database.php");
$name = $_SESSION["name"] ?? "";
$User=$_SESSION["User_role"] ?? "";
$user=$_SESSION["User_id"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case List</title>
    <style>
        body{
            background-color: lightcyan;
            font-family: Arial;
        }
        table{
            border-collapse: collapse;
            margin: auto;
        }
        table, tr, td, th{
            border: 1px solid black;
            padding: 15px;
        }
        a{
            text-decoration: none;
            color: blue;
            font-weight: bold;
        }
        #Case1{
            text-align: center;
            margin-bottom: 20px;
        }
        #ide{
            text-align: center;
            color: blue;
            font-size: 1.8em;
            font-family:   'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
            text-transform: capitalize;  
        }
         #ide:hover{
        color:aqua;
         transform: translateY(-3px);
         }
    </style>
</head>
<body>
<img src="" alt="">
<!-- ✅ ADD USER BUTTON -->
<p id="Case1">
    <a href="caseSubmit.php">Add User</a>
</p>
<?php
if ($User==="admin") {
    // ================= ADMIN =================
    $sql = "SELECT user_id, Full_name, stat_id, Class1_year, Signitured
            FROM enrolment_form";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Stat ID</th>
                <th>Class Year</th>
                <th>Signitured</th>
              </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['user_id']}</td>
                    <td>{$row['Full_name']}</td>
                    <td>{$row['stat_id']}</td>
                    <td>{$row['Class1_year']}</td>
                    <td>{$row['Signitured']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No records found.</p>";
    }
} else if($User==="subadmin") {
    // ================= USER =================
    $sql1 = "SELECT `user_id`, `Full_name`, `department`, `stat_id`, `Class1_year`, 
    `Signitured`, `Insert_date` FROM `enrolment_form`  WHERE `user_id`=?";
    $stmt = mysqli_prepare($conn, $sql1);
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Stat ID</th>
                <th>Class Year</th>
                <th>Problem</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $stu_id = $row['stat_id'];
            echo "<tr>
                    <td>{$row['user_id']}</td>
                    <td>{$row['Full_name']}</td>
                    <td>{$row['stat_id']}</td>
                    <td>{$row['Class1_year']}</td>
                    <td>{$row['Signitured']}</td>
                    <td><a href='update1.php?stuid={$stu_id}'>Update</a></td>
                    <td>
                        <a href='delete.php?stuid={$stu_id}'
                           onclick=\"return confirm('Are you sure?')\">
                           Delete
                        </a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No records found.</p>";
    }
    mysqli_stmt_close($stmt);
}
else{
    $sql="SELECT `user_id`, `Full_name`, `department`,
     `stat_id`, `Class1_year`, `Signitured`, 
     `Insert_date` FROM `enrolment_form` WHERE department=?";
      $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Stat ID</th>
                <th>Class Year</th>
                <th>Problem</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $stu_id = $row['stat_id'];
            echo "<tr>
                    <td>{$row['user_id']}</td>
                    <td>{$row['Full_name']}</td>
                    <td>{$row['stat_id']}</td>
                    <td>{$row['Class1_year']}</td>
                    <td>{$row['Signitured']}</td>
                    <td><a href='update1.php?stuid={$stu_id}'>Update</a></td>
                    <td>
                        <a href='delete.php?stuid={$stu_id}'
                           onclick=\"return confirm('Are you sure?')\">
                           Delete
                        </a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No records found.</p>";
    }
    mysqli_stmt_close($stmt);
}
?>
<!-- ✅ ROLE-BASED CONTROL -->
<script>
    let userName = "<?php echo $name; ?>";
    let addBtn = document.getElementById("Case1");
    // ✅ hide by default
    addBtn.style.display = "none";
    // ✅ only Mohamed can add user
    if(userName === "mohamed"){
        addBtn.style.display = "block";
    }
</script>
</body>
</html>
