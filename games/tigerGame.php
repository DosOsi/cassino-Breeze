<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="tigerStyle.css" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Mono+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz@9..40&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/3602e07857.js" crossorigin="anonymous"></script>
    <script src="../js/tiger.js"></script>
</head>

<body>
    <div style="display: none;">
        <img id="img-slot-tigre" src="./tigre/slot_tigre.png">
        <img id="img-slot-bell" src="./tigre/slot_bell.png">
        <img id="img-slot-beer" src="./tigre/slot_beer.png">
        <img id="img-slot-cat" src="./tigre/slot_cat.png">
        <img id="img-slot-honey" src="./tigre/slot_honey.png">
        <img id="img-slot-sheep" src="./tigre/slot_sheep.png">
        <img id="img-slot-snowman" src="./tigre/slot_snowman.png">

        <img id="img-roll-button" src="./tigre/roll.png">
        <img id="img-cassino-machine" src="./tigre/machine.png">
        <img id="img-explosion-effect" src="./tigre/explosion.png">
    
        <iframe id="request-roll-iframe"></iframe>
    </div>
    <div id="main-container">
        <canvas id="main-canvas" width="450px" height="750px"></canvas>
    </div>
</body>
