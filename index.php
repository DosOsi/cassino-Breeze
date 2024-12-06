
<?php
session_start();
include "db_conn.php";

if (!isset($_SESSION["login"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $query = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $userfound) {
                $_SESSION["login"] = $userfound["username"];
                $_SESSION["passkey"] = $userfound["password"];
                $_SESSION["money"] = $userfound["money"];
                $_SESSION["privilege"] = $userfound["privilege"];
            }
        } else {
            header("Location: login.php?fail=true");
        };
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
            <?php
                echo '<section class="dela-gothic-one-regular welcome-section';
                if (isset($_SESSION["login"])) {
                    echo ' minimized';
                };
                echo'">
                    <h2 style="font-size:2vw;" >BEM VINDO AO BREEZE!</h2>';
                if (!isset($_SESSION["login"])) {
                    echo '<p style="font-size: 1.3vw; margin-bottom: 0px;">BONUS DE ATÉ <b>1000%</b> NO PRIMEIRO DEPÓSITO.</p>
                    <br>
                    <a href="signin.php">CADASTRE-SE</a>';
                };
                echo '<div style="width: fit-content;">
                        <img class="money-pile one" src="https://static.vecteezy.com/system/resources/thumbnails/016/548/914/small_2x/big-pile-of-australian-dollar-notes-a-lot-of-money-over-transparent-background-3d-rendering-of-bundles-of-cash-png.png">
                        <img class="money-pile two" src="https://static.vecteezy.com/system/resources/thumbnails/016/548/914/small_2x/big-pile-of-australian-dollar-notes-a-lot-of-money-over-transparent-background-3d-rendering-of-bundles-of-cash-png.png">
                    </div>
                </section>';
            ?>
            <?php
                if (!isset($_SESSION["login"])) {
                    echo '<section class="margin-top section2">
                        <h2 class="dela-gothic-one-regular"><i class="fa-solid fa-fire decal-color"></i>  ENTRAR AGORA</h2>
                        <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                            <a class="btn-primary" href="login.php">LOGIN</a>
                            <a class="btn-primary" href="login.php">SIGN IN</a>
                        </div>
                    </section>';
                };
            ?>
            <section class="section1 margin-top">
                <b id="fake-info" class="dela-gothic-one-regular">HOJE
                    <span id="jackpot-count-container">
                        <span id="jackpot-count">
                        7426
                        </span>
                        <span id="jackpot-count-copy">
                            0000
                        </span>
                    </span>
                PESSOAS FIZERAM UM  <span class="jackpot">JACKPOT</span>!</b>
            </section>
            
            <section class="margin-top" >
                <h2 class="dela-gothic-one-regular"><i class="fa-solid fa-fire decal-color"></i>  NOSSOS JOGOS</h2>
                <div id="game-list">
                    <div class="game-container tigrinho" onclick="window.location.href = 'gamePage.php?game=tigerGame'";>
                        <span>"TIGRINHO"</span>
                    </div>
                    <div class="game-container tigrinho" onclick="window.location.href = 'gamePage.php?game=tigerGame'";>
                        <span>"TIGRINHO"</span>
                    </div>
                    <div class="game-container tigrinho" onclick="window.location.href = 'gamePage.php?game=tigerGame'";>
                        <span>"TIGRINHO"</span>
                    </div>
                </div>

            </section>
        </main>
        <aside class="left">
            <div class="left ad-popup dm-sans">
                <section>
                    <h3 class="dela-gothic-one-regular"><i class="fa-solid fa-dice decal-color"></i>  Rodadas Grátis</h3>
                    <p>Receba <b class="underline">50 rodadas grátis</b> em nossos slots mais populares. A sorte pode estar ao seu lado!</p>
                </section>
                <a href="signin.php" class="btn-secondary">Aproveite Agora!</a>
            </div>
            <div class="left ad-popup dm-sans">
                <section>
                    <h3 class="dela-gothic-one-regular"><i class="fa-solid fa-hand-holding-dollar decal-color"></i>  Bônus de<br>Boas-Vindas</h3>
                    <p>Ganhe até <b class="underline">100% de bônus</b> no seu primeiro depósito e comece sua jornada com o pé direito!</p>            
                </section>
                <a href="signin.php" class="btn-secondary">Aproveite Agora!</a>
            </div>
        </aside>
        <aside class="right">
            <span>
                
            </span>
        </aside>    
    </div>

    <footer>
        <div class="left">
            <span id="site-title">
                <div class="pusher-32px"></div>
                <i class="fa-solid fa-cannabis site-icon"></i>
                <span class="spacing"></span>
                <h1>B<span class="small-title">REEZE</span></h1>
            </span>    
            There is no time for a full footer.
        </div>
        <div class="right">
            
        </div>
    </footer>

</body>
</html>