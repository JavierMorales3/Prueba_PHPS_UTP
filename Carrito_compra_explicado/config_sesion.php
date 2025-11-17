<?php
// Deshabilitar la configuración de sesión 'session.cookie_httponly' para seguridad contra XSS (Cross-Site Scripting)
// 'httponly' a '1' significa que la cookie de sesión solo es accesible a través del protocolo HTTP, no por scripts del lado del cliente (como JavaScript).
ini_set('session.cookie_httponly', 1);

// Obligar a que la sesión solo use cookies para transmitir el ID de sesión.
ini_set('session.use_only_cookies', 1);

// Asegurar que la cookie de sesión solo se envíe a través de conexiones seguras (HTTPS).
ini_set('session.cookie_secure', 1);

// Habilitar el modo estricto de sesión. Evita que PHP acepte IDs de sesión que no hayan sido generados por el servidor.
ini_set('session.use_strict_mode', 1);

// Iniciar o reanudar la sesión.
session_start();

// Control de inactividad: regenerar el ID de sesión si han pasado más de 300 segundos (5 minutos) desde la última actividad.
// Esto ayuda a prevenir ataques de fijación de sesión.
if (!isset($_SESSION['ultima_actividad']) || (time() - $_SESSION['ultima_actividad'] > 300)) {
    // Regenerar el ID de sesión, eliminando el antiguo. El argumento 'true' elimina la sesión anterior.
    session_regenerate_id(true);
    // Actualizar el tiempo de la última actividad.
    $_SESSION['ultima_actividad'] = time();
}
?>