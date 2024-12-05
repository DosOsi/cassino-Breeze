<?php
$servername = "localhost";
$username = "addans_family";
$password = "AAAA";
$dbname = "BANCOLEGAL";
// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);
// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>