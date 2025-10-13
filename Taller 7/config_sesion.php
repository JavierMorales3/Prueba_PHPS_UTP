<?php
// config_sesion.php
// Medidas de seguridad para las sesiones
ini_set('session.cookie_httponly', 1); // Evita que JavaScript acceda a la cookie de sesión
ini_set('session.cookie_secure', 1); // Envía la cookie solo a través de HTTPS
ini_set('session.use_strict_mode', 1); // Previene la inyección de ID de sesión
ini_set('session.use_only_cookies', 1); // Fuerza el uso de cookies para el ID de sesión

// Inicia la sesión de forma segura
session_start();
session_regenerate_id(true); // Renueva el ID de sesión para prevenir el secuestro de sesión (session hijacking)
?>