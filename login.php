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
                <h2 class="dela-gothic-one-regular"><i class="fa-solid fa-fire decal-color"></i>  ENTRAR AGORA</h2>
                <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                <form class="dm-sans flex-legal" action="index.php" method="POST">
                    <div class="margin-top" style="margin-top: 2px;"></div>
                    <?php if ($_GET["fail"] == "true") {
                        echo '<a style="color: red"> Wrong username or password.</a>';
                    };?>
                    <label class="bebas-neue" for="username">Username</label> <input name="username" type="text">
                    <label class="bebas-neue" for="username">Password</label> <input name="password" type="password">
                    <input type="submit" value="LOGIN" class="btn-primary">
                </form>
            </div>
            </section>
            
        </main>
    </div>
</body>
</html>