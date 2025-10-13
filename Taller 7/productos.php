<?php
// productos.php
require_once 'config_sesion.php';

// Definición de los productos
$productos = [
    1 => ['nombre' => 'Laptop Gamer', 'precio' => 1200.00],
    2 => ['nombre' => 'Monitor 4K', 'precio' => 350.50],
    3 => ['nombre' => 'Teclado Mecánico', 'precio' => 85.00],
    4 => ['nombre' => 'Mouse Inalámbrico', 'precio' => 45.20],
    5 => ['nombre' => 'Auriculares RGB', 'precio' => 60.00],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Carrito de Compras</title>
    <style>
        body { font-family: sans-serif; }
        .producto { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
        .producto h3 { margin: 0; }
        .producto form { display: inline; }
    </style>
</head>
<body>
    <h1>Nuestros Productos</h1>
    <a href="ver_carrito.php">Ver Carrito</a>
    <hr>
    <?php foreach ($productos as $id => $producto): ?>
        <div class="producto">
            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
            <p>Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
            <form action="agregar_al_carrito.php" method="post">
                <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($id); ?>">
                <button type="submit">Agregar al Carrito</button>
            </form>
        </div>
    <?php endforeach; ?>
    <hr>
    <?php
    if (isset($_COOKIE['usuario_compra'])) {
        echo "<p>¡Hola de nuevo, " . htmlspecialchars($_COOKIE['usuario_compra']) . "! Nos alegra verte.</p>";
    }
    ?>
</body>
</html>