<?php
session_start();
include '../Productos/conexion.php'; // La conexión está fuera de la carpeta Carrito

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'], $_POST['cantidad'])) {
    $id = intval($_POST['id_producto']);
    $cantidad = intval($_POST['cantidad']);

    // Buscar el producto en la base de datos
    $stmt = $conn->prepare("SELECT id_producto, nombre_producto, precio_producto FROM Productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();

        // Inicializar carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Si ya existe el producto en el carrito, sumar cantidad
        $existe = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id_producto'] == $producto['id_producto']) {
                $item['cantidad'] += $cantidad;
                $existe = true;
                break;
            }
        }
        if (!$existe) {
            $_SESSION['carrito'][] = [
                'id_producto' => $producto['id_producto'],
                'nombre_producto' => $producto['nombre_producto'],
                'precio_producto' => $producto['precio_producto'],
                'cantidad' => $cantidad
            ];
        }
    }
}

// Redirigir a la tienda
header("Location: ../Productos/productos.php"); 
exit;
?>
