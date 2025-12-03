<?php
session_start();
include '../productos/conexion.php'; // Conexión a tu base de datos

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Entrar como usuario registrado
    if (isset($_POST['accion']) && $_POST['accion'] === 'login') {
        $correo = $_POST['correo'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';

        if ($correo === '' || $contrasena === '') {
            $error = "Por favor completa todos los campos.";
        } else {
            $stmt = $conn->prepare("SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, contrasena_usuario FROM usuarios WHERE correo_usuario = ?");
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows === 1) {
                $row = $res->fetch_assoc();
                // Comparar texto plano (si tu DB no tiene hash)
                if ($contrasena === $row['contrasena_usuario']) {
                    $_SESSION['id_usuario'] = $row['id_usuario'];
                    $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
                    $_SESSION['apellido_usuario'] = $row['apellido_usuario'];
                    $_SESSION['correo'] = $row['correo_usuario'];
                    header("Location: ../inicio.php");
                    exit();
                } else {
                    $error = "Contraseña incorrecta.";
                }
            } else {
                $error = "Correo no registrado.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Farmacia</title>
    <style>
        body {margin:0; font-family:Arial, sans-serif; background:#f2f2f2;}
        .contenedor {display:flex; height:100vh;}
        .lado-izquierdo {flex:1; background:linear-gradient(135deg,#00c6ff,#0072ff); display:flex; justify-content:center; align-items:center; color:white; font-size:35px; font-weight:bold;}
        .lado-derecho {flex:1; background:white; display:flex; justify-content:center; align-items:center;}
        .formulario {width:80%; max-width:350px;}
        .formulario h2 {text-align:center; margin-bottom:25px;}
        .formulario input {width:100%; padding:12px; margin:8px 0; border:1px solid #ccc; border-radius:6px; font-size:15px;}
        .formulario button {width:100%; padding:12px; background:#0072ff; color:white; font-size:16px; border:none; border-radius:6px; cursor:pointer; margin-top:10px;}
        .formulario button:hover {background:#005edd;}
        .extra {text-align:center; margin-top:10px; font-size:14px;}
        .extra a {color:#0072ff; text-decoration:none;}
        .invitado {margin-top:15px; text-align:center;}
        .invitado a button {background:#ddd; color:#333; border:1px solid #aaa; padding:10px; border-radius:6px; cursor:pointer;}
        .invitado a button:hover {background:#ccc;}
        .error {color:red; text-align:center; margin-bottom:10px;}
    </style>
</head>
<body>

<div class="contenedor">

    <div class="lado-izquierdo">
        Farmacia Online
    </div>

    <div class="lado-derecho">
        <form class="formulario" method="POST" action="login.php">
            <h2>Iniciar Sesión</h2>

            <?php if(!empty($error)) echo "<div class='error'>$error</div>"; ?>

            <input type="email" name="correo" placeholder="Correo electrónico">
            <input type="password" name="contrasena" placeholder="Contraseña">

            <button type="submit" name="accion" value="login">Entrar</button>

            <div class="extra">
                ¿No tienes cuenta? <a href="../Registro/Registro.html">Regístrate</a>
            </div>

            <!-- Botón que solo apunta a la URL del inicio -->
            <div class="invitado">
                <a href="../invitados/inicio2.php">
                    <button type="button">Entrar como invitado</button>
                </a>
            </div>

        </form>
    </div>

</div>

</body>
</html>
