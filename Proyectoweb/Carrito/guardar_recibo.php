<?php
session_start();
include '../Productos/conexion.php'; // Manteniendo $conn

// Verificar que se envió la información
if (!isset($_POST['total']) || !isset($_POST['cantidad'])) {
    header("Location: ../Productos/productos.php"); // Redirige a la tienda si no hay datos
    exit;
}

$id_usuario = $_SESSION['id_usuario'] ?? 1; // temporal si no hay sesión
$cantidad = $_POST['cantidad'];
$total = $_POST['total'];

// Insertar el recibo en la base de datos usando la tabla correcta "recibo"
$stmt = $conn->prepare("INSERT INTO recibo (id_usuario, cantidad_recibo, total_recibo) VALUES (?, ?, ?)");
$stmt->bind_param("iid", $id_usuario, $cantidad, $total);
$stmt->execute();
$stmt->close();

// Vaciar carrito
unset($_SESSION['carrito']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Recibo guardado</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h3>¡Pago realizado con éxito! Tu recibo ha sido generado.</h3>

    <h5>Resumen de tu compra:</h5>
    <p>Cantidad de productos: <?php echo $cantidad; ?></p>
    <p>Total pagado: $<?php echo number_format($total,2); ?></p>

    <a href="../Productos/productos.php" class="btn btn-primary mt-3">Volver a la tienda</a>
</div>
</body>
</html>
