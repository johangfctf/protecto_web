<?php
session_start();
if(isset($_GET['index']) && isset($_SESSION['carrito'][$_GET['index']])){
    unset($_SESSION['carrito'][$_GET['index']]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']); // reindexar
}
header("Location: mostrar_carrito.php");
exit;
?>
