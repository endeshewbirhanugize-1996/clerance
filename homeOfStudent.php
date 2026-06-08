<?php
session_start();
/* ✅ Example session value (remove this in real login system) */
// $_SESSION["name"] = "demeke";
/* 🔒 Check if user is logged in */
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");  
    exit;
}
/* Get user role */
$roll = $_SESSION["User_role"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: #04c9cfff;
            font-family: Arial, sans-serif;
            color: #1583e9;
            text-align: center;
        }
        .imge{
            height: 120px;
            margin-top: 10px;
            border-radius: 50%;
            box-shadow: 0 0 10px blue;
        }

        .user{
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            width: 90%;
            max-width: 900px;
            border-radius: 30px;
            box-shadow: 0 0 10px aquamarine;
        }
        ul.name{
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        ul.name li{
            margin: 10px;
        }
        ul.name a{
            text-decoration: none;
            color: #22b8f4ff;
            background-color: white;
            padding: 8px 15px;
            border-radius: 10px;
            box-shadow: 0 0 8px aquamarine;
            font-weight: bold;
            display: inline-block;
        }
        ul.name a:hover{
            background-color: skyblue;
        }
    </style>
</head>
<body>
    <img src="image1/IMG_20250911_073115.jpg" class="imge" alt="User">
    <div class="user">
        <h1>MAU Online Clearance System</h1>
        <ul class="name">
            <li id="stud"><a href="Student_table.php">Student View</a></li>
            <li id="stat"><a href="status_table2.php">Status View</a></li>
            <li id="case"><a href="Casetable.php">Case View</a></li>
            <li id="Registoruser"><a href="Mekdel_amba_unvirsity_information_table.php">Registor user</a></li>
            <li id="Enrolmen"><a href="EnrolmentVeiw.php">Enrolmen View</a></li>
               <li id="StatusForm"><a href="StatusForm.php">StatusForm</a></li>
        </ul>
    </div>
    <img src="image1/p.jpg" style="width:100%; height:60vh;" alt="Banner">
    <!-- ✅ Correct JS + PHP value passing -->
    <script>
        let userName = "<?php echo $roll; ?>";
        let stud = document.getElementById("stud");
        let stat = document.getElementById("stat");
        let  caseView = document.getElementById("case");
        let Registoruser= document.getElementById("Registoruser");
         let Enrolmen= document.getElementById("Enrolmen");
          let StatusForm= document.getElementById("StatusForm");
    
        /* ✅ Default hide */
        stud.style.display = "none";
        stat.style.display = "none";
        caseView.style.display = "none";
        Registoruser.style.display = "none";
       Enrolmen.style.display = "none";
       StatusForm.style.display = "none";
        /* ✅ Role Logic */
        if(userName === "admin"){
            stud.style.display = "block";
            stat.style.display = "block";
            caseView.style.display = "block";  
             Registoruser.style.display = "block";
             Enrolmen.style.display = "block"; 
             StatusForm.style.display ="block";
        }
        else if(userName !== "") {
            stat.style.display = "block";
            caseView.style.display = "block";
            Enrolmen.style.display = "block"; 
        }
    </script>
</body>
</html>