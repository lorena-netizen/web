<?php
// Conectar a la base de datos
include __DIR__ . '/dh.php'; // Asegúrate de incluir tu archivo de conexión

$username = 'admin'; // Nombre de usuario
$password = 'admin123'; // Contraseña en texto plano

// Generar el hash de la contraseña
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $hashedPassword, 'admin']); // 'admin' es el rol del usuario
    echo "Usuario 'admin' creado exitosamente con la contraseña 'admin123'.";
} catch (PDOException $e) {
    echo "Error al crear el usuario: " . $e->getMessage();
}
?>

