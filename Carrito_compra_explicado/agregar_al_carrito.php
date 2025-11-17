<?php
// Incluir el archivo de configuración de sesión.
include 'config_sesion.php';

// Cargar los datos de los productos desde el archivo JSON.
$json_data = file_get_contents('productos.json');
// Decodificar el JSON. Si falla, inicializa como un array vacío.
$productos = json_decode($json_data, true) ?? [];

// Verificar si la solicitud se realizó utilizando el método POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitizar y validar el ID del producto enviado por POST.
    // Se utiliza FILTER_VALIDATE_INT para asegurar que es un número entero.
    $id_producto_int = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);

    // Convertir el entero validado a string para que coincida con las claves del array $productos,
    // o asignar null si la validación falló.
    $id_producto = ($id_producto_int !== false && $id_producto_int !== null) ? (string)$id_producto_int : null;

    // Verificar si el ID de producto es válido y existe en el catálogo de productos.
    if ($id_producto !== null && array_key_exists($id_producto, $productos)) {
        // Inicializar el carrito en la sesión si aún no existe.
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Si el producto ya está en el carrito, incrementar la cantidad.
        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]['cantidad']++;
        } else {
            // Si el producto no está en el carrito, agregarlo con cantidad 1.
            $_SESSION['carrito'][$id_producto] = [
                'nombre' => $productos[$id_producto]['nombre'],
                'precio' => $productos[$id_producto]['precio'],
                'cantidad' => 1,
            ];
        }
        // Redirigir al usuario a la página del carrito después de la acción.
        header('Location: ver_carrito.php');
        exit;
    } else {
        // Si el ID del producto es inválido o no existe, redirigir con un mensaje de error.
        header('Location: productos.php?error=producto_invalido');
        exit;
    }

}
?>