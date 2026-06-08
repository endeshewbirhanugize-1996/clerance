<?php
/* Destroy session when logout button is clicked */
if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_unset();
    session_destroy();

    /*  Redirect to getting page */
    header("Location: GettingPage.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            background-color: blueviolet;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* LOGOUT BUTTON */
        .logout-btn{
            position: fixed;
            top: 15px;
            right: 20px;
            text-decoration: none;
            color: red;
            font-size: 1.8em;
            background-color: white;
            border-radius: 50px;
            padding: 10px 22px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .logout-btn:hover{
            background-color: #ffe6e6;
        }
    </style>
</head>
<body>

<!-- 🔘 Logout Button -->
<a href="?logout=true" class="logout-btn">Logout</a>

</body>
</html>

