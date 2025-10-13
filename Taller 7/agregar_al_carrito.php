<?php
// agregar_al_carrito.php
require_once 'config_sesion.php';

// Definición de los productos para validar el ID
$productos = [
    1 => ['nombre' => 'Laptop Gamer', 'precio' => 1200.00],
    2 => ['nombre' => 'Monitor 4K', 'precio' => 350.50],
    3 => ['nombre' => 'Teclado Mecánico', 'precio' => 85.00],
    4 => ['nombre' => 'Mouse Inalámbrico', 'precio' => 45.20],
    5 => ['nombre' => 'Auriculares RGB', 'precio' => 60.00],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);

    // Validación del ID del producto
    if ($id_producto !== false && $id_producto !== null && array_key_exists($id_producto, $productos)) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Si el producto ya está en el carrito, incrementa la cantidad
        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]['cantidad']++;
        } else {
            // Si no está, lo agrega con cantidad 1
            $_SESSION['carrito'][$id_producto] = [
                'nombre' => $productos[$id_producto]['nombre'],
                'precio' => $productos[$id_producto]['precio'],
                'cantidad' => 1,
            ];
        }
        header('Location: ver_carrito.php');
        exit;
    } else {
        // Redirige al usuario si el ID del producto es inválido
        header('Location: productos.php?error=producto_invalido');
        exit;
    }
}
?>