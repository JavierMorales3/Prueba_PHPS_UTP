<?php
// Incluir el archivo de configuración de sesión.
include 'config_sesion.php';

// Obtener el contenido del carrito. Si la sesión no tiene 'carrito', usa un array vacío.
$resumen_compra = $_SESSION['carrito'] ?? [];
$total_compra = 0;

// Recalcular el total de la compra (es redundante si ya se calculó en ver_carrito, pero es buena práctica de seguridad).
foreach ($resumen_compra as $item) {
    $total_compra += $item['precio'] * $item['cantidad'];
}

// Lógica para manejar el envío del formulario de nombre de usuario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar el nombre de usuario enviado por POST.
    $nombre_usuario = filter_input(INPUT_POST, 'nombre_usuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Si el nombre no está vacío, configurar y guardar la cookie.
    if (!empty($nombre_usuario)) {
        // Duración de la cookie: 1 día (86400 segundos).
        $duracion = time() + (86400); 
        
        // Opciones de seguridad para la cookie.
        $opciones_cookie = [
            'expires' => $duracion,
            'path' => '/', // Disponible en todo el sitio.
            'httponly' => true, // Previene acceso por JavaScript (contra XSS).
            'secure' => true, // Solo se envía sobre HTTPS.
            'samesite' => 'Lax' // Protección contra CSRF.
        ];
        
        // Establecer la cookie.
        setcookie('usuario_compra', $nombre_usuario, $opciones_cookie);
    }

    // Vaciar el carrito de la sesión después de la finalización de la compra.
    unset($_SESSION['carrito']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <style>
        body { font-family: sans-serif; }
    </style>
</head>
<body>
    <h1>Resumen Compra</h1>
    <?php if (!empty($resumen_compra)): ?>
        <ul>
            <?php foreach ($resumen_compra as $item): ?>
                <li>
                    <?php echo htmlspecialchars($item['nombre']); ?> (Cantidad: <?php echo htmlspecialchars($item['cantidad']); ?>) - Subtotal: $<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <h3>Total: $<?php echo number_format($total_compra, 2); ?></h3>
        <hr>
        <p>Gracias por tu compra.</p>
        
        <?php if (!isset($_COOKIE['usuario_compra'])): ?>
            <form action="checkout.php" method="post">
                <label for="nombre_usuario">¿Cómo te llamas?:</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" required>
                <button type="submit">Guardar Nombre</button>
            </form>
        <?php else: ?>
            <p>Hola de nuevo, <?php echo htmlspecialchars($_COOKIE['usuario_compra']); ?> Gracias por tu compra.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>No hay productos para finalizar la compra. Por favor, <a href="productos.php">vuelve a la tienda</a>.</p>
    <?php endif; ?>
</body>
</html>