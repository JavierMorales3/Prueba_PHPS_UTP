<?php
// Incluir el archivo de configuración de sesión.
include 'config_sesion.php';

// Verificar si se ha enviado el ID del producto a eliminar a través de la URL (método GET).
if (isset($_GET['id'])) {
    // Sanitizar y validar el ID del producto enviado por GET. Debe ser un entero.
    $id_producto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    // Verificar que la validación fue exitosa y que el producto existe en el carrito de la sesión.
    if ($id_producto !== false && $id_producto !== null && isset($_SESSION['carrito'][$id_producto])) {
        // Eliminar completamente el producto del array del carrito.
        unset($_SESSION['carrito'][$id_producto]);
    }
}

// Redirigir al usuario de vuelta a la página del carrito.
header('Location: ver_carrito.php');
exit;
?>