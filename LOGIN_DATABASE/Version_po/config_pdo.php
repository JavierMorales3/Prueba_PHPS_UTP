<?php
// Credenciales
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Reemplaza con tu usuario
define('DB_PASS', '');     // Reemplaza con tu contraseña
define('DB_NAME', 'mi_base_de_datos'); // Reemplaza con el nombre de tu BD

// Cadena de conexión DSN
$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

try {
    // Crear una instancia de PDO
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    // Establecer el modo de error de PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Mostrar un mensaje de error si la conexión falla
    die("ERROR: No se pudo conectar a la base de datos: " . $e->getMessage());
}

// Iniciar sesión
session_start();
?>