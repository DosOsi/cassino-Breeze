<?php

ini_set("display_errors",1);

$slot_chances = array(
    3, //tigre
    8, //bell
    10, //beer
    10, //cat
    20, //honey
    70, //sheep
    2, //snowman
);
$slot_values = array(
    30.0, //tigre
    7.5, //bell
    4.5, //beer
    3.0, //cat
    1.0, //honey
    0.55, //sheep
    1.0, //snowman
);

function get_result() {
    global $slot_chances, $slot_values;
    $resultMatrix = array(
        array(),array(),array()
    );
    for ($x = 0; $x < 3; $x++) {
        for ($y = 0; $y < 3; $y++) {
            $rollValue = floor(mt_rand(0,array_sum($slot_chances)));
            $currentValue = 0;
            foreach ($slot_chances as $i => $value) {
                $currentValue += $value;
                if ($rollValue <= $currentValue) {
                    array_push($resultMatrix[$x],$i);
                    break;
                };
            };
        };
    };
    return [$resultMatrix, validate_result($resultMatrix), get_money_result($resultMatrix,validate_result($resultMatrix))];
};

function validate_result($resultMatrix) {
    global $slot_chances, $slot_values;
    $validateMatrix = array(
        array(0,0,0),array(0,0,0),array(0,0,0)
    );
    $possibleCombinations = array(
        array(
            array(0, 0),
            array(1, 0),
            array(2, 0)
        ),
        array(
            array(0, 1),
            array(1, 1),
            array(2, 1)
        ),
        array(
            array(0, 2),
            array(1, 2),
            array(2, 2)
        ),
        array(
            array(0, 0),
            array(0, 1),
            array(0, 2)
        ),
        array(
            array(1, 0),
            array(1, 1),
            array(1, 2)
        ),
        array(
            array(2, 0),
            array(2, 1),
            array(2, 2)
        )
    );    
    foreach ($possibleCombinations as $idx => $combination) {
        $slot_value = null;
        $is_unique = true;
        foreach ($combination as $pos => $value) {
            if ($slot_value === null) {
                $slot_value = $resultMatrix[$combination[$pos][0]][$combination[$pos][1]];
            } else {
                if ($slot_value != $resultMatrix[$combination[$pos][0]][$combination[$pos][1]]) {
                    $is_unique = false;
                    break;
                };
            };
        };
        if ($is_unique) {
            foreach ($combination as $pos => $value) {
                $validateMatrix[$combination[$pos][0]][$combination[$pos][1]] += 1;
            };
        };
    };

    return $validateMatrix;
};

function get_money_result($resultMatrix, $validateMatrix) {
    global $slot_chances, $slot_values;
    $mult = 0;
    $total_money = 0.0;
    foreach ($validateMatrix as $container_idx => $container_val) {
        $mult += array_sum($validateMatrix[$container_idx]);
        foreach ($validateMatrix[$container_idx] as $slot_idx => $slot_value) {
            if ($validateMatrix[$container_idx][$slot_idx] >= 1) {
                $total_money += ($slot_values[$resultMatrix[$container_idx][$slot_idx]] * $validateMatrix[$container_idx][$slot_idx])/3;
            };
        };
    };
    return round($total_money * $mult * 100)/100;
};

require "../db_conn.php";
session_start();
if (isset($_SESSION["login"])) {
    $username = $_SESSION['login'];
    $password = $_SESSION["passkey"];

    $query = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = $result->fetch_assoc();
        $money = $row['money'];
        $roll_price = 1.00;
        if ($money >= $roll_price) {
            $roll_result = get_result();
            
            $amount = $roll_result[2] - $roll_price;
            $query = "UPDATE users SET money = money + $amount WHERE username = '$username'";
            $query_result = mysqli_query($conn, $query);
            
            $_SESSION["money"] = $_SESSION["money"] + $amount;
            
            $query = "UPDATE users SET money_gained = money_gained + $roll_result[2] WHERE username = '$username'";
            $query_result = mysqli_query($conn, $query);

            $roll_result_slots = "[[" . implode(",",$roll_result[0][0]) . "],[" . implode(",",$roll_result[0][1]) .  "],[" . implode(",",$roll_result[0][2]) . "]]";
            $roll_result_validate_matrix = "[[" . implode(",",$roll_result[1][0]) . "],[" . implode(",",$roll_result[1][1]) .  "],[" . implode(",",$roll_result[1][2]) . "]]";
            $roll_result_money_amount = $roll_result[2];

            echo "<script>window.parent.roll([" . $roll_result_slots . "," . $roll_result_validate_matrix . "," . $roll_result_money_amount . "])</script>";
        } else {
            echo "<script>alert('Funds not sufficient')</script>";
        };
    } else {
        echo "<script>alert('No Authentication')</script>";
    };
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>