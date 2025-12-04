<?php
session_start();

// Conexión
$conexion = new mysqli("localhost", "root", "", "farmaceutica");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (!isset($_POST['id_horario'], $_POST['id_doctor'], $_POST['paciente_nombre'])) {
    die("Faltan datos del formulario.");
}

$id_horario = $_POST['id_horario'];
$id_doctor = intval($_POST['id_doctor']);
$nombre_paciente = $conexion->real_escape_string($_POST['paciente_nombre']);
$id_usuario = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : 0;

$id_horarios = is_array($id_horario) ? $id_horario : [$id_horario];

$errores = [];
$fecha_hoy = date("Y-m-d"); // ← FECHA ACTUAL

foreach ($id_horarios as $horario) {
    $horario_id = intval($horario);

    $result = $conexion->query(
        "SELECT horario_entrada, horario_salida 
         FROM horarios_doctores 
         WHERE id_horario = $horario_id"
    );

    if ($result && $row = $result->fetch_assoc()) {

        // Construir DATETIME válidos
        $horario_inicio = $fecha_hoy . " " . $row['horario_entrada'];
        $horario_salida = $fecha_hoy . " " . $row['horario_salida'];

        // Insertar cita
        $sql = "INSERT INTO citas (id_doctor, paciente_nombre, id_usuario, horario_inicio, horario_salida)
                VALUES ($id_doctor, '$nombre_paciente', $id_usuario, '$horario_inicio', '$horario_salida')";

        if (!$conexion->query($sql)) {
            $errores[] = "Error con horario ID $horario_id: " . $conexion->error;
        }

    } else {
        $errores[] = "Horario ID $horario_id no encontrado";
    }
}

if (empty($errores)) {
    echo "<h2>Cita(s) guardada(s) correctamente ✔</h2>";
} else {
    echo "<h2>Errores:</h2><ul>";
    foreach ($errores as $err) echo "<li>$err</li>";
    echo "</ul>";
}

echo "<p><a href='citas.php'>Volver</a></p>";

$conexion->close();
?>
