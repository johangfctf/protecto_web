<?php
// ------- CONEXIÓN A LA BD --------
$host = "localhost";
$user = "root";
$pass = "";
$bd   = "farmacia_web";

$conn = new mysqli($host, $user, $pass, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
