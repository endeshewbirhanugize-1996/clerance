<?php
session_start();
/* 🔒 BLOCK anyone not logged in */
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}?>
<?php
include("database.php");
if (!isset($_SESSION["pass1"])) {
    die("Access denied");
}
$user_id = $_SESSION["User_id"];
$sql = "
SELECT
    s.user_id,
    s.Full_name,
    c.Class1_year,
    c.problem_insert,
    t.stat_id,
    t.stut_department
FROM mekdela_amba_info s
JOIN case_table c 
    ON s.user_id = c.user_id
JOIN status_table t 
    ON t.stat_id = c.stat_id
WHERE s.user_id = ?
";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) > 0) {
    // ✅ Fetch first row
    $firstRow = mysqli_fetch_assoc($result);
    // ✅ Student info (shown once)
   echo "<h2><strong>Acadamic Year of Clearance is</strong> {$firstRow['Class1_year']} </h2>";
    echo "<div> <p><strong>Student ID:</strong> {$firstRow['user_id']}</p>";
    echo "<p><strong>Full Name:</strong> {$firstRow['Full_name']}</p> </div>";
    // ✅ Table style
  echo" <style>
    body{
        margin:0;
        padding:0;
        font-family: 'Segoe UI', sans-serif;
        background:#eef3f8;
    }
    .card{
        max-width: 1100px;
        margin: 40px auto;
        background:white;
        padding: 30px;
        border-radius: 18px;
        box-shadow:0 15px 35px rgba(0,0,0,0.1);
    }
    h2{
        text-align:center;
        color:#003d99;
        margin-bottom:20px;
        font-size:28px;
    }
    .info{
        background:#e8f1ff;
        padding:15px;
        border-radius:10px;
        margin-bottom:25px;
        font-size:17px;
    }
    .info p{
        margin:8px 0;
        color:#00387a;
    }
    table{
        width:100%;
        border-collapse:collapse;
        margin-top:15px;
        overflow:hidden;
        border-radius:12px;
        box-shadow:0 8px 20px rgba(0,0,0,0.1);
    }
    th{
        background:#005ad3;
        color:white;
        padding:14px;
        font-size:16px;
    }
    td{
        padding:12px;
        font-size:15px;
        color:#00335b;
    }
    tr:nth-child(even){
        background:#f5f9ff;
    }
    tr:hover{
        background:#e4edff;
        transition:0.3s;
    }
    /* Signed / Not Signed Colors */
    .signed{
        color:white;
        background:#27a844;
        padding:6px 10px;
        border-radius:8px;
        font-weight:bold;
        display:inline-block;
    }
    .notsigned{
        color:white;
        background:#d62828;
        padding:6px 10px;
        border-radius:8px;
        font-weight:bold;
        display:inline-block;
    }
    .footer-img{
        width:100%;
        height:60vh;
        margin-top:25px;
        border-radius:12px;
        object-fit:cover;
        box-shadow:0 12px 25px rgba(0,0,0,0.15);
    }
</style>
<div class='card'>
";
    // ✅ Table header
    echo "<table>
        <tr>
        <th>stu_id</th>
            <th>Department</th>
            <th>Problem</th>
        </tr>";
    // ✅ First row
    echo "<tr>
        <td>{$firstRow['stat_id']}</td>
        <td>{$firstRow['stut_department']}</td>
        <td>{$firstRow['problem_insert']}</td>
    </tr>";
    // ✅ Remaining rows
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['stat_id']}</td>
            <td>{$row['stut_department']}</td>
            <td>{$row['problem_insert']}</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}
?>