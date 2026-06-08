
<?php
session_start();
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}
include("database.php");
if (!isset($_SESSION["pass1"])) {
    die("Access denied");
}
$stu_id = $_SESSION["User_id"];
$sql = "
SELECT
    s.user_id,
    s.Full_name,
    e.Signitured,
    e.Class1_year,
    t.stat_id,
    t.stut_department,
    t.Stut_Full_name
FROM mekdela_amba_info s
JOIN enrolment_form e ON s.user_id= e.user_id
JOIN status_table t ON t.stat_id = e.stat_id
WHERE  s.user_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $stu_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) >0) {
    /* ✅ FIRST ROW */
    $firstRow = mysqli_fetch_assoc($result);
    echo "<h2><strong>Acadamic Year of Clearance is</strong> {$firstRow['Class1_year']} </h2>";
    echo "<p><strong>Student ID:</strong> {$firstRow['user_id']}</p>";
    echo "<p><strong>Full Name:</strong> {$firstRow['Full_name']}</p>";
    echo "
<style>
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
    echo "<table>
            <tr>
                <th>Status ID</th>
                <th>Department</th>
                <th>Status Full Name</th>
                <th>Signature</th>
            </tr>";
    /* ✅ assume all are signed */
    $allSigned = true;
    /* ✅ FIRST ROW */
    if (empty($firstRow['Signitured'])) {
        $allSigned = false;
        $signText = "Not Signed";
    } else {
        $signText = "Signed";
    }
    echo "<tr>
            <td>{$firstRow['stat_id']}</td>
            <td>{$firstRow['stut_department']}</td>
            <td>{$firstRow['Stut_Full_name']}</td>
            <td>$signText</td>
          </tr>";
    /* ✅ REMAINING ROWS */
    while ($row = mysqli_fetch_assoc($result)) {
        if (empty($row['Signitured'])) {
            $allSigned = false;
            $signText = "Not Signed";
        } else {
            $signText = "Signed";
        }
        echo "<tr>
                <td>{$row['stat_id']}</td>
                <td>{$row['stut_department']}</td>
                <td>{$row['Stut_Full_name']}</td>
                <td>$signText</td>
              </tr>";
    }
    echo "</table>";
    /* ✅ IMAGE ONLY IF ALL SIGNED */
    if ($allSigned) {
        echo "
        <img src='image1/p.jpg'
             style='width:100px%; height:10vh; object-fit:cover; margin-top:20px; 
             alt='Cleared'>
        ";
    }
}
?>
