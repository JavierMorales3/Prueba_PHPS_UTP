<?php

function calcular_descuento($total_compra) {
    if ($total_compra > 1000) {
        return $total_compra * 0.15; // 15% de descuento
    } elseif ($total_compra >= 501 && $total_compra <= 1000) {
        return $total_compra * 0.10; // 10% de descuento
    } elseif ($total_compra >= 100 && $total_compra <= 500) {
        return $total_compra * 0.05; // 5% de descuento
    } else {
        return 0; // Sin descuento
    }
}

function aplicar_impuesto($subtotal) {
    return $subtotal * 0.07; // 7% de impuesto
}

function calcular_total($subtotal, $descuento, $impuesto) {
    return $subtotal - $descuento + $impuesto;
}

?>