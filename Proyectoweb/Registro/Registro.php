<?php
// CONEXIÓN A LA BASE DE DATOS (MYSQL - XAMPP)
$conexion = new mysqli("localhost", "root", "", "farmacia_web");

// VERIFICAR CONEXIÓN
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// OBTENER DATOS DEL FORMULARIO
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$password = $_POST['password'];
$confirmar = $_POST['confirmar'];

// VALIDAR QUE LAS CONTRASEÑAS COINCIDAN
if ($password !== $confirmar) {
    echo "
        <script>
            alert('Las contraseñas no coinciden');
            window.location.href = 'Registro.html';
        </script>
    ";
    exit();
}

// VERIFICAR QUE EL CORREO YA ESTÉ REGISTRADO
$sqlCorreo = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE correo_usuario = ?");
$sqlCorreo->bind_param("s", $correo);
$sqlCorreo->execute();
$resultado = $sqlCorreo->get_result();

if ($resultado->num_rows > 0) {
    echo "
        <script>
            alert('Este correo ya está registrado');
            window.location.href = 'Registro.html';
        </script>
    ";
    exit();
}

// INSERTAR EL NUEVO USUARIO
$sqlInsert = $conexion->prepare("
    INSERT INTO usuarios (nombre_usuario, apellido_usuario, correo_usuario, contrasena_usuario)
    VALUES (?, ?, ?, ?)
");
$sqlInsert->bind_param("ssss", $nombre, $apellido, $correo, $password);

if ($sqlInsert->execute()) {
    echo "
        <script>
            alert('Registro exitoso. Ahora puedes iniciar sesión');
            window.location.href = '../Login/Login.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Error al registrar el usuario');
            window.location.href = 'Registro.html';
        </script>
    ";
}

$conexion->close();
?>
