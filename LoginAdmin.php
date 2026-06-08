<?php
session_start();

/* 🔒 BLOCK anyone not logged in */
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}?>
<?php
include("database.php");
session_start();
if (isset($_POST["sub"])) {
    $name = $_POST["name"];
    $pass = $_POST["pass"];
    $sql = "SELECT * FROM status_table 
            WHERE Stut_Full_name='$name' 
            AND password='$pass'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        // ✅ Store session data
        $_SESSION["ID"]    = $row["stat_id"];
        $_SESSION["name"]  = $row["Stut_Full_name"];
        $_SESSION["pass1"] = $row["password"];

        header("Location: homeOfStudent.php");
        exit;

    } else {
        echo "<script>alert('❌ Wrong name or password');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MAU Status Form</title>
<style>
/* BODY STYLING */
body {
    height: 100vh; /* full viewport height */
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f0f4f8;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 20px;
}

/* CARD STYLING */
.card {
    background: #ffffff;
    padding: 40px 35px;
    border-radius: 20px;
    box-shadow: 0 15px 25px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 450px;
}

/* TITLE */
h1 {
    text-align: center;
    color: #002f6c;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 30px;
}

/* FORM */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* INPUTS */
input {
    padding: 12px 15px;
    font-size: 16px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    transition: 0.3s;
}

input:focus {
    outline: none;
    border-color: #006dcc;
    box-shadow: 0 0 8px rgba(0,109,204,0.3);
}

/* SUBMIT BUTTON */
button {
    margin-top: 10px;
    padding: 14px;
    font-size: 18px;
    font-weight: 600;
    color: white;
    background: #006dcc;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #004c99;
}

/* RESPONSIVE */
@media(max-width: 400px){
    .card {
        padding: 30px 20px;
    }
    h1 {
        font-size: 24px;
    }
    input {
        font-size: 15px;
    }
    button {
        font-size: 16px;
    }
}
</style>
</head>
<body>
<div class="card">
  <h1>MAU LOGIN</h1>
  <form action="" method="post">
    <input   name="name"  type="text" placeholder="Admin_name" required>
    <input    name="pass" type="password" placeholder="Admin_password" required>
    <button    name="sub" type="submit"  value="LOGIN">Submit</button>
  </form>
</div>
</body>
</html>