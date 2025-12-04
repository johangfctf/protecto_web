<?php
session_start();
include '../Productos/conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'], $_POST['cantidad'])) {

    $id = intval($_POST['id_producto']);
    $cantidadSolicitada = intval($_POST['cantidad']);

    // 1. Buscar producto y stock real
    $stmt = $conn->prepare("SELECT id_producto, nombre_producto, precio_producto, cantidad_producto 
                            FROM Productos 
                            WHERE id_producto = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $producto = $result->fetch_assoc();
        $stock = (int)$producto['cantidad_producto'];

        // 2. Validar si hay suficiente stock
        if ($cantidadSolicitada > $stock) {
            $_SESSION['error'] = "Solo hay $stock unidades disponibles de '" . $producto['nombre_producto'] . "'.";
            header("Location: ../Productos/productos.php");
            exit;
        }

        // 3. Inicializar carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $existe = false;

        // 4. Validar si ya existe el producto en el carrito
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id_producto'] == $producto['id_producto']) {
                
                // Validar que no supere el stock total
                if ($item['cantidad'] + $cantidadSolicitada > $stock) {
                    $_SESSION['error'] = "No puedes agregar más de $stock unidades en total de '" 
                                        . $producto['nombre_producto'] . "'.";
                    header("Location: ../Productos/productos.php");
                    exit;
                }

                $item['cantidad'] += $cantidadSolicitada;
                $existe = true;
                break;
            }
        }

        // 5. Si no existe en el carrito, agregarlo
        if (!$existe) {
            $_SESSION['carrito'][] = [
                'id_producto' => $producto['id_producto'],
                'nombre_producto' => $producto['nombre_producto'],
                'precio_producto' => $producto['precio_producto'],
                'cantidad' => $cantidadSolicitada
            ];
        }
    }
}

// Volver a productos
header("Location: ../Productos/productos.php");
exit;
?>
