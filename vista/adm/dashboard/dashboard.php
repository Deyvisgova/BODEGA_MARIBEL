<?php

@include '../../../modelo/config.php';
@include '../../../modelo/conexion.php';
@include '../../../controlador/controlador_adm/controlador_contadorTablas.php';
@include '../../../controlador/controlador_adm/controlador_fecha_hora_actual.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:index.php');
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

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                <i class="fa-solid fa-shield-dog"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Maribel Mayorista<sup> Admin</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fa-solid fa-house"></i>
                    <span>Inicio</span></a>
            </li>
           
            <!-- Nav Item - Dashboard  SE TIENE QUE CAMBIAR LA RUTA EN LOS HREF POR LOS ARCHIVOS DENTRO DEL FICHERO dashboard-->
            <li class="nav-item">
                <a class="nav-link" href="tabla_admin.php"><!--Al igual que tabla_admin.php hay que corregir-->
                    <i class="fa-solid fa-key"></i>
                    <span>Administrador</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tabla_colaborador.php">
                <i class="fa-sharp fa-solid fa-user"></i>
                    <span>Colaborador</span></a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <sub class="nav-link active" style="color: whitesmoke;">Gestion de Productos</sub>
            </li>
             <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="tabla_producto.php"><!--aquí también-->
                <i class="fa-sharp fa-solid fa-cookie"></i>
                <span>Productos</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tabla_checkList.php"><!--aquí también-->
                <i class="fa-sharp fa-solid fa-cookie"></i>
                <span>Chek List</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tabla_producto.php"><!--aquí también-->
                <i class="fa-sharp fa-solid fa-cookie"></i>
                <span>categoria</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tabla_guia_entrada.php"><!--aquí también-->
                <i class="fa-sharp fa-solid fa-cookie"></i>
                <span>Guia de Entrada</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tabla_guia_salida.php"><!--aquí también-->
                <i class="fa-sharp fa-solid fa-cookie"></i>
                <span>Guia de Salida</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tabla_Reporte_guias.php"><!--aquí también-->
                <i class="fa-sharp fa-solid fa-cookie"></i>
                <span>Reporte Individual de Guias</span></a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider my-0">   
            <li class="nav-item active">
            <sub class="nav-link active" style="color: whitesmoke;">Otros</sub>
            
                        <li class="nav-item">
                <a class="nav-link" href="tabla_provedor.php">
                <i class="fa-solid fa-lock"></i>
                    <span>Provedores</span></a>
                 </li>
            
            
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="../../../vista/login/logout.php"  data-toggle="modal"  data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    <span>Salir</span>
                </a>
            </li>   
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

<!--  ********************************************** BARRA DE NAVEGACION DEL ADMINISTRADOR *******************************************-->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">

                    </form>
                    
                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 mx-auto Center-block">
                        <br><p style="text-align: center;"><?php echo $fecha_actual ?><br><i>son las</i> <?php echo $hora_24?></p>
                    </div>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

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

                                <a class="dropdown-item" href="../../login/register_form_adm.php">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Registro de administrador
                                </a>
                                <a class="dropdown-item" href="../../login/register_form.php">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Registro de Colaboradores
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        
                        <h1 class="h3 mb-0 text-gray-800" style="font-family: Verdana, Geneva, Tahoma, sans-serif;">Bienvenido(a) <?php echo $_SESSION['admin_name'] ?> a Bodega Maribel </h1>


                    </div>

                    <!-- Content Row  INTERFAZ DE INICIO - OPCIONES -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Cuentas de Administradores </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "".$administrador;?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fa-solid fa-key fa-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-10 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">provedores
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo "".$provedor ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fa-solid fa-handshake fa-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            

                        <!-- Earnings (Monthly) Card Example -->

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Cantidad de Colaboradores</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "".$colaborador ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fa-sharp fa-solid fa-user fa-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->

                       

                    
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Productos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "".$producto ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fa-sharp fa-solid fa-cookie fa-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Categoria</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "".$categoria ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fa-sharp fa-solid fa-cookie fa-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <br><br>
                        
                        <div>
   <head>
    <title>Gráfico de Productos</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var dataProductos = google.visualization.arrayToDataTable([
                ['Producto', 'Cantidad'],
                <?php
                $SQLProductos = "SELECT * FROM producto";
                $consultaProductos = mysqli_query($conn, $SQLProductos);
                while ($resultadoProductos = mysqli_fetch_assoc($consultaProductos)) {
                    echo "['" . $resultadoProductos['nombre_producto'] . "', " . $resultadoProductos['cantidad'] . "],";
                }
                ?>
            ]);

            var optionsProductos = {
                title: 'Productos en Almacén'
            };

            var chartProductos = new google.visualization.PieChart(document.getElementById('piechartProductos'));
            chartProductos.draw(dataProductos, optionsProductos);
        }
    </script>
