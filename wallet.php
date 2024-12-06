
<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: index.php");
};

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];
    require "db_conn.php";
    $login =  $_SESSION["login"];
    $query = "UPDATE users SET money = money + $amount WHERE username = '$login'";
    $result = mysqli_query($conn, $query);
    $_SESSION["money"] = $_SESSION["money"] + $amount;
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
        <span id="site-title">
            <div class="pusher-32px"></div>
            <i class="fa-solid fa-cannabis site-icon"></i>
            <span class="spacing"></span>
            <h1>B<span class="small-title">REEZE</span></h1>
        </span>

        <div id="options">
            <a href="index.php">HOME</a>
            <a href="leaderboard.php">RANK</a>
            <?php if (isset($_SESSION["login"])) {echo '<a href="wallet.php">WALLET</a>';}; ?>
        </div>

        <div id="profile-container" <?php
        if (!isset($_SESSION["login"])) {
            echo "style='visibility: hidden;'";
            };
        ?>>
            <img src="https://static-00.iconduck.com/assets.00/profile-circle-icon-1023x1024-ucnnjrj1.png">
            <span>
                <b id="username-display">@<?=$_SESSION["login"];?></b>
                <b id="cash-display"><?=$_SESSION["money"];?> C$</b>
            </span>
            <i id="options-button" class="fa-solid fa-bars"></i>
        </div>
    </nav>
    <div id="secondary-profile-container"<?php
        if (!isset($_SESSION["login"])) {
            echo "style='visibility: hidden;'";
            };
        ?>>
        <b id="secondary-username-display">@<?=$_SESSION["login"];?></b>
        <b id="secondary-cash-display"><?=$_SESSION["money"];?> C$</b>
    </div>

    <div id="giant-grid">
        <main>
            <section class="margin-top section2">
                <h2 class="dela-gothic-one-regular"><i class="fa-solid fa-wallet decal-color"></i>  DEPOSITAR</h2>
                <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                    <form method="POST" class="flex-legal">
                        <input type="number" value=5 min=5 max=1000 name="amount" class="btn-primary">
                        <a>Informações bancarias automaticamente preenchidas.</a>
                        <input class="btn-primary" type="submit" value="DEPOSIT">
                    </form>
                </div>
            </section>
            <section class="margin-top section2">
                <h2 class="dela-gothic-one-regular"><i class="fa-solid fa-sack-dollar decal-color"></i>  SACAR</h2>
                <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                    <form class="flex-legal">
                        <input type="number" disabled placeholder=" ̶2̶5̶" min=5 max=1000 name="amount" class="btn-primary">
                        <a>Serviço temporariamente indisponivel.</a>
                        <input class="btn-primary" disabled type="submit" value="SACAR">
                    </form>
                </div>
            </section>
        </main>
</body>
</html>