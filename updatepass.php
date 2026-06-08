<?php
include("database.php");
session_start();
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}
$nameerr = $success = "";
function test_input($data){
    return htmlspecialchars(stripslashes(trim($data)));
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = test_input($_POST["name"] ?? "");
    $pass     = $_POST["pass"] ?? "";
    $newpass  = $_POST["newpass"] ?? "";
    $conpass  = $_POST["conpass"] ?? "";

    /* ========= EMPTY CHECK ========= */
    if (empty($name) || empty($pass) || empty($newpass) || empty($conpass)) {
        $nameerr = "❌ Please fill all required fields";
    }

    /* ========= VALIDATION ========= */
    elseif (!preg_match("/^[A-Za-z\s]+$/", $name) || strlen($newpass) < 6) {
        $nameerr = "❌ Invalid input (Password must be at least 6 characters)";
    }
    elseif ($newpass !== $conpass) {
        $nameerr = "❌ New password and confirm password do not match";
    }
    /* ========= CHECK USER ========= */
    else {
        $sql1 = "SELECT password FROM mekdela_amba_info WHERE Full_name = ?";
        $stmt = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($pass, $row['password'])) {
                $hashedPass = password_hash($newpass, PASSWORD_DEFAULT);
                $sql2 = "UPDATE mekdela_amba_info SET password = ? WHERE Full_name = ?";
                $stmt2 = mysqli_prepare($conn, $sql2);
                mysqli_stmt_bind_param($stmt2, "ss", $hashedPass, $name);
                if (mysqli_stmt_execute($stmt2)) {
                    $success = "✅ Password successfully updated";
                } else {
                    $nameerr = "❌ Failed to update password";
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
</style>
</head>
<body>
<div class="container">
<h2>Update Password</h2>
<?php if (!empty($nameerr)) echo "<p class='error'>$nameerr</p>";?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="text" name="name" placeholder="Full Name">
    <input type="password" name="pass" placeholder="Password (min 6 chars)">
    <input type="password" name="newpass" placeholder="new Password (min 6 chars)">
    <input type="password" name="conpass" placeholder="confirm Password (min 6 chars)">
    <input type="submit" value="Update">
</form>
</div>
</body>
</html>
