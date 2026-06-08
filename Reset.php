<?php
include("database.php");
session_start();
$nameerr = $success = "";
function test_input($data){
    return htmlspecialchars(stripslashes(trim($data)));
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $id= test_input($_POST["ID"] ?? "");
    $name     = test_input($_POST["name"] ?? "");
    $pass     = $_POST["pass"] ?? "";
    /* ========= EMPTY CHECK ========= */
    if (empty($id) ||  empty($name) || empty($pass) ) {
        $nameerr = "❌ Please fill all required fields";
    }

    /* ========= VALIDATION ========= */
    elseif (!preg_match("/^[A-Za-z0-9\s]+$/",  $id) 
        ||!preg_match("/^[A-Za-z\s]+$/", $name) ||
     strlen(   $pass ) < 6) {
        $nameerr = "❌ Invalid input (Password must be at least 6 characters)";
    }
    /* ========= CHECK USER ========= */
    else {
        $sql1 = "SELECT password FROM mekdela_amba_info WHERE Full_name = ? and user_id=?";
        $stmt = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt, "ss", $name,  $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if ($result) {
                $hashedPass = password_hash( $pass , PASSWORD_DEFAULT);
                $sql2 = "UPDATE mekdela_amba_info SET password = ? WHERE Full_name = ? and user_id=? ";
                $stmt2 = mysqli_prepare($conn, $sql2);
                mysqli_stmt_bind_param($stmt2, "sss", $hashedPass, $name, $id );
                if (mysqli_stmt_execute($stmt2)) {
                    $success = "✅ Password successfully  Reset";
                } else {
                    $nameerr = "❌ Failed to Reset password";
                }
            } else {
                $nameerr = "❌ Old password is incorrect";
            }
        } else {
            $nameerr = "❌ User not found";
        }
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Registration</title>

<style>
body{
    background: linear-gradient(135deg, #74ebd5, #acb6e5);
    font-family: Arial, Helvetica, sans-serif;
}
.container{
    max-width: 400px;
    margin: 60px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
.container h2{
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}
input[type="text"],
input[type="email"],
input[type="password"]{
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}
.gender{
    margin: 10px 0;
}
.gender label{
    margin-right: 15px;
}
input[type="submit"]{
    width: 100%;
    background: #4CAF50;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-top: 10px;
}
input[type="submit"]:hover{
    background: #45a049;
}
.error{
    color: red;
    text-align: center;
    margin-bottom: 10px;
}
.success{
    color: green;
    text-align: center;
    margin-bottom: 10px;
}
.success1{
    color: blue;
}
</style>
</head>
<body>
<div class="container">
<h2>Password Reset</h2>
<?php if (!empty($success)) echo "<p class='success1'>$success</p>";?>
<?php if (!empty($nameerr)) echo "<p class='error'>$nameerr</p>";?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
       <input type="text" name="ID" placeholder="User ID">
       <input type="text" name="name" placeholder="Full Name">
      <input type="password" name="pass" placeholder="Password (min 6 chars)">
      <input type="submit" value="Reset">
</form>
</div>
</body>
</html>
