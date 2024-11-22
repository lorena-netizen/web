<?php
session_start(); 
include __DIR__ . '/dh/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Lógica para generar informes
$informes = [];
try {
    // Consulta para obtener todas las ventas
    $stmt = $pdo->query("SELECT * FROM ventas ORDER BY fecha DESC");
    $informes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p class='error'>Error al obtener informes: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Obtener los precios de los productos
$productos = [];
try {
    $stmt_productos = $pdo->query("SELECT * FROM productos");
    $productos = $stmt_productos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p class='error'>Error al obtener productos: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Generar Informes - Dunkin Donuts</title>
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
            <li class="nav-item">
                <a class="nav-link" href="registrar_devolucion.php">
                    <i class="fas fa-fw fa-undo"></i>
                    <span>Registrar Devolución</span></a>
            </li>
            <li class="nav-item active">
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
                    <h1 class="h3 mb-2 text-gray-800">Informes de Ventas</h1>
                    <?php if (empty($informes)): ?>
                        <p>No hay informes disponibles.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID Venta</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($informes as $informe): ?>
                                        <?php 
                                            // Buscar el precio del producto
                                            $precio = 0;
                                            foreach ($productos as $producto) {
                                                if ($producto['nombre'] == $informe['producto']) {
                                                    $precio = $producto['precio']; // Suponiendo que 'precio' está en la tabla 'productos'
                                                    break;
                                                }
                                            }
                                            $total = $precio * $informe['cantidad']; // Calcular el total (cantidad * precio)
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($informe['id']); ?></td>
                                            <td><?php echo htmlspecialchars($informe['producto']); ?></td>
                                            <td><?php echo htmlspecialchars($informe['cantidad']); ?></td>
                                            <td><?php echo htmlspecialchars($informe['fecha']); ?></td>
                                            <td>S/ <?php echo htmlspecialchars(number_format($total, 2)); ?></td> <!-- Mostrar el total con el signo de soles -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
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




                   
