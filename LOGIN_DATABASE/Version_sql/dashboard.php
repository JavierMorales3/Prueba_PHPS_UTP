<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>¡Bienvenido, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
    <p>Has iniciado sesión exitosamente con MySQLi.</p>
    <p>
        <a href="logout.php">Cerrar Sesión</a>
    </p>
</body>
</html>