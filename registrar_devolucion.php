<?php
session_start();
include __DIR__ . '/dh/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];

    // Lógica para registrar la devolución (actualiza la base de datos)
    $stmt = $pdo->prepare("UPDATE productos SET cantidad = cantidad + ? WHERE nombre = ?");
    $stmt->execute([$quantity, $product_name]);

    echo "<p class='success'>Devolución registrada con éxito.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registrar Devolución - Dunkin Donuts</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc;
        }
        .bg-gradient-primary {
            background-color: #FF6F20;
            background-image: linear-gradient(180deg, #FF6F20 10%, #FF8A3D 100%);
        }
        .text-primary {
            color: #FF6F20;
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-coffee"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Dunkin Donuts</div>
            </a>
            <li class="nav-item">
                <a class="nav-link" href="inventario.php">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Gestión de Inventario</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_venta.php">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Registrar Venta</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="registrar_devolucion.php">
                    <i class="fas fa-fw fa-undo"></i>
                    <span>Registrar Devolución</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="generar_informe.php">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Generar Informes</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Panel de Control</span>
                </a>
            </li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrador</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Registrar Devolución</h1>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="product_name">Nombre del Producto</label>
                            <input type="text" class="form-control" name="product_name" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Cantidad</label>
                            <input type="number" class="form-control" name="quantity" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="background-color: #FF6F20;">Registrar Devolución</button>
                    </form>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Dunkin Donuts 2024</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>

