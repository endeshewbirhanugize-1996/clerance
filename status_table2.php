  <?php
session_start();
/* 🔒 BLOCK anyone not logged in */
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color: lightcyan;
        }
        table, tr, td{
            border-collapse: collapse;
            padding: 15px;
            margin: auto;
        }
    </style>
</head>
<body>
    <a href="adduser.php">adduser</a>
    <?php
    include("database.php");
    $sql="SELECT `stat_id`, `stut_department`, `Stut_Full_name`, 
    `password`, `Insert_date` FROM `status_table`";
    $result=mysqli_query($conn, $sql);
    if(mysqli_num_rows( $result)>0){
        echo "<table border=1>";
        echo "<tr><td>stat_id</td><td>stut_department</td>
        <td>Stut_Full_name</td>
        <td>password</td><td>Insert_date</td>
     </tr>";
        while($row=mysqli_fetch_assoc($result)){
            echo "<tr><td>{$row["stat_id"]}</td>
            <td>{$row["stut_department"]}</td>
            <td>{$row["Stut_Full_name"]}</td>
            <td>{$row["password"]}</td>
            <td>{$row["Insert_date"]}</td>
            </tr>"."<br>";
        }
        echo "</table>";
    }
    else{
        echo "no insert case ";
    }
    ?>
</body>
</html>