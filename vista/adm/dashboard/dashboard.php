<?php
/** @var string $adminName */
/** @var string $fechaActual */
/** @var string $horaActual */
/** @var array $resumen */
/** @var array $productosInventario */
/** @var array $datosSalidas */
/** @var array $datosEntradas */

$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$scriptDir = str_replace('\\', '/', dirname($scriptName));
$vistaPos = strpos($scriptDir, '/vista/');
$projectBase = $vistaPos === false ? $scriptDir : substr($scriptDir, 0, $vistaPos);
$projectBase = rtrim($projectBase, '/');
$projectBase = $projectBase === '/' ? '' : $projectBase;

$buildUrl = static function (string $path) use ($projectBase): string {
    $normalized = '/' . ltrim($path, '/');
    $base = $projectBase !== '' ? $projectBase : '';
    return $base . $normalized;
};

$assetBase = $buildUrl('vista/adm/dashboard');
$adminName = $adminName ?? 'Administrador';
$fechaActual = $fechaActual ?? '';
$horaActual = $horaActual ?? '';
$resumen = $resumen ?? [];
$productosInventario = $productosInventario ?? [];
$datosSalidas = $datosSalidas ?? ['productos' => [], 'fechas' => [], 'valores' => []];
$datosEntradas = $datosEntradas ?? ['productos' => [], 'fechas' => [], 'valores' => []];

$tarjetas = [
    ['clave' => 'administradores', 'titulo' => 'Cuentas de Administradores', 'color' => 'primary', 'icono' => 'fa-solid fa-key'],
    ['clave' => 'proveedores', 'titulo' => 'Proveedores', 'color' => 'info', 'icono' => 'fa-solid fa-handshake'],
    ['clave' => 'colaboradores', 'titulo' => 'Colaboradores', 'color' => 'danger', 'icono' => 'fa-solid fa-user'],
    ['clave' => 'productos', 'titulo' => 'Productos', 'color' => 'success', 'icono' => 'fa-solid fa-box'],
    ['clave' => 'categorias', 'titulo' => 'Categorías', 'color' => 'warning', 'icono' => 'fa-solid fa-layer-group'],
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Administrador Bodega Maribel</title>
    <script src="https://kit.fontawesome.com/73c70fe811.js" crossorigin="anonymous"></script>
    <link rel="icon" href="<?= htmlspecialchars($buildUrl('vista/imagenes/principal/makro.ico'), ENT_QUOTES, 'UTF-8') ?>" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/css/reloj.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= htmlspecialchars($buildUrl('index.php?ruta=admin/dashboard'), ENT_QUOTES, 'UTF-8') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-solid fa-warehouse"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Maribel Mayorista<sup> Admin</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="<?= htmlspecialchars($buildUrl('index.php?ruta=admin/dashboard'), ENT_QUOTES, 'UTF-8') ?>">
                    <i class="fa-solid fa-house"></i>
                    <span>Inicio</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading text-white">Gestión de Usuarios</div>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_admin.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-key"></i> <span>Administradores</span></a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_colaborador.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-user"></i> <span>Colaboradores</span></a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/registrar_usuarios.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-user-plus"></i> <span>Registrar usuarios</span></a></li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading text-white">Inventario</div>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_producto.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-box"></i> <span>Productos</span></a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_checkList.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-list-check"></i> <span>Check List</span></a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_categoria.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-layer-group"></i> <span>Categorías</span></a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_guia_entrada.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-file-import"></i> <span>Guía de Entrada</span></a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_guia_salida.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-file-export"></i> <span>Guía de Salida</span></a></li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading text-white">Proveedores</div>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_provedor.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-handshake"></i> <span>Proveedores</span></a></li>

            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item">
                <a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/login/logout.php'), ENT_QUOTES, 'UTF-8') ?>">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    <span>Salir</span>
                </a>
            </li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-none d-sm-inline-block form-inline mx-auto text-center">
                        <p class="mb-0"><?= htmlspecialchars($fechaActual, ENT_QUOTES, 'UTF-8') ?><br><small>son las <?= htmlspecialchars($horaActual, ENT_QUOTES, 'UTF-8') ?></small></p>
                    </div>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrador - <?= htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8') ?></span>
                                <img class="img-profile rounded-circle" src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/img/undraw_profile.svg" alt="Perfil">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= htmlspecialchars($buildUrl('index.php?ruta=admin/dashboard'), ENT_QUOTES, 'UTF-8') ?>"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Inicio</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= htmlspecialchars($buildUrl('vista/login/logout.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Salir</a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Bienvenido(a) <?= htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8') ?> a Bodega Maribel</h1>
                    </div>

                    <div class="row">
                        <?php foreach ($tarjetas as $tarjeta): ?>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-<?= $tarjeta['color'] ?> shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-<?= $tarjeta['color'] ?> text-uppercase mb-1">
                                                    <?= htmlspecialchars($tarjeta['titulo'], ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?= $resumen[$tarjeta['clave']] ?? 0 ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="<?= $tarjeta['icono'] ?> fa-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Productos en almacén</h6>
                                </div>
                                <div class="card-body">
                                    <div id="piechartProductos" style="height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Productos retirados</h6>
                                </div>
                                <div class="card-body">
                                    <div id="chartSalidas" style="height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Productos ingresados</h6>
                                </div>
                                <div class="card-body">
                                    <div id="chartEntradas" style="height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; <?= date('Y') ?> Bodega Maribel</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/js/sb-admin-2.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        const inventario = <?= json_encode($productosInventario, JSON_UNESCAPED_UNICODE) ?>;
        const salidas = <?= json_encode($datosSalidas, JSON_UNESCAPED_UNICODE) ?>;
        const entradas = <?= json_encode($datosEntradas, JSON_UNESCAPED_UNICODE) ?>;

        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawPieChart();
            drawMovimientoChart('chartSalidas', salidas, 'Productos Retirados por Fecha y Producto');
            drawMovimientoChart('chartEntradas', entradas, 'Productos Ingresados por Fecha y Producto');
        }

        function drawPieChart() {
            const container = document.getElementById('piechartProductos');
            if (!inventario.length) {
                container.innerHTML = '<p class="text-center text-muted">No hay datos de inventario para graficar.</p>';
                return;
            }

            const data = new google.visualization.DataTable();
            data.addColumn('string', 'Producto');
            data.addColumn('number', 'Cantidad');
            inventario.forEach(item => {
                data.addRow([item.nombre, Number(item.cantidad)]);
            });

            const chart = new google.visualization.PieChart(container);
            chart.draw(data, { title: 'Inventario actual' });
        }

        function drawMovimientoChart(containerId, datos, title) {
            const container = document.getElementById(containerId);
            if (!datos.productos.length || !datos.fechas.length) {
                container.innerHTML = '<p class="text-center text-muted">No hay movimientos suficientes para graficar.</p>';
                return;
            }

            const data = new google.visualization.DataTable();
            data.addColumn('date', 'Fecha');
            datos.productos.forEach(producto => data.addColumn('number', producto));

            datos.fechas.forEach(fecha => {
                const fila = [new Date(fecha)];
                datos.productos.forEach(producto => {
                    const valor = datos.valores[fecha] && datos.valores[fecha][producto]
                        ? Number(datos.valores[fecha][producto])
                        : 0;
                    fila.push(valor);
                });
                data.addRow(fila);
            });

            const chart = new google.visualization.ColumnChart(container);
            chart.draw(data, {
                title,
                isStacked: true,
                legend: { position: 'top' }
            });
        }
    </script>
</body>

</html>
