<?php
session_start();

// ============================
// INICIAR SESIÓN COMO INVITADO
// ============================
if (!isset($_SESSION['correo']) && !isset($_SESSION['invitado'])) {
    $_SESSION['invitado'] = true;
}

// ============================
// CERRAR SESIÓN
// ============================
if (isset($_GET['cerrar']) && $_GET['cerrar'] === 'true') {
    session_unset();
    session_destroy();
    header("Location: Login/Login.html");
    exit;
}

// REDIRIGIR AUTOMÁTICAMENTE AL INICIO
header("Location: inicio.php");
exit;
?>
