<?php
require_once 'config_pdo.php';

// Redirigir si el usuario ya está logueado
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard_pdo.php");
    exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Validar entradas (igual que en la versión MySQLi)
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor, ingrese el nombre de usuario.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor, ingrese su contraseña.";
    } else {
        $password = trim($_POST["password"]);
    }

    // 2. Autenticar credenciales
    if (empty($username_err) && empty($password_err)) {
        // Consulta preparada con marcadores de posición con nombre (preferido en PDO)
        $sql = "SELECT id, username, password FROM usuarios WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Vincular el parámetro
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            $param_username = $username;

            // Ejecutar la sentencia
            if ($stmt->execute()) {
                // Verificar si existe el nombre de usuario (fetch busca la primera fila)
                if ($stmt->rowCount() == 1) {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $id = $user['id'];
                    $username = $user['username'];
                    $hashed_password = $user['password'];

                    // Verificar la contraseña
                    if (password_verify($password, $hashed_password)) {
                        // Contraseña correcta, iniciar sesión
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;

                        // Redirigir al dashboard
                        header("location: dashboard_pdo.php");
                    } else {
                        // Contraseña no válida
                        $login_err = "Nombre de usuario o contraseña incorrectos.";
                    }
                } else {
                    // Nombre de usuario no existe
                    $login_err = "Nombre de usuario o contraseña incorrectos.";
                }
            } else {
                echo "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
            }

            // Cerrar sentencia (opcional en PDO, ya que se libera al salir del ámbito)
            unset($stmt);
        }
    }

    // Cerrar conexión (opcional en PDO)
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - PDO</title>
</head>
<body>
    <h2>Login (PDO)</h2>
    <?php
    if (!empty($login_err)) {
        echo '<div>' . $login_err . '</div>';
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label>Usuario</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
            <span><?php echo $username_err; ?></span>
        </div>
        <div>
            <label>Contraseña</label>
            <input type="password" name="password">
            <span><?php echo $password_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Ingresar">
        </div>
    </form>
</body>
</html>















CREATE TABLE usuarios (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);