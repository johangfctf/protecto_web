<?php
session_start();
include '../Productos/conexion.php'; // Ruta a tu conexión
$carrito = $_SESSION['carrito'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<div class="container py-4">
    <h3 class="mb-4">Carrito de Compras</h3>

    <?php if(count($carrito) > 0): 
        $total = 0;
    ?>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($carrito as $index => $item):
                $subtotal = $item['precio_producto'] * $item['cantidad'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nombre_producto']); ?></td>
                    <td>$<?php echo number_format($item['precio_producto'],2); ?></td>
                    <td><?php echo $item['cantidad']; ?></td>
                    <td>$<?php echo number_format($subtotal,2); ?></td>
                    <td>
                        <a href="eliminar_carrito.php?index=<?php echo $index; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <h5>Total: $<?php echo number_format($total,2); ?></h5>

        <!-- Formulario de pago con mini-resumen -->
        <form id="formPagar" action="guardar_recibo.php" method="POST" class="mt-3">
            <h5>Resumen del Recibo:</h5>
            <ul>
            <?php foreach($carrito as $item): ?>
                <li><?php echo htmlspecialchars($item['nombre_producto']); ?> x <?php echo $item['cantidad']; ?> → $<?php echo number_format($item['precio_producto'] * $item['cantidad'],2); ?></li>
            <?php endforeach; ?>
            </ul>
            <p><strong>Total: $<?php echo number_format($total,2); ?></strong></p>
            <input type="hidden" name="cantidad" value="<?php echo count($carrito); ?>">
            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <button type="submit" class="btn btn-success">Pagar</button>
        </form>

        <a href="../Productos/productos.php" class="btn btn-secondary mt-3">Seguir comprando</a>

    <?php else: ?>
        <p>El carrito está vacío.</p>
        <a href="../Productos/productos.php" class="btn btn-primary mt-2">Ir a la tienda</a>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
