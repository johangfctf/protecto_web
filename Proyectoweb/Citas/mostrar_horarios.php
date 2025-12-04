<?php
$conexion = new mysqli("localhost", "root", "", "farmaceutica");

$sql = "SELECT h.id_horario, h.horario_entrada, h.horario_salida,
               d.id_doctor, d.nombre_doctor, d.apellido_doctor
        FROM horarios_doctores h
        INNER JOIN doctores d ON d.id_doctor = h.id_doctor";

$resultado = $conexion->query($sql);

while ($fila = $resultado->fetch_assoc()) {
    $doctor = $fila["nombre_doctor"] . " " . $fila["apellido_doctor"];

    echo "<option value='{$fila['id_horario']}'
            data-doctor='$doctor'
            data-iddoctor='{$fila['id_doctor']}'>
            {$fila['horario_entrada']} - {$fila['horario_salida']}
          </option>";
}
?>
