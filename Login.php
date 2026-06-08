<?php
session_start();
include("database.php");
$error = "";
    $_SESSION["logined"] =false;
function test_input($data){
    return htmlspecialchars(stripslashes(trim($data)));
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = test_input($_POST["name"] ?? "");
    $password = $_POST["pass"] ?? "";

    /* EMPTY CHECK */
    if (empty($fullname) || empty($password)) {
        $error = "❌ Please fill all fields";
    }
    /* PASSWORD CHECK */
    elseif (strlen($password) < 6) {
        $error = "❌ Password must be at least 6 characters";
    }
    else {
        /* SELECT USING FULL NAME */
        $sql = "SELECT user_id, Full_name, password, user_role
                FROM mekdela_amba_info
                WHERE Full_name = ?";
        try {
            $stmt = mysqli_prepare($conn, $sql);
            if (!$stmt) {
                throw new Exception("Prepare failed");
            }
            mysqli_stmt_bind_param($stmt, "s", $fullname);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {

                if (password_verify($password, $row["password"])) {

                    $_SESSION["User_id"]   = $row["user_id"];
                    $_SESSION["name"]      = $row["Full_name"];
                    $_SESSION["User_role"] = $row["user_role"];
                    $_SESSION["pass1"]      =$row["password"];
                    $_SESSION["logined"]   = true;

                    /* ROLE REDIRECT */
                    if ($row["user_role"] === "student") {
                        header("Location: MAU_Clearance_form.php");
                    } elseif (
                        $row["user_role"] === "admin" ||
                        $row["user_role"] === "subadmin"
                    ) {
                        header("Location: homeOfStudent.php");
                    } else {
                        $error = "❌ Unknown user role";
                    }
                    exit;

                } else {
                    $error = "❌ Incorrect password";
                }

            } else {
                $error = "❌ Full name not found";
            }

        } catch (Exception $e) {
            $error = "❌ Database error";
        } finally {
            if (isset($stmt)) {
                mysqli_stmt_close($stmt);
            }
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
<title>MAU Status Form</title>
<style>
/* BODY STYLING */
body {
    height: 100vh; /* full viewport height */
    display: flex;
    justify-content: center;
    align-items: center;
    background: #057df4ff;
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
p{
    font-size: 1em;
    text-transform:   capitalize;
    font-weight: bold;
    font-family: 'Segoe UI';
    color: blue;
}
a{
    text-decoration: none;
}
</style>
</head>
<body>
<div class="card">
  <h1>MAU LOGIN</h1>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])  ?>" method="post">
    <span class="erro"><?php echo   $error   ?></span>
    <input  name="name"  type="text" placeholder="User_name" required>
    <input  name="pass" type="password" placeholder="User_password" required>
    <p>if you want update password <a href="updatepass.php" style="color:   aqua">Upadet</a></p>
      <p>if you forgotten password <a href="Reset.php" style="color:   red; ">Reset</a></p>
    <button name="submit" type="submit"  value="LOGIN">Submit</button>
  </form>
</div>
</body>
</html>