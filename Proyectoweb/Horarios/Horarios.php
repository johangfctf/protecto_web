<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios | Farmacia Online</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #f7f7f7;
            font-family: Arial, sans-serif;
            padding-top: 80px; /* Para navbar fixed-top */
        }

        /* Navbar */
        .navbar-brand img {
            width: 55px;
            height: 55px;
            border-radius: 10px;
            object-fit: cover;
        }

        .nav-link {
            font-weight: bold;
            color: #0072ff !important;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background 0.2s, color 0.2s;
        }

        .nav-link:hover {
            background-color: #e0f0ff;
            color: #004db3 !important;
            text-decoration: none;
        }

        .nav-link.active {
            background-color: #0072ff;
            color: white !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #0072ff;
            color: white;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<!-- Navbar sin iniciar sesión -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container">

        <a class="navbar-brand" href="../Inicio.php">
            <img src="../Imagenes/logo.jpg" alt="Logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="menu">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="../inicio.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="../Productos/Productos.php">Productos</a></li>
                <li class="nav-item"><a class="nav-link active" href="Horarios.php">Horarios</a></li>
                <li class="nav-item"><a class="nav-link" href="../Citas/citas.php">Citas</a></li>
                <li class="nav-item"><a class="nav-link" href="../nosotros.html">Sobre Nosotros</a></li>
            </ul>
        </div>

    </div>
</nav>

<!-- Contenido -->
<div class="container" style="margin-top: 50px;">
    <h2 class="text-center text-primary mb-4">Horarios de Atención</h2>
    
    <table>
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Especialidad</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Conexión a la base de datos
            $conn = new mysqli("localhost", "root", "", "farmacia_web");
            if ($conn->connect_error) {
                echo "<tr><td colspan='4'>Error de conexión: ".$conn->connect_error."</td></tr>";
            } else {
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
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
