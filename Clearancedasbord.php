
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
    <title>Clearance Dashboard</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            background: #f0f4f8;
            font-family: 'Segoe UI', sans-serif;
        }
        .container{
            max-width: 900px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .welcome{
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #0044cc;
            margin-bottom: 25px;
        }
        .menu{
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }
        .menu a{
            flex: 1;
            background: #0066ff;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 10px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0,102,255,0.2);
        }
        .menu a:hover{
            background: #004ec2;
            transform: translateY(-3px);
        }
        .info{
            background: #eaf2ff;
            padding: 20px;
            border-radius: 12px;
            font-size: 16px;
            line-height: 1.6;
            color: #003788;
        }

        .info p{
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="welcome">Welcome Student 🎓</div>

    <div class="menu">
        <a href="ClearanceViwe.php">View Clearance</a>
        <a href="case.php">Check Problems</a>
        <a href="GettingPage.html" style="background:#ff3b3b;">Logout</a>
    </div>
    <div class="info">
        <p>✔ <strong>View Clearance</strong> — check your submitted clearance form details.</p>
        <p>✔ <strong>Check Problems</strong> — see if there are any issues or pending cases.</p>
        <p>✔ <strong>Logout</strong> — safely exit your account.</p>
    </div>
</div>
</body>
</html>
