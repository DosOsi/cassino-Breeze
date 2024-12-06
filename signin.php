
<?php

session_start();
include "db_conn.php";

$_SESSION["login"] = null;
$_SESSION["passkey"] = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        header("Location: signin.php?fail=taken_username");        
    } elseif ($password != $confirm_password) {
        header("Location: signin.php?fail=password_mismatch");        
    } else {
        $query = "INSERT INTO users(username,password,money,privilege,money_gained) VALUES ('$username','$password',0.00,0,0)";
        $result = mysqli_query($conn, $query);
        header("Location: login.php");        
    };
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="css/style.css" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Mono+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz@9..40&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/3602e07857.js" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</head>
<body class="flex-body">
    <nav>
        <span id="site-title" style="justify-content: center;">
            <i class="fa-solid fa-cannabis site-icon"></i>
            <span class="spacing"></span>
            <h1>B<span class="small-title">REEZE</span></h1>
        </span>
    </nav>

    <div id="giant-grid">
        <main>
            <section class="margin-top section1">
                <h2 class="dela-gothic-one-regular"><i class="fa-solid fa-fire decal-color"></i>  REGISTRAR AGORA</h2>
                <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                <form class="dm-sans flex-legal" method="POST">
                    <div class="margin-top" style="margin-top: 2px;"></div>
                    <?php if ($_GET["fail"] == "taken_username") {
                        echo '<a style="color: red"> Username alredy in use.</a>';
                    };?>
                    <?php if ($_GET["fail"] == "password_mismatch") {
                        echo '<a style="color: red"> Passwords dont match.</a>';
                    };?>

                    <label class="bebas-neue" for="username">Username</label> <input name="username" type="text">
                    <label class="bebas-neue" for="username">Password</label> <input name="password" type="password">
                    <label class="bebas-neue" for="username">Confirm Password</label> <input name="confirm_password" type="password">
                    <input type="submit" value="SIGN IN" class="btn-primary">
                </form>
            </div>
            </section>
            
        </main>
    </div>
</body>
</html>