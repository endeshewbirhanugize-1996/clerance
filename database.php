<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$hostname="localhost";
$password="";
$username="root";
$data="student_form";
try{
$conn=mysqli_connect($hostname,$username,$password,$data);
if($conn){
}
else{
    echo "coudn`t are connected";
}} catch(mysqli_sql_exception ){
    echo " please start your xammp";
}
?>