</head>
<body>
    <div id="piechartProductos" style="width: 600px; height: 400px; margin: auto;"></div>
    
</body>

</div>
<div>

<head>
    <title>Gráfico de Productos Retirados por Producto</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Fecha');

            <?php
            // Agregar columnas para cada producto
            $SQLProductos = "SELECT DISTINCT producto FROM guia_de_salida";
            $consultaProductos = mysqli_query($conn, $SQLProductos);

            while ($resultadoProductos = mysqli_fetch_assoc($consultaProductos)) {
                echo "data.addColumn('number', '{$resultadoProductos['producto']}');";
            }

            // Obtener datos de productos retirados por fecha
            $SQLRetiros = "SELECT fecha_salida, producto, SUM(cantidad_salida) AS cantidad_total FROM guia_de_salida GROUP BY fecha_salida, producto";
            $consultaRetiros = mysqli_query($conn, $SQLRetiros);

            $fechas = [];
            $dataProductos = [];

            while ($resultadoRetiros = mysqli_fetch_assoc($consultaRetiros)) {
                $fecha = date('Y-m-d', strtotime($resultadoRetiros['fecha_salida']));

                // Almacenar fechas únicas
                if (!in_array($fecha, $fechas)) {
                    $fechas[] = $fecha;
                }

                // Almacenar datos por producto y fecha
                $dataProductos[$resultadoRetiros['producto']][$fecha] = $resultadoRetiros['cantidad_total'];
            }

            // Agregar filas al DataTable
            foreach ($fechas as $fecha) {
                $rowData = "[new Date('$fecha')";
                foreach ($dataProductos as $producto => $data) {
                    $cantidad = isset($data[$fecha]) ? $data[$fecha] : 0;
                    $rowData .= ", $cantidad";
                }
                $rowData .= "]";
                echo "data.addRow($rowData);";
            }
            ?>

            var options = {
                title: 'Productos Retirados por Fecha y Producto',
                isStacked: true,
                legend: { position: 'top' }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="chart_div" style="width: 800px; height: 400px;"></div>
</body>

<div>
   <head>
    <title>Gráfico de Productos Ingresados por Producto</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Fecha');

            <?php
            // Agregar columnas para cada producto
            $SQLProductos = "SELECT DISTINCT producto FROM guia_de_entrada";
            $consultaProductos = mysqli_query($conn, $SQLProductos);

            while ($resultadoProductos = mysqli_fetch_assoc($consultaProductos)) {
                echo "data.addColumn('number', '{$resultadoProductos['producto']}');";
            }

            // Obtener datos de productos ingresados por fecha
            $SQLEntradas = "SELECT fecha_entrada, producto, SUM(cantidad_entrada) AS cantidad_total FROM guia_de_entrada GROUP BY fecha_entrada, producto";
            $consultaEntradas = mysqli_query($conn, $SQLEntradas);

            $fechas = [];
            $dataProductos = [];

            while ($resultadoEntradas = mysqli_fetch_assoc($consultaEntradas)) {
                $fecha = date('Y-m-d', strtotime($resultadoEntradas['fecha_entrada']));

                // Almacenar fechas únicas
                if (!in_array($fecha, $fechas)) {
                    $fechas[] = $fecha;
                }

                // Almacenar datos por producto y fecha
                $dataProductos[$resultadoEntradas['producto']][$fecha] = $resultadoEntradas['cantidad_total'];
            }

            // Agregar filas al DataTable
            foreach ($fechas as $fecha) {
                $rowData = "[new Date('$fecha')";
                foreach ($dataProductos as $producto => $data) {
                    $cantidad = isset($data[$fecha]) ? $data[$fecha] : 0;
                    $rowData .= ", $cantidad";
                }
                $rowData .= "]";
                echo "data.addRow($rowData);";
            }
            ?>

            var options = {
                title: 'Productos Ingresados por Fecha y Producto',
                isStacked: true,
                legend: { position: 'top' }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_entrada'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="chart_div_entrada" style="width: 800px; height: 400px;"></div>
</body>
</div>
 


    <!-- /.container-fluid -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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