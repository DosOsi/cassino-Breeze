<?php
session_start();
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
            <a href="games.php">GAMES</a>
            <a href="wallet.php">WALLET</a>
        </div>

        <div id="profile-container">
            <img src="https://static-00.iconduck.com/assets.00/profile-circle-icon-1023x1024-ucnnjrj1.png">
            <span>
                <b id="username-display">@<?=$_SESSION["login"];?></b>
                <b id="cash-display"><?=$_SESSION["money"];?> C$</b>
            </span>
            <i id="options-button" class="fa-solid fa-bars"></i>
        </div>
    </nav>
    <div id="secondary-profile-container">
        <b id="secondary-username-display">@<?=$_SESSION["login"];?></b>
        <b id="secondary-cash-display"><?=$_SESSION["money"];?> C$</b>
    </div>

    <div id="giant-grid">
        <main>
            <iframe id="game-iframe" src="games/tigerGame.html" width="350" height="750"></iframe>
        </main>
        <aside class="left">
            <div class="left ad-popup dm-sans">
                <section>
                    <h3 class="dela-gothic-one-regular"><i class="fa-solid fa-dice decal-color"></i>  Rodadas Grátis</h3>
                    <p>Receba <b class="underline">50 rodadas grátis</b> em nossos slots mais populares. A sorte pode estar ao seu lado!</p>
                </section>
                <a href="#signup" class="btn-secondary">Aproveite Agora!</a>
            </div>
            <div class="left ad-popup dm-sans">
                <section>
                    <h3 class="dela-gothic-one-regular"><i class="fa-solid fa-hand-holding-dollar decal-color"></i>  Bônus de<br>Boas-Vindas</h3>
                    <p>Ganhe até <b class="underline">100% de bônus</b> no seu primeiro depósito e comece sua jornada com o pé direito!</p>            
                </section>
                <a href="#signup" class="btn-secondary">Aproveite Agora!</a>
            </div>
        </aside>
        <aside class="right">
            <span>
                AD AREA
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