<?php
session_start(); // Necesario para obtener id_usuario

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "farmacia_web");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Validar que se recibieron los datos
if (!isset($_POST['id_horario'], $_POST['id_doctor'], $_POST['paciente_nombre'])) {
    die("Faltan datos del formulario.");
}

// Validar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    die("Debes iniciar sesión para agendar una cita.");
}

// Recibir y sanitizar datos
$id_horario = intval($_POST['id_horario']);
$id_doctor = intval($_POST['id_doctor']);
$nombre_paciente = $conexion->real_escape_string($_POST['paciente_nombre']);
$id_usuario = intval($_SESSION['id_usuario']);

// Insertar la cita usando los horarios del doctor
$sql = "INSERT INTO citas (id_doctor, nombre_paciente, id_usuario, horario_inicio, horario_salida)
        SELECT id_doctor, '$nombre_paciente', $id_usuario, horario_entrada, horario_salida
        FROM horarios_doctores
        WHERE id_horario = $id_horario";

if ($conexion->query($sql)) {
    echo "<h2>Cita guardada correctamente ✔</h2>";
    echo "<p><a href='citas.php'>Volver a agendar</a></p>";
} else {
    echo "<h2>Error al guardar la cita: " . $conexion->error . "</h2>";
}

$conexion->close();
?>
