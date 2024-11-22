<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); // Iniciar la sesión

include __DIR__ . '/dh/db.php'; // Asegúrate de que el archivo db.php esté incluido correctamente

// Mensaje de depuración para verificar que se incluyó correctamente el archivo db.php
echo "db.php incluido correctamente.<br>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar que la conexión a la base de datos existe
    if (isset($pdo)) {
        echo "Conexión a la base de datos exitosa.<br>"; // Mensaje de depuración

        // Preparar y ejecutar la consulta para obtener el usuario
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            echo "Usuario encontrado: " . $usuario['username'] . "<br>"; // Depuración
            echo "Hash guardado: " . $usuario['password'] . "<br>"; // Depuración
            echo "Contraseña ingresada: " . $password . "<br>"; // Depuración

            // Verificar la contraseña
            if (password_verify($password, $usuario['password'])) {
                echo "Contraseña verificada correctamente.<br>"; // Depuración

                // Guardar la información del usuario en la sesión
                $_SESSION['user_id'] = $usuario['id']; // Guardar el ID del usuario en la sesión
                $_SESSION['username'] = $usuario['username'];
                $_SESSION['role'] = $usuario['role'];

                // Redirigir al panel de administración (dashboard.php)
                header('Location: dashboard.php');
                exit(); // Salir después de la redirección
            } else {
                echo "Credenciales incorrectas."; // Si la contraseña es incorrecta
            }
        } else {
            echo "Usuario no encontrado."; // Si el usuario no existe
        }
    } else {
        echo "Error: La conexión a la base de datos no está disponible."; // Si no hay conexión a la base de datos
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form method="POST" action="login.php">
        <label for="username">Usuario</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Contraseña</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>





