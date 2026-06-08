<?php
session_start();
/* 🔒 BLOCK anyone not logged in */
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
body {
    background: #e9f9ff;
    font-family: Arial, Helvetica, sans-serif;
    margin: 0;
    padding: 20px;
    text-align: center;
}
h1 {
    margin-bottom: 20px;
    color: #003d66;
    text-shadow: 0 0 3px #b3ecff;
}
table {
    width: 95%;
    margin: auto;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 0 15px rgba(0, 140, 170, 0.3);
    border-radius: 10px;
    overflow: hidden;
}
table th, table td {
    padding: 10px;
    border-bottom: 1px solid #cfefff;
    font-size: 15px;
}
table th {
    background: #0099cc;
    color: white;
    text-transform: uppercase;
}
table tr:hover {
    background: #f0fcff;
}
a {
    text-decoration: none;
    font-weight: bold;
}
.add-btn {
    background: #0099cc;
    color: white;
    padding: 10px 15px;
    border-radius: 6px;
    display: inline-block;
    margin-bottom: 20px;
    box-shadow: 0 0 5px #66d9ff;
}
.add-btn:hover {
    background: #007799;
}
.update-btn {
    background: #2ecc71;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}
.update-btn:hover {
    background: #25a35a;
}
.delete-btn {
    background: #e74c3c;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}
.delete-btn:hover {
    background: #c0392b;
}
span{
    border: 1px black solid;
    text-transform: capitalize;
    font-size: 3em;
    padding: 5px;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: bold;
    background-color: white;
    margin: 10px;
    border-radius: 10px;
    box-shadow: 0 0 8px burlywood;
    border: none;
}
</style>
<body>
    <div >
    <h1>MAU Student Table</h1></div>
    <div>
        <div>
        <p style=" margin-bottom :0; font-family: Arial; font-weight: bold;
           font-size: 3er;"> 
              <span id="enrl"><a href="Enrollmenttable.php">Enrollmen submit</a></span>
            <span id="case1"><a href="caseSubmit.php">caseSubmit</a></span>
            </div>
<?php
include("database.php");
$role =$_SESSION["User_role"]?? "";
$userId= $_SESSION["User_id"] ?? "";
/* ================= ADMIN & REGISTOR ================= */
if ($role === "admin") {
    $sql = "SELECT * FROM student_table";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>
                <th>Stud ID</th>
                <th>Full Name</th>
                <th>College</th>
                <th>Department</th>
                <th>Sex</th>
                <th>Program Type</th>
                <th>Enrollment Type</th>
                <th>Class Year</th>
                <th>Semester</th>
                <th>Reason Clearance</th>
                <th>Insert Date</th>
                <th id='update1'>Update</th>
                <th id='delet1'>Delete</th>
              </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $id = htmlspecialchars($row['stu_id']);
            echo "<tr>
                    <td>{$id}</td>
                    <td>" . htmlspecialchars($row['Full_name']) . "</td>
                    <td>" . htmlspecialchars($row['College']) . "</td>
                    <td>" . htmlspecialchars($row['depa_name']) . "</td>
                    <td>" . htmlspecialchars($row['sex']) . "</td>
                    <td>" . htmlspecialchars($row['Program_type']) . "</td>
                    <td>" . htmlspecialchars($row['Enrolment_type']) . "</td>
                    <td>" . htmlspecialchars($row['Class_year']) . "</td>
                    <td>" . htmlspecialchars($row['Semester']) . "</td>
                    <td>" . htmlspecialchars($row['Reason_of_clearance']) . "</td>
                    <td>" . htmlspecialchars($row['Insert_date']) . "</td>

                    <td class='update'>
                        <a href='update.php?updateid={$id}'>Update</a>
                    </td>

                    <td class='delet'>
                        <a href='delete.php?deletid={$id}'
                           onclick=\"return confirm('Are you sure you want to delete?');\">
                           Delete
                        </a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    }
}
/* ================= STUDENT ================= */
elseif ($role === "student") {
    $sql = "SELECT * FROM student_table WHERE stu_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>
                <th>Stud ID</th>
                <th>Full Name</th>
                <th>College</th>
                <th>Department</th>
                <th>Sex</th>
                <th>Program Type</th>
                <th>Enrollment Type</th>
                <th>Class Year</th>
                <th>Semester</th>
                <th>Reason Clearance</th>
                <th>Insert Date</th>
              </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['stu_id']}</td>
                    <td>{$row['Full_name']}</td>
                    <td>{$row['College']}</td>
                    <td>{$row['depa_name']}</td>
                    <td>{$row['sex']}</td>
                    <td>{$row['Program_type']}</td>
                    <td>{$row['Enrolment_type']}</td>
                    <td>{$row['Class_year']}</td>
                    <td>{$row['Semester']}</td>
                    <td>{$row['Reason_of_clearance']}</td>
                    <td>{$row['Insert_date']}</td>
                  </tr>";
        }
        echo "</table>";
    }
}
?>
</div>
<script>
    // role from PHP (FIXED variable name)
    const userRole = "<?php echo $role; ?>";
    // table cells
    const updateCells = document.querySelectorAll(".update");
    const deleteCells = document.querySelectorAll(".delet");
    // headers
    const updateHeader = document.getElementById("update1");
    const deleteHeader = document.getElementById("delet1");
    // buttons
    const case1 = document.getElementById("case1");
    const enrl  = document.getElementById("enrl");
    // hide all first
    updateCells.forEach(el => el.style.display = "none");
    deleteCells.forEach(el => el.style.display = "none");
    if (updateHeader) updateHeader.style.display = "none";
    if (deleteHeader) deleteHeader.style.display = "none";
    if (case1) case1.style.display = "none";
    if (enrl)  enrl.style.display = "none";
    // role-based display
    if (userRole === "Registor") {
        updateCells.forEach(el => el.style.display = "table-cell");
        if (updateHeader) updateHeader.style.display = "table-cell";
    }
    if (userRole === "admin") {
        updateCells.forEach(el => el.style.display = "table-cell");
        deleteCells.forEach(el => el.style.display = "table-cell");
        if (updateHeader) updateHeader.style.display = "table-cell";
        if (deleteHeader) deleteHeader.style.display = "table-cell";
    }
    if (userRole === "student") {
        if (case1) case1.style.display = "inline-block";
        if (enrl)  enrl.style.display = "inline-block";
    }
</script>   
</body>
</html>