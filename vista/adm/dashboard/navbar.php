<?php

@include '../../../modelo/config.php';
@include '../../../modelo/conexion.php';
@include '../../../controlador/controlador_adm/controlador_contadorTablas.php';
@include '../../../controlador/controlador_adm/controlador_fecha_hora_actual.php';

function tablaExiste(mysqli $conn, string $tabla): bool {
    $sql = "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('s', $tabla);
    $stmt->execute();
    $stmt->bind_result($existe);
    $stmt->fetch();
    $stmt->close();

    return (bool) $existe;
}

function obtenerAlertasNavbar(mysqli $conn): array {
    $alertas = [
        'bajoStock' => [],
        'vencimientos' => [],
    ];

    $stock = $conn->query("SELECT id_producto, nombre_producto, stock_actual FROM producto WHERE stock_actual <= 10 ORDER BY stock_actual ASC, nombre_producto");
    if ($stock) {
        $alertas['bajoStock'] = $stock->fetch_all(MYSQLI_ASSOC);
    }

    if (tablaExiste($conn, 'lote')) {
        $vencimientos = $conn->query(
            "SELECT l.id_lote, l.fecha_vencimiento, l.fecha_ingreso, p.nombre_producto
             FROM lote l
             INNER JOIN producto p ON p.id_producto = l.id_producto
             WHERE l.fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL 20 DAY)
             ORDER BY l.fecha_vencimiento ASC"
        );

        if ($vencimientos) {
            $alertas['vencimientos'] = $vencimientos->fetch_all(MYSQLI_ASSOC);
        }
    }

    return $alertas;
}

$alertasNavbar = obtenerAlertasNavbar($conn);

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}
?>
<!DOCTYPE html>
<html lang="es">
										<!-- BARRA DE NAV EMPIEZA EN LA FILA 			pag 169-->
										<!-- Recuperar nombre del admninitrador 		pag 338-->
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://kit.fontawesome.com/73c70fe811.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../../imagenes/principal/makro.ico" type="image/x-icon">
    <title>Administrador Bodega Maribel</title>   

    <!-- Custom fonts for this template-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link
    
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css?sas" rel="stylesheet">
    <link href="css/reloj.css" rel="sytlesheet">

</head>

<body id="page-top">       
    
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        
        <!-- Main Content -->
        <div id="content1" class="nav-bar">
                
                <!--  ********************************************** BARRA DE NAVEGACION DEL ADMINISTRADOR *******************************************-->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group light-table-filter">
                            <input type="text" class="form-control bg-light border-0 small" data-table="table_id" type="text"  placeholder="Busqueda ..."
                                 aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 mx-auto Center-block">
                    <br><p style="text-align: center;"><?php echo $fecha_actual ?><br><i>son las</i> <?php echo $hora_24?></p>
                </div>
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <?php $totalAlertas = count($alertasNavbar['bajoStock']) + count($alertasNavbar['vencimientos']); ?>
                    <li class="nav-item dropdown no-arrow mx-2">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-bell"></i>
                            <?php if ($totalAlertas > 0): ?>
                                <span class="badge badge-danger badge-counter"><?php echo $totalAlertas; ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown" style="min-width: 320px;">
                            <h6 class="dropdown-header">Alertas de inventario</h6>
                            <?php if (!$totalAlertas): ?>
                                <span class="dropdown-item text-muted">No hay alertas pendientes.</span>
                            <?php endif; ?>
                            <?php foreach ($alertasNavbar['bajoStock'] as $producto): ?>
                                <div class="dropdown-item d-flex align-items-center">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fa-solid fa-box-open text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Stock bajo</div>
                                        <span class="font-weight-bold"><?php echo htmlspecialchars($producto['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?></span>
                                        <div class="text-muted">Disponible: <?php echo (int) $producto['stock_actual']; ?> uds.</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php foreach ($alertasNavbar['vencimientos'] as $lote): ?>
                                <div class="dropdown-item d-flex align-items-center">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-danger">
                                            <i class="fa-solid fa-triangle-exclamation text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Vence <?php echo htmlspecialchars($lote['fecha_vencimiento'], ENT_QUOTES, 'UTF-8'); ?></div>
                                        <span class="font-weight-bold">Lote #<?php echo (int) $lote['id_lote']; ?> - <?php echo htmlspecialchars($lote['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?></span>
                                        <div class="text-muted">Ingresó: <?php echo htmlspecialchars($lote['fecha_ingreso'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </li>
                    
                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                    placeholder="Search for..." aria-label="Search"
                                    aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    


            <!-- --------------------------------------------------------RECUPERAR NOMBRE DEL ADMINISTRADOR ----------------------------------> 
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrador-<?php echo $_SESSION['admin_name'] ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- MENU DE OPCIONES DEL ADMINISTRADOR -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="dashboard.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Inicio
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../../../vista/login/logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Salir
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <div class="container-fluid">
                    <!-- Page Heading -->

     <!-- Logout Modal-->
     <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Seguro quieres salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccionaste "Salir" a continuación si está listo para finalizar su sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="../../../vista/login/logout.php">Salir</a>
                </div>
            </div>
            
        </div>
    </div>
                    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="../../js/busqueda.js"></script>

</body>

</html>