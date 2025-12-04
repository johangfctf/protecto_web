<?php
session_start();
include 'conexion.php'; // Conexión a tu base de datos

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Productos | Farmacia Online</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    margin:0;
    background:#f4eefc;
    font-family: Arial, sans-serif;
    padding-top: 80px;
}

/* Navbar */
.navbar-brand img { width:55px; height:55px; border-radius:10px; object-fit:cover; }
.nav-link { font-weight:bold; color:#0072ff !important; padding:8px 12px; border-radius:6px; transition:0.2s; }
.nav-link:hover { background-color:#e0f0ff; color:#004db3 !important; text-decoration:none; }
.nav-link.active { background-color:#0072ff; color:white !important; }

/* Sidebar categorías */
.category { padding:10px; background:#faf6ff; margin-bottom:8px; border-radius:6px; cursor:pointer; text-align:center; transition:0.2s; }
.category:hover { background:#e8dbff; }

/* Productos */
.product-card { background:white; padding:15px; border-radius:12px; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.15); transition:0.3s; }
.product-card:hover { transform:translateY(-5px); }
.product-card img { width:100%; height:150px; object-fit:contain; border-radius:10px; background:#ede8ff; }

/* Botón agregar al carrito */
.btn-primary { background:#0072ff; color:white !important; padding:8px 12px; border-radius:6px; font-weight:bold; text-decoration:none; }
.btn-primary:hover { background:#005fd6; }

/* Carrito */
.cart { background:white; padding:15px; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1); position:sticky; top:10px; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
<div class="container">
    <a class="navbar-brand" href="../Inicio.php"><img src="../Imagenes/logo.jpg" alt="Logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse justify-content-center" id="menu">
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="../Inicio.php">Inicio</a></li>
            <li class="nav-item"><a class="nav-link active" href="Productos.php">Productos</a></li>
            <li class="nav-item"><a class="nav-link" href="../Horarios/Horarios.php">Horarios</a></li>
            <li class="nav-item"><a class="nav-link" href="../Citas/citas.php">Citas</a></li>
            <li class="nav-item"><a class="nav-link" href="../nosotros.php">Sobre Nosotros</a></li>
        </ul>
    </div>
</div>
</nav>

<div class="container py-4">
<div class="row">

    <!-- Sidebar Categorías -->
    <div class="col-lg-2 mb-3">
        <div class="bg-white p-3 rounded shadow-sm h-100">
            <h4>Categorías</h4>
            <?php
            $sql = "SELECT DISTINCT categoria_producto FROM Productos ORDER BY categoria_producto";
            $res = $conn->query($sql);
            if ($res->num_rows > 0) {
                while ($cat = $res->fetch_assoc()) {
                    echo '<div class="category" onclick="cargarProductos(\'' . htmlspecialchars($cat['categoria_producto']) . '\')">'
                        . htmlspecialchars($cat['categoria_producto']) .
                        '</div>';
                }
            } else {
                echo "<p>No hay productos registrados.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="col-lg-10">
        <div class="d-flex justify-content-between mb-4 flex-wrap">
            <!-- Buscador -->
            <input type="text" id="busqueda" class="form-control w-50 mb-2" placeholder="Buscar productos..." onkeyup="buscarProductosAjax()">

            <!-- Carrito -->
            <div class="cart mb-2" style="min-width:200px;">
                <h5>Carrito</h5>
                <?php
                $carrito = $_SESSION['carrito'];
                if(count($carrito) > 0){
                    foreach($carrito as $item){
                        echo '<p>' . htmlspecialchars($item['nombre_producto']) . ' x ' . $item['cantidad'] . '</p>';
                    }
                } else {
                    echo '<p>El carrito está vacío.</p>';
                }
                ?>
                <a href="../Carrito/mostrar_carrito.php" class="btn btn-primary w-100 mt-2">Ver carrito</a>
            </div>
        </div>

        <!-- Productos -->
        <div class="row g-4" id="productos">
            <p>Cargando productos...</p>
        </div>
    </div>
</div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function cargarProductos(categoria) {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "llenar_productos.php?categoria=" + encodeURIComponent(categoria), true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById("productos").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

function buscarProductosAjax() {
    const filtro = document.getElementById('busqueda').value;
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "llenar_productos.php?q=" + encodeURIComponent(filtro), true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById("productos").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

// Cargar productos iniciales al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "llenar_productos.php", true);
    xhr.onload = function() {
        if(xhr.status === 200){
            document.getElementById("productos").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});
</script>
</body>
</html>
