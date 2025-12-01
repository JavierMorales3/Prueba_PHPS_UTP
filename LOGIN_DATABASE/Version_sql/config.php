<?php
// Credenciales de la base de datos
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Reemplaza con tu usuario
define('DB_PASSWORD', '');     // Reemplaza con tu contraseña
define('DB_NAME', 'mi_base_de_datos'); // Reemplaza con el nombre de tu BD

// Conexión a la base de datos MySQL
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificar la conexión
if ($mysqli->connect_errno) {
    die("ERROR: No se pudo conectar a la base de datos: " . $mysqli->connect_error);
}

// Iniciar sesión (para mantener el estado del usuario)
session_start();
?>