<?php
// Incluye el archivo de funciones
include 'utilidades_texto.php';

// Array de frases de ejemplo
$frases = [
    "La programación es una habilidad muy útil en el mundo moderno.",
    "Hola, mundo! Esto es un ejemplo de análisis de texto en PHP.",
    "El rápido zorro marrón salta sobre el perro perezoso."
];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Análisis de Texto con PHP</title>
    <style>
        body { font-family: sans-serif; margin: 2em; }
        table { width: 100%; border-collapse: collapse; margin-top: 1.5em; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Resultados del Análisis de Texto</h1>

    <table>
        <thead>
            <tr>
                <th>Texto Original</th>
                <th>Palabras</th>
                <th>Vocales</th>
                <th>Texto Invertido</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($frases as $frase): ?>
            <tr>
                <td><?php echo htmlspecialchars($frase); ?></td>
                <td><?php echo contar_palabras($frase); ?></td>
                <td><?php echo contar_vocales($frase); ?></td>
                <td><?php echo htmlspecialchars(invertir_palabras($frase)); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>