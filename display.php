<?php
session_start();
include("database.php");
$name = $_SESSION["name"] ?? "";
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
    </style>
</head>
<body>

<img src="" alt="">
<!-- ✅ ADD USER BUTTON -->
<p id="Case1">
    <a href="caseSubmit.php">Add User</a>
</p>

<?php
$sql = "SELECT stu_id, stat_id, problem_insert FROM case_tabe";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    echo "<table>";
    echo "<tr>
            <th>Stu ID</th>
            <th>Stat ID</th>
            <th>Problem</th>
            <th>Update</th>
            <th>Delete</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {

        $stu_id = $row['stu_id']; // ✅ CORRECT ID

        echo "<tr>
                <td>{$row['stu_id']}</td>
                <td>{$row['stat_id']}</td>
                <td>{$row['problem_insert']}</td>
                <td><a href='update1.php?stuid=$stu_id'>Update</a></td>
                <td>
                    <a href='delete.php?stuid=$stu_id'
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
