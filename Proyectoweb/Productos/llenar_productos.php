<?php
session_start();
include 'conexion.php';

$categoria = $_GET['categoria'] ?? '';
$buscar = '%' . ($_GET['q'] ?? '') . '%';

if($categoria != '') {
    // Productos por categoría + búsqueda
    $sql = "SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, cantidad_producto
            FROM Productos 
            WHERE categoria_producto = ? 
            AND (nombre_producto LIKE ? OR descripcion_producto LIKE ? OR categoria_producto LIKE ?)
            LIMIT 6";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $categoria, $buscar, $buscar, $buscar);
} else {
    // Productos iniciales o búsqueda general
    $sql = "SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, cantidad_producto 
            FROM Productos 
            WHERE nombre_producto LIKE ? OR descripcion_producto LIKE ? OR categoria_producto LIKE ?
            ORDER BY id_producto DESC
            LIMIT 6";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $buscar, $buscar, $buscar);
}

$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    while($prod = $result->fetch_assoc()){

        $stock = (int)$prod['cantidad_producto'];

        echo '<div class="col-md-4">';
        echo '<div class="product-card p-3">';

        echo '<img src="img_producto/' . htmlspecialchars($prod['imagen_producto']) . '" 
                alt="' . htmlspecialchars($prod['nombre_producto']) . '" 
                class="img-fluid mb-2">';

        echo '<h4>' . htmlspecialchars($prod['nombre_producto']) . '</h4>';
        echo '<p>' . htmlspecialchars($prod['descripcion_producto']) . '</p>';
        echo '<p><b>Stock:</b> ' . $stock . '</p>';
        echo '<p>$' . number_format($prod['precio_producto'],2) . '</p>';

        // ⛔ AGOTADO
        if ($stock <= 0) {
            echo '<button class="btn btn-danger w-100" disabled>AGOTADO</button>';

        // ✔ PRODUCTO DISPONIBLE
        } else {
            echo '<form method="POST" action="../Carrito/agregar_carrito.php">';
            echo '<input type="hidden" name="id_producto" value="'.$prod['id_producto'].'">';

            // Limitar cantidad al stock disponible
            echo '<input type="number" name="cantidad" value="1" min="1" max="'.$stock.'" class="form-control mb-2">';

            echo '<button type="submit" class="btn btn-primary w-100">Agregar al carrito</button>';
            echo '</form>';
        }

        echo '</div></div>';
    }
} else {
    echo "<p>No hay productos que coincidan con tu búsqueda.</p>";
}

$conn->close();
?>
