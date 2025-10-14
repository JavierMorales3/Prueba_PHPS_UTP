<?php
include 'config_sesion.php';

// Leer el contenido del archivo productos.json
$json_data = file_get_contents('productos.json');

// Decodificar el JSON a un arreglo PHP. true para obtener un arreglo asociativo.
$productos = json_decode($json_data, true) ?? [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Al cargar desde JSON, las claves son strings. Se convierte $id_producto a string para la búsqueda.
    $id_producto_int = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
    
    // Si la validación es exitosa, convertimos a string para usar como clave en $productos
    $id_producto = ($id_producto_int !== false && $id_producto_int !== null) ? (string)$id_producto_int : null;

    if ($id_producto !== null && array_key_exists($id_producto, $productos)) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]['cantidad']++;
        } else {
            $_SESSION['carrito'][$id_producto] = [
                'nombre' => $productos[$id_producto]['nombre'],
                'precio' => $productos[$id_producto]['precio'],
                'cantidad' => 1,
            ];
        }
        header('Location: ver_carrito.php');
        exit;
    } else {
        header('Location: productos.php?error=producto_invalido');
        exit;
    }

}
?>
