<?php
$conexion = new mysqli("localhost", "root", "", "farmacia_web");
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendar Cita</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding-top: 80px; /* espacio para navbar fija */
        }

        /* Navbar estilo imagen */
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .navbar-nav {
            margin: 0 auto;
        }

        .nav-link {
            color: #007bff !important;
            font-weight: bold;
            margin: 0 5px;
            padding: 8px 15px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .nav-link:hover {
            background-color: #e6f0ff;
            color: #0056b3 !important;
            text-decoration: none;
        }

        .nav-link.active {
            background-color: #007bff;
            color: white !important;
        }

        /* Contenedor formulario */
        .contenedor {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .formulario label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        .formulario input, 
        .formulario select, 
        .formulario button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .formulario button {
            background-color: #007bff;
            color: white;
            border: none;
            margin-top: 20px;
            cursor: pointer;
            font-size: 16px;
        }

        .formulario button:hover {
            background-color: #0056b3;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px 0;
            background-color: #007bff;
            color: white;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="Inicio.html">
            <img src="../Imagenes/logo.jpg" alt="Logo" style="width:55px;height:55px;border-radius:10px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="menu">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="../Inicio.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="../Productos/Productos.php">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="../Horarios/Horarios.php">Horarios</a></li>
                <li class="nav-item"><a class="nav-link active" href="../Citas/citas.php">Citas</a></li>
                <li class="nav-item"><a class="nav-link" href="../nosotros.html">Sobre Nosotros</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenedor del formulario -->
<div class="contenedor">
    <h2>Agendar una Cita</h2>

    <form action="guardar_cita.php" method="POST" class="formulario">

        <!-- Horarios -->
        <label for="id_horario">Seleccionar horario:</label>
        <select name="id_horario" id="id_horario" required>
            <?php include "mostrar_horarios.php"; ?>
        </select>

        <!-- Doctor mostrado automáticamente -->
        <label>Doctor asignado:</label>
        <input type="text" id="doctor_nombre" disabled>

        <!-- Hidden para enviar a la BD -->
        <input type="hidden" name="id_doctor" id="id_doctor">

        <!-- Nombre del paciente -->
        <label for="paciente_nombre">Nombre del paciente:</label>
        <input type="text" name="paciente_nombre" id="paciente_nombre" required placeholder="Ej: Juan Pérez">

        <button type="submit">Guardar Cita</button>
    </form>
</div>
<br>
<br>


<footer>
    Farmacia Web &copy; 2025
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Mostrar doctor automáticamente al cambiar el horario
document.getElementById("id_horario").addEventListener("change", function() {
    let option = this.options[this.selectedIndex];
    document.getElementById("doctor_nombre").value = option.dataset.doctor;
    document.getElementById("id_doctor").value = option.dataset.iddoctor;
});
</script>

</body>
</html>
