<?php
// Incluye el archivo de funciones
include 'funciones_tienda.php';

// Array de productos y sus precios
$precios_productos = [
    'camisa' => 50,
    'pantalon' => 70,
    'zapatos' => 80,
    'calcetines' => 10,
    'gorra' => 25
];

// Array que simula un carrito de compras
$carrito = [
    'camisa' => 2,
    'pantalon' => 1,
    'zapatos' => 1,
    'calcetines' => 3,
    'gorra' => 0
];

// Calcular el subtotal
$subtotal = 0;
foreach ($carrito as $producto => $cantidad) {
    if ($cantidad > 0) {
        $subtotal += $precios_productos[$producto] * $cantidad;
    }
}

// Calcular el descuento, el impuesto y el total
$descuento = calcular_descuento($subtotal);
$impuesto = aplicar_impuesto($subtotal - $descuento);
$total = calcular_total($subtotal, $descuento, $impuesto);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de la Compra</title>
    <style>
        body { font-family: sans-serif; margin: 2em; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h1, h2 { color: #333; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 1.5em; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; }
        td { background-color: #f9f9f9; }
        .summary-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #ccc; }
        .summary-item:last-child { font-weight: bold; border-bottom: none; }
    </style>
</head>
<body>

<div class="container">
    <h1>Resumen de la Compra</h1>

    <h2>Productos Comprados</h2>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal Producto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carrito as $producto => $cantidad): ?>
                <?php if ($cantidad > 0): ?>
                    <tr>
                        <td><?php echo ucfirst($producto); ?></td>
                        <td><?php echo $cantidad; ?></td>
                        <td>$<?php echo number_format($precios_productos[$producto], 2); ?></td>
                        <td>$<?php echo number_format($precios_productos[$producto] * $cantidad, 2); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Detalles del Pago</h2>
    <div class="summary">
        <div class="summary-item">
            <span>Subtotal:</span>
            <span>$<?php echo number_format($subtotal, 2); ?></span>
        </div>
        <div class="summary-item">
            <span>Descuento Aplicado:</span>
            <span>-$<?php echo number_format($descuento, 2); ?></span>
        </div>
        <div class="summary-item">
            <span>Impuesto (7%):</span>
            <span>+$<?php echo number_format($impuesto, 2); ?></span>
        </div>
        <div class="summary-item" style="font-size: 1.2em;">
            <span>Total a Pagar:</span>
            <span>$<?php echo number_format($total, 2); ?></span>
        </div>
    </div>
</div>

</body>
</html>