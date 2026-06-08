<?php
session_start();
include("database.php");
$name = $_SESSION["name"];
/* Clean input */
function test_input($data): string {
    return htmlspecialchars(stripslashes(trim($data)));
}
/* ---------------- FORM PROCESS ---------------- */
if (isset($_POST["Submit"])) {
    $stuid   = test_input($_POST["stuid"] ?? "");
    $fullname= test_input($_POST["fullname"] ?? "");
    $statid  = test_input($_POST["statid"] ?? "");
    $class1  = test_input($_POST["class1"] ?? "");
    $depart = test_input($_POST["depart"] ?? "");
    ;
    // Required fields
    if (empty($stuid) || empty($statid) || empty($class1) || empty($fullname)) {
        echo "<p style='color:red;text-align:center;'>❌ Please fill all fields</p>";
    }
    // Format validation
    elseif (!preg_match("/^[A-Za-z0-9]+$/", $stuid) ||
            !preg_match("/^[A-Za-z0-9]+$/", $statid)) {

        echo "<p style='color:red;text-align:center;'>❌ Invalid Student ID or Stat ID format</p>";
    } else {
        // INSERT
        $sql = "INSERT INTO `case_table` (`user_id`, `Full_name` , `department`, `stat_id`, `Class1_year`)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die("<p style='color:red;text-align:center;'>❌ Prepare failed: "
             . mysqli_error($conn) . "</p>");
        }

        mysqli_stmt_bind_param($stmt, "sssss", $stuid,
         $fullname, $statid, $class1);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p style='color:green;text-align:center;'>✅ Data inserted successfully</p>";
        } else {
            echo "<p style='color:red;text-align:center;'>❌ Error: " . mysqli_stmt_error($stmt) . "</p>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

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
<h1>Case Form</h1>
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
            <td><input type='text' name='depart' value='{$_SESSION['department1']}' required></td>
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
