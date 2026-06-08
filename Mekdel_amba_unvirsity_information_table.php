<?php
session_start();
include("database.php");
$nameerr = "";
define("AES_KEY", "1234567890123456"); // 16 bytes
define("AES_IV", "1234567890123456");
function aes_encrypt($data) {
    return openssl_encrypt($data, "AES-128-CBC", AES_KEY, 0, AES_IV);
}
function test_input($data){
    return htmlspecialchars(stripslashes(trim($data)));
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID    = test_input($_POST["ID"] ?? "");
    $name  = test_input($_POST["name"] ?? "");
    $age   = test_input($_POST["age"] ?? "");
    $email = test_input($_POST["email"] ?? "");
    $pass  = test_input($_POST["pass"] ?? "");
    $phone = test_input($_POST["phone"] ?? "");
    $sex   = test_input($_POST["sex"] ?? "");
    $role  = test_input($_POST["roll"] ?? "");
    /* EMPTY CHECK */
    if (
        empty($ID) || empty($name) || empty($age) ||
        empty($email) || empty($pass) ||
        empty($phone) || empty($sex) || empty($role)
    ) {
        $nameerr = "❌ Please fill all required fields";
    }
    /* VALIDATION */
    elseif (
        !preg_match("/^[A-Za-z0-9@]+$/", $ID) ||
        !preg_match("/^[A-Za-z\s]+$/", $name) ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !is_numeric($age) ||
        strlen($pass) < 6 ||
        !preg_match("/^[0-9]+$/", $phone) ||
        !preg_match("/^[A-Za-z\s]+$/", $role)
    ) {
        $nameerr = "❌ Invalid input (Password min 6 characters)";
    }
    /* INSERT */
    else {
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
         $email = aes_encrypt($email);
                $phone = aes_encrypt($phone);
               
        $sql = "INSERT INTO mekdela_amba_info
        (`user_id`, `Full_name`, `age`, `email`, `password`, `phone`, `user_role`, `sex`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = mysqli_prepare($conn, $sql);
            if (!$stmt) {
                throw new Exception("Prepare failed");
            }
            mysqli_stmt_bind_param(
                $stmt,
                "ssisssss",
                $ID,
                $name,
                $age,
                $email,
                $hashedPass,
                $phone,
                $role,
                $sex
            );
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Execute failed");
            }
            echo "<p class='success'>✅ Data inserted successfully</p>";
        } catch (Exception $e) {
            $nameerr = "❌ Database error";
        } finally {
            mysqli_stmt_close($stmt);
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
/* Select box styling */
#a {
    width: 220px;
    padding: 10px 12px;
    font-size: 15px;
    border: 2px solid #ccc;
    border-radius: 6px;
    background-color: #fff;
    color: #333;
    cursor: pointer;
    outline: none;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

/* Hover effect */
#a:hover {
    border-color: #007bff;
}

/* Focus effect */
#a:focus {
    border-color: #007bff;
    box-shadow: 0 0 6px rgba(0, 123, 255, 0.4);
}

/* Option styling */
#a option {
    padding: 10px;
    font-size: 14px;
}

/* Placeholder option style */
#a option[value=""] {
    color: #888;
}
</style>
</head>
<body>
<div class="container">
<h2>User Registration</h2>
<?php if (!empty($nameerr)) echo "<p class='error'>$nameerr</p>";?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="text" name="ID" placeholder="User ID">
    <input type="text" name="name" placeholder="Full Name">
    <input type="text" name="age" placeholder="Age">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="pass" placeholder="Password (min 6 chars)">
    <input type="text" name="phone" placeholder="Phone Number">
    <select name="roll" id="a">
       <option value="" class="a">User roll</option>
       <option value="admin" class="a">admin</option>
        <option value="subadmin" class="a">subadmin</option>
        <option value="student" class="a">student</option>
        <option value="computer science" class="a">computer science</option>
        <option value="software engnering" class="a">oftware engnering</option>
    </select>
    <div class="gender">
        <strong>Gender:</strong><br>
        <label><input type="radio" name="sex" value="male"> Male</label>
        <label><input type="radio" name="sex" value="female"> Female</label>
    </div>
    <input type="submit" value="Register">
</form>
</div>
</body>
</html>
