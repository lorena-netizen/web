<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Gestión de Ventas Dunkin Donuts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <img src="img/logo.svg" alt="Logo Dunkin Donuts" class="logo">
    <img src="img/fondo.webp" alt="Marca de Agua Dunkin" class="watermark">
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <form action="login.php" method="post"> <!-- Cambiado a login.php -->
            <input type="text" placeholder="Usuario" name="username" required> <!-- Cambié 'usuario' a 'username' -->
            <input type="password" placeholder="Contraseña" name="password" required> <!-- Cambié 'contraseña' a 'password' -->
            <div class="options">
                <label>
                    <input type="checkbox" name="recordar" value="si"> Recordar Usuario
                </label><br>
                <label>
                    <input type="checkbox" name="mantener" value="si"> Mantener sesión iniciada
                </label><br>
                <a href="#">¿Ha olvidado la clave?</a>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <footer>
            <p>&copy; 2024 Dunkin Donuts. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>
</html>
