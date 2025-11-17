<?php
// Incluir el archivo de configuración de sesión para iniciar o reanudar la sesión.
include 'config_sesion.php';

// Leer el contenido del archivo JSON que contiene la información de los productos.
$json_data = file_get_contents('productos.json');

// Decodificar el JSON a un array asociativo PHP. Si falla, $productos será un array vacío.
$productos = json_decode($json_data, true) ?? [];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Productos Disponibles</h1>
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
    // Mostrar un saludo si existe la cookie de usuario de compra
    if (isset($_COOKIE['usuario_compra'])) {
        // Sanitizar el contenido de la cookie antes de mostrarlo
        echo "<p>Hola de nuevo, " . htmlspecialchars($_COOKIE['usuario_compra']) . ".</p>";
    }
    ?>
</body>
</html>