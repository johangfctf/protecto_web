<?php
session_start();
include '../Productos/conexion.php'; // Conexión a la base de datos

if(!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0){
    $_SESSION['error'] = "No hay productos en el carrito.";
    header("Location: mostrar_carrito.php");
    exit;
}

// Recorremos el carrito y descontamos stock
foreach($_SESSION['carrito'] as $item){
    $id_producto = intval($item['id_producto']);
    $cantidad_comprada = intval($item['cantidad']);

    // Primero obtenemos la cantidad actual en la base de datos
    $stmt = $conn->prepare("SELECT cantidad_producto FROM Productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res->num_rows > 0){
        $prod = $res->fetch_assoc();
        $cantidad_actual = intval($prod['cantidad_producto']);

        // Calculamos la nueva cantidad
        $nueva_cantidad = $cantidad_actual - $cantidad_comprada;
        if($nueva_cantidad < 0) $nueva_cantidad = 0; // No puede ser negativo

        // Actualizamos la base de datos
        $update = $conn->prepare("UPDATE Productos SET cantidad_producto = ? WHERE id_producto = ?");
        $update->bind_param("ii", $nueva_cantidad, $id_producto);
        $update->execute();
    }
}

// Vaciamos el carrito
unset($_SESSION['carrito']);

// Mensaje de éxito
$_SESSION['success'] = "Compra realizada. El stock se ha actualizado correctamente.";

// Redirigimos a productos.php
header("Location: ../Productos/productos.php");
exit;
?>
