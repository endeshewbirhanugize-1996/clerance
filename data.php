<?php 
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}
  include("con.php");
  $sql="create database db";
  $result=mysqli_real_query($conn, $sql);
  if( $result){
    echo "seccuss";
  }
  else{
     echo "no seccuss";
  }
  ?>