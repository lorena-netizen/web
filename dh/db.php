<?php
$host = 'localhost'; // Host de la base de datos
$db = 'bd'; // Nombre de tu base de datos
$user = 'root'; // Usuario por defecto en XAMPP
$pass = ''; // Contraseña, generalmente está vacío en XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage(); // Mostrar error
}
?>



