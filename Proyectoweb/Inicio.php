<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio | Farmacia Online</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background: #f7f7f7;
            font-family: Arial, sans-serif;
            padding-top: 80px;
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
            transition: 0.3s;
        }
        .nav-link:hover {
            color: #004db3 !important;
            text-decoration: underline;
        }

        /* Carrusel */
        .carousel-inner img {
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Productos Destacados */
        .producto {
            background: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            transition: 0.3s;
        }
        .producto:hover {
            transform: translateY(-5px);
        }
        .producto img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            border-radius: 10px;
            background: #ede8ff;
        }
        .btn-comprar {
            background: #0072ff;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-comprar:hover {
            background: #005edd;
        }

        footer {
            background: #003a8c;
            color: white;
            padding: 20px;
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand" href="inicio.php">
            <img src="Imagenes/logo.jpg" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="menu">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="inicio.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="Productos/Productos.php">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="Horarios/Horarios.php">Horarios</a></li>
                <li class="nav-item"><a class="nav-link" href="Citas/citas.php">Citas</a></li>
                <li class="nav-item"><a class="nav-link" href="nosotros.php">Sobre Nosotros</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

    <!-- CARRUSEL -->
    <div id="carouselExample" class="carousel slide shadow rounded overflow-hidden mb-5">
        <div class="carousel-inner">
            <div class="carousel-item active"><img src="Imagenes/Carrusel.jpg" class="d-block w-100"></div>
            <div class="carousel-item"><img src="Imagenes/Carrusel2.jpg" class="d-block w-100"></div>
            <div class="carousel-item"><img src="Imagenes/Carrusel3.jpg" class="d-block w-100"></div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- PRODUCTOS DESTACADOS -->
    <h2 class="text-center mb-4 text-primary">Productos Destacados</h2>
    <div class="row justify-content-center g-4">
        <?php
        $productos = [
            ['img'=>'Productos/img_producto/Paracetamol.jpg','nombre'=>'Paracetamol 500mg','desc'=>'Alivia dolor y fiebre.'],
            ['img'=>'Productos/img_producto/Paracetamol + Cafeína.png','nombre'=>'Antigripal','desc'=>'Para síntomas de gripe.'],
            ['img'=>'Productos/img_producto/Vitamina C 500mg.avif','nombre'=>'Vitamina C','desc'=>'Refuerza defensas.']
        ];
        foreach($productos as $p): ?>
            <div class="col-12 col-md-4 col-lg-3">
                <div class="producto p-3 shadow-sm rounded">
                    <img src="<?= $p['img'] ?>" class="img-fluid mb-2">
                    <h5><?= $p['nombre'] ?></h5>
                    <p><?= $p['desc'] ?></p>
                    <a class="btn-comprar" href="Productos/Productos.php">Comprar</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<footer>
    © 2025 Farmacia Online - Todos los derechos reservados.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
