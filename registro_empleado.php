<?php
session_start();
$file_path = $_SERVER['DOCUMENT_ROOT'] . '/proyecto/dh/db.php';
if (!file_exists($file_path)) {
    die("El archivo no existe: " . $file_path);
}
include $file_path; // Ruta absoluta para incluir db.php

// Solo el admin puede acceder
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar los campos
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validación básica de los campos
    if (empty($username) || empty($password)) {
        $mensaje = "Por favor, complete todos los campos.";
    } elseif (strlen($password) < 6) {
        $mensaje = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        // Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->fetchColumn() > 0) {
            $mensaje = "El nombre de usuario ya está registrado. Por favor, elija otro.";
        } else {
            // Hash de la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Consulta preparada para insertar nuevo usuario
            $stmt = $pdo->prepare("INSERT INTO usuarios (username, password, role) VALUES (?, ?, 'empleado')");
            if ($stmt->execute([$username, $hashed_password])) {
                $mensaje = "Empleado registrado con éxito.";
            } else {
                $mensaje = "Error al registrar el empleado. Por favor, intente nuevamente.";
            }
        }
    }
}

// Asignar valores de sesión o valores predeterminados
$username = $_SESSION['username'] ?? 'Invitado';
$role = $_SESSION['role'] ?? 'Desconocido';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro de Empleados - Dunkin Donuts</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc;
            margin: 0;
            font-family: 'Nunito', sans-serif;
        }
        .titulo-centrado {
            text-align: center; /* Centrar texto */
            margin-bottom: 20px;
        }
        .form-container {
            max-width: 400px; /* Limitar el ancho del formulario */
            width: 100%; /* Asegurarse de que se ajuste al contenedor */
            padding: 20px; /* Espaciado interno */
            background-color: #fff; /* Fondo blanco para contraste */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra ligera */
            text-align: center; /* Centrar contenido dentro del contenedor */
            margin: auto; /* Centrar el contenedor en la página */
            position: fixed; /* Usar fixed para asegurar la posición fija en la pantalla */
            left: 58%; /* Centrado horizontal */
            top: 20%; /* Puedes ajustar este valor para moverlo más abajo o más arriba */
            transform: translateX(-50%); /* Asegurar que se centre horizontalmente */
        }
        h1 {
            color: #FF6F20; /* Color Dunkin' Donuts */
            margin-bottom: 20px;
            font-size: 1.75rem; /* Tamaño de fuente */
            font-weight: bold; /* Negrita */
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #FF6F20; /* Color al enfocar */
            box-shadow: 0 0 5px rgba(255, 111, 32, 0.5); /* Sombra al enfocar */
        }
        button {
        background-color: #FF6F20; /* Color Dunkin' Donuts */
        color: white;
        border: 2px solid #FF8A3D; /* Borde ligeramente más claro */
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
        transition: background-color 0.3s, border-color 0.3s;
        }

        button:hover {
        background-color: #FF8A3D; /* Color más claro */
        border-color: #FF6F20; /* Borde más oscuro al pasar el ratón */
        }
        .alert {
        margin-bottom: 20px;
        font-size: 0.9rem;
        color: #fff;
        background-color: #FF6F20; /* Naranja para alertas */
        border: none;
        border-radius: 10px;
        padding: 10px;
        }
        /* Estilos para el sidebar */
        .sidebar {
        background-color: #FF6F20; /* Color naranja */
        height: 100vh; /* Ocupa toda la altura de la página */
        }
        .sidebar .nav-link {
        color: #fff; /* Texto blanco */
        }
        .sidebar .nav-link.active {
        background-color: #FF8A3D; /* Color más claro para el menú activo */
        }
        .bg-gradient-primary {
        background-color: #FF6F20; /* Naranja Dunkin */
        background-image: linear-gradient(180deg, #FF6F20 10%, #FF8A3D 100%);
        }
        .text-primary {
        color: #FF6F20; /* Naranja Dunkin' Donuts */
        }
        .navbar {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        padding: 0.1rem 0.1rem;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <div class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Dunkin Donuts</div>
            </div>
            <hr class="sidebar-divider my-0">
            <div class="sidebar-heading">
                Bienvenido, <?php echo htmlspecialchars($username); ?> (<?php echo htmlspecialchars($role); ?>)
            </div>
            <li class="nav-item">
                <?php if ($role === 'admin'): ?>
                    <a class="nav-link" href="registro_empleado.php">Registrar Empleado</a>
                    <a class="nav-link" href="registro_cliente.php">Registrar Cliente</a>
                    <a class="nav-link" href="inventario.php">Gestionar Inventario</a>
                    <a class="nav-link" href="registrar_venta.php">Registrar Ventas</a>
                    <a class="nav-link" href="registrar_devolucion.php">Registrar Devoluciones</a>
                    <a class="nav-link" href="generar_informe.php">Generar Informes</a>
                <?php endif; ?>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Panel de Control</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" style="width: 1200px; margin: auto;">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($username); ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Salir
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="titulo-centrado">
                        <h1 class="h3 mb-0 text-primary">
                            <i class="fas fa-user-plus" style="color: #FF6F20;"></i> Registrar Empleado
                        </h1>
                    </div>
                    <div class="form-container">
                        <?php if (!empty($mensaje)): ?>
                            <div class="alert"><?php echo htmlspecialchars($mensaje); ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="Nombre de usuario" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary" style="background-color: #FF6F20;">Registrar</button>
                        </form>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Dunkin Donuts 2024</span>
                    </div>
                </div>
            </footer>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>














