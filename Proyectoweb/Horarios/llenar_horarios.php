<?php
// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "farmacia_web");

if ($conn->connect_error) {
    die("<tr><td colspan='4'>Error de conexión: ".$conn->connect_error."</td></tr>");
}

// Consulta para traer horarios con información del doctor
$sql = "SELECT h.id_horario, d.nombre_doctor, d.apellido_doctor, d.especialidad_doctor, h.horario_entrada, h.horario_salida
        FROM Horarios_Doctores h
        JOIN Doctores d ON h.id_doctor = d.id_doctor
        ORDER BY d.nombre_doctor, h.horario_entrada";

$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>".$row['nombre_doctor']." ".$row['apellido_doctor']."</td>";
        echo "<td>".$row['especialidad_doctor']."</td>";
        echo "<td>".substr($row['horario_entrada'],0,5)."</td>";
        echo "<td>".substr($row['horario_salida'],0,5)."</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No hay horarios disponibles</td></tr>";
}

$conn->close();
?>
