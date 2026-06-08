<?php
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}
include("database.php");
$sql="create database student_form";
try{$result=mysqli_query($conn, $sql);
    if(!$result){
        throw new Exception("thire is no create database");
    }
}
catch(mysqli_sql_exception  $e){
    echo  $e.mysqli_error($conn);
}
?>