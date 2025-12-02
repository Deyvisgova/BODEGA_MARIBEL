<?php

@include '../../../modelo/config.php';
@include '../../../modelo/conexion.php';
@include '../../../controlador/controlador_adm/controlador_contadorTablas.php';
@include '../../../controlador/controlador_adm/controlador_fecha_hora_actual.php';


session_start();

if(isset($_SESSION['nombre_colab'])){
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
    <title>Colaborador Bodega Maribel</title>   

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
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Bodega Maribel<sup> Colaborador</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboardColaborador.php">
                    <i class="fa-solid fa-house"></i>
                    <span>Inicio</span></a>
            </li>
           
           
            <!-- Nav Item - Dashboard  SE TIENE QUE CAMBIAR LA RUTA EN LOS HREF POR LOS ARCHIVOS DENTRO DEL FICHERO dashboard-->
            
           
           
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <sub class="nav-link active" style="color: whitesmoke;">Gestion de Productos</sub>
            </li>
             <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="tabla_producto_colab.php"><!--aquí también-->
                <i class="fa-sharp fa-solid fa-cookie"></i>
                <span>Productos</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="tabla_cantidad_colab.php"><!--aquí también-->
                <i class="fa-sharp fa-solid fa-cookie"></i>
                <span>Entrada de Productos/Stock</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tabla_guia_salida_colab.php"><!--aquí también-->
                <i class="fa-sharp fa-solid fa-cookie"></i>
                <span>Salida de Prodcutos Stock</span></a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider my-0">   
            <li class="nav-item active">
            <sub class="nav-link active" style="color: whitesmoke;">Otros</sub>
            
                        <li class="nav-item">
                <a class="nav-link" href="tabla_provedor_colab.php">
                <i class="fa-solid fa-lock"></i>
                    <span>Provedores</span></a>
                 </li>

                 <li class="nav-item">
                <a class="nav-link" href="cambiar_contraseña_colab.php">
                <i class="fa-solid fa-lock"></i>
                    <span>Cambiar Contraseña</span></a>
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">colaborador-<?php echo $_SESSION['colab_name'] ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- MENU DE OPCIONES DEL ADMINISTRADOR -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="dashboardColaborador.php">
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        
                        <h1 class="h3 mb-0 text-gray-800" style="font-family: Verdana, Geneva, Tahoma, sans-serif;">Bienvenido(a) <?php echo $_SESSION['colab_name'] ?> al sistema  de Bodega Maribel </h1>


                    </div>

                    <!-- Content Row  INTERFAZ DE INICIO - OPCIONES -->
                    <div class="row">


    

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

</body>

</html>