<?php
session_start();
include("database.php");
$name = $_SESSION["name"] ?? "";
/* Clean input */
function test_input(string $data): string {
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}
/* ---------------- FORM PROCESS ---------------- */
if (isset($_POST["Submit"])) {

    $stuid        = test_input($_POST["stuid"] ?? "");
    $fullname     = test_input($_POST["fullname"] ?? "");
    $statid       = test_input($_POST["statid"] ?? "");
    $class1       = test_input($_POST["class1"] ?? "");
    $department1  = test_input($_POST["department1"] ?? "");

    /* Required fields */
    if (empty($stuid) || empty($statid) || empty($class1)
        || empty($fullname) || empty($department1)) {
        echo "<p style='color:red;text-align:center;'>❌ Please fill all fields</p>";
    }
    /* Format validation */
    elseif (!preg_match("/^[A-Za-z0-9]+$/", $stuid)
         || !preg_match("/^[A-Za-z0-9]+$/", $statid)) {
        echo "<p style='color:red;text-align:center;'>
        ❌ Invalid Student ID or Stat ID format</p>";
    }
    else {
        /* Check duplicate year & department */
        $checkSql = "SELECT stat_id, Class1_year 
                     FROM enrolment_form 
                     WHERE user_id = ?";
        $checkStmt = mysqli_prepare($conn, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "s", $stuid);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        $duplicate = false;
        while ($row = mysqli_fetch_assoc($checkResult)) {
            if ($statid=== $row['stat_id'] && $class1 === $row['Class1_year']) {
                $duplicate = true;
                break;
            }
        }
        mysqli_stmt_close($checkStmt);
        if ($duplicate) {
            echo "<p style='color:red;text-align:center;'>❌ Cannot insert two records for the same year and department</p>";
        } else {
            /* INSERT */
            $sql = "INSERT INTO enrolment_form 
                    (user_id, department, Full_name, stat_id, Class1_year)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if (!$stmt) {
                die("<p style='color:red;text-align:center;'>❌ Prepare failed: " . mysqli_error($conn) . "</p>");
            }
            mysqli_stmt_bind_param(
                $stmt,
                "sssss",
                $stuid,
                $department1,
                $fullname,
                $statid,
                $class1
            );
            if (mysqli_stmt_execute($stmt)) {
                echo "<p style='color:green;text-align:center;'>✅ Data inserted successfully</p>";
            } else {
                echo "<p style='color:red;text-align:center;'>❌ Error: " . mysqli_stmt_error($stmt) . "</p>";
            }
            mysqli_stmt_close($stmt);
        }
    }
}?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Insert Case Form</title>
<style>
body { background-color: lightcyan; font-family: Arial; }
table { border-collapse: collapse; margin: auto; }
table, th, td { border:1px solid black; padding: 10px; }
input { padding: 5px; }
h1 {
    color:blue;
    text-align: center;
    text-transform: capitalize;
    font-size: 3em;
    font-weight: bold;
}
</style>
</head>
<body>
<h1>Enrolment Form</h1>
<?php
/* ---------------- DISPLAY TABLE ---------------- */
$sql = "SELECT stat_id, stut_department, Stut_Full_name
        FROM status_table";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    echo "<table>
            <tr>
              <th>Student ID</th>
              <th>Student Name</th>
              <th>Student Deprtment</th>
              <th>Stat ID</th>
              <th>Class Year</th>
              <th>Action</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $stat_id   = $row["stat_id"];
        echo "<tr>
            <form method='POST'>
            <td><input type='text' name='stuid' value='{$_SESSION["User_id"]}' required></td>
            <td><input type='text' name='fullname' value='$name' required></td>
            <td><input type='text' name='statid' value='{$stat_id}' required></td>
            <td><input type='text' name='class1' value='{$_SESSION['Year1']}' required></td>
            <td><input type='text' name='department1' value='{$_SESSION['department1']}' required></td>
            <td><input type='submit' name='Submit' value='Submit'></td>
            </form>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center;'>No cases found</p>";
}
?>
</body>
</html>
