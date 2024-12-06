
<?php
session_start();
require "db_conn.php";
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
                <h2 class="dela-gothic-one-regular"><i class="fa-solid fa-medal decal-color"></i>  LEADERBOARD</h2>
                <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                </div>
            </section>
            <section class="margin-top section2">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 10%">Place</td>
                        <td>Username</td>
                        <td>Money Gained</td>
                    </tr>
                    <?php
                        $query = "SELECT * FROM users ORDER BY money_gained DESC LIMIT 100";
                        $result = mysqli_query($conn,$query);
                        $count = 0;
                        foreach ($result as $user)
                        {
                            ?>
                            <tr>
                                <td><?php
                                $count += 1;
                                if ($count > 3) {
                                    echo $count;
                                } else {
                                    if ($count == 1) {
                                        echo "<i class='fa-solid fa-medal golden-color'></i>";
                                    } elseif ($count == 2) {
                                        echo "<i class='fa-solid fa-medal silver-color'></i>";
                                    } elseif ($count == 3) {
                                        echo "<i class='fa-solid fa-medal bronze-color'></i>";
                                    };
                                };
                                ?>
                                </td>
                                <td><?=$user["username"]?></td>
                                <td><?=$user["money_gained"]?></td>
                            </tr>
                            <?php
                        };
                    ?>
                </table>
            </section>

        </main>
</body>
</html>