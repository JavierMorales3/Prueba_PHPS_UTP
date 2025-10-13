<?php
// eliminar_del_carrito.php
require_once 'config_sesion.php';

if (isset($_GET['id'])) {
    $id_producto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    // Validación de la existencia del producto en el carrito
    if ($id_producto !== false && $id_producto !== null && isset($_SESSION['carrito'][$id_producto])) {
        unset($_SESSION['carrito'][$id_producto]);
    }
}

header('Location: ver_carrito.php');
exit;
?>