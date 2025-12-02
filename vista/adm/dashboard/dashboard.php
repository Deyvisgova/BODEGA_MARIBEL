<?php
/** @var string $adminName */
/** @var string $fechaActual */
/** @var string $horaActual */
/** @var array $resumen */
/** @var array $productosInventario */
/** @var array $datosSalidas */
/** @var array $datosEntradas */
/** @var array $alertas */

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($resumen, $productosInventario, $datosSalidas, $datosEntradas, $alertas)) {
    require_once __DIR__ . '/../../../modelo/AdminModel.php';

    $modelo = new AdminModel();
    $resumen = $resumen ?? $modelo->obtenerResumenTablas();
    $productosInventario = $productosInventario ?? $modelo->obtenerProductosInventario();
    $datosSalidas = $datosSalidas ?? $modelo->obtenerSalidasPorFecha();
    $datosEntradas = $datosEntradas ?? $modelo->obtenerEntradasPorFecha();
    $alertas = $alertas ?? $modelo->obtenerAlertas();

    $fecha = new DateTime('now', new DateTimeZone('America/Lima'));
    $fechaActual = $fechaActual ?? $fecha->format('d/m/Y');
    $horaActual = $horaActual ?? $fecha->format('H:i');
}

if (!isset($adminName) && isset($_SESSION['admin_name'])) {
    $adminName = $_SESSION['admin_name'];
}

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
$alertas = $alertas ?? ['bajoStock' => [], 'vencimientos' => []];
$tarjetas = [
    ['clave' => 'productos', 'titulo' => 'Productos activos', 'color' => 'success', 'icono' => 'fa-solid fa-box-open'],
    ['clave' => 'categorias', 'titulo' => 'Categorías', 'color' => 'primary', 'icono' => 'fa-solid fa-layer-group'],
    ['clave' => 'proveedores', 'titulo' => 'Proveedores', 'color' => 'info', 'icono' => 'fa-solid fa-truck-field'],
];
$alertasInventario = [
    ['titulo' => 'Stock en alerta', 'cantidad' => count($alertas['bajoStock']), 'color' => 'warning', 'icono' => 'fa-solid fa-circle-exclamation'],
    ['titulo' => 'Vencimientos próximos', 'cantidad' => count($alertas['vencimientos']), 'color' => 'danger', 'icono' => 'fa-solid fa-triangle-exclamation'],
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
                    <i class="fa-solid fa-clipboard-list"></i>
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

            <hr class="sidebar-divider">
            <div class="sidebar-heading text-white">Inventario</div>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_producto.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-box"></i> <span>Productos</span></a></li>
            <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_lote.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-boxes-stacked"></i> <span>Lotes</span></a></li>
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
                        <p class="mb-0 font-weight-bold text-gray-700">Panel de inventario</p>
                        <small class="text-muted">Actualizado <?= htmlspecialchars($fechaActual, ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($horaActual, ENT_QUOTES, 'UTF-8') ?></small>
                    </div>

                    <ul class="navbar-nav ml-auto">
                        <?php $totalAlertas = count($alertas['bajoStock']) + count($alertas['vencimientos']); ?>
                        <li class="nav-item dropdown no-arrow mx-2">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-bell"></i>
                                <?php if ($totalAlertas > 0): ?>
                                    <span class="badge badge-danger badge-counter"><?= $totalAlertas ?></span>
                                <?php endif; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown" style="min-width: 320px;">
                                <h6 class="dropdown-header">Alertas de inventario</h6>
                                <?php if (!$totalAlertas): ?>
                                    <span class="dropdown-item text-muted">No hay alertas pendientes.</span>
                                <?php endif; ?>
                                <?php foreach ($alertas['bajoStock'] as $producto): ?>
                                    <div class="dropdown-item d-flex align-items-center">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-warning">
                                                <i class="fa-solid fa-box-open text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">Stock bajo</div>
                                            <span class="font-weight-bold"><?= htmlspecialchars($producto['nombre_producto'], ENT_QUOTES, 'UTF-8') ?></span>
                                            <div class="text-muted">Disponible: <?= (int) $producto['stock_actual'] ?> uds.</div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php foreach ($alertas['vencimientos'] as $lote): ?>
                                    <div class="dropdown-item d-flex align-items-center">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-danger">
                                                <i class="fa-solid fa-triangle-exclamation text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">Vence <?= htmlspecialchars($lote['fecha_vencimiento'], ENT_QUOTES, 'UTF-8') ?></div>
                                            <span class="font-weight-bold">Lote #<?= (int) $lote['id_lote'] ?> - <?= htmlspecialchars($lote['nombre_producto'], ENT_QUOTES, 'UTF-8') ?></span>
                                            <div class="text-muted">Ingresó: <?= htmlspecialchars($lote['fecha_ingreso'], ENT_QUOTES, 'UTF-8') ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrador - <?= htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8') ?></span>
                                <div class="icon-circle bg-gradient-danger text-white">
                                    <i class="fa-solid fa-boxes-stacked"></i>
                                </div>
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
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">Hola, <?= htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8') ?></h1>
                            <p class="text-muted mb-0">Monitorea el inventario en tiempo real con gráficos interactivos.</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <?php foreach ($tarjetas as $tarjeta): ?>
                            <div class="col-xl-4 col-md-6 mb-3">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-xs font-weight-bold text-uppercase text-<?= $tarjeta['color'] ?> mb-1">
                                                <?= htmlspecialchars($tarjeta['titulo'], ENT_QUOTES, 'UTF-8') ?>
                                            </div>
                                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                                <?= $resumen[$tarjeta['clave']] ?? 0 ?>
                                            </div>
                                        </div>
                                        <div class="icon-circle bg-gradient-<?= $tarjeta['color'] ?> text-white">
                                            <i class="<?= $tarjeta['icono'] ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php foreach ($alertasInventario as $alerta): ?>
                            <div class="col-xl-3 col-md-6 mb-3">
                                <div class="card shadow-sm border-0 h-100 bg-light">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-xs font-weight-bold text-uppercase text-<?= $alerta['color'] ?> mb-1">
                                                <?= htmlspecialchars($alerta['titulo'], ENT_QUOTES, 'UTF-8') ?>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= $alerta['cantidad'] ?> alerta(s)
                                            </div>
                                        </div>
                                        <div class="icon-circle bg-<?= $alerta['color'] ?> text-white">
                                            <i class="<?= $alerta['icono'] ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow border-0 h-100">
                                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Distribución de inventario</h6>
                                    <span class="badge badge-light">Pastel</span>
                                </div>
                                <div class="card-body">
                                    <canvas id="stockChart" height="260"></canvas>
                                    <p class="text-muted small mt-3 mb-0">Se muestra la participación de cada producto sobre el stock disponible.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card shadow border-0 h-100">
                                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Entradas vs salidas</h6>
                                    <span class="badge badge-light">Barras</span>
                                </div>
                                <div class="card-body">
                                    <canvas id="flujoChart" height="260"></canvas>
                                    <p class="text-muted small mt-3 mb-0">Comparativo por fecha de los movimientos registrados.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow border-0 h-100">
                                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Rotación por producto</h6>
                                    <span class="badge badge-light">Apilado</span>
                                </div>
                                <div class="card-body">
                                    <canvas id="productoChart" height="260"></canvas>
                                    <p class="text-muted small mt-3 mb-0">Acumulado de entradas y salidas por cada producto.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-4">
                            <div class="card shadow border-0 h-100">
                                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Alertas recientes</h6>
                                    <span class="badge badge-danger">Live</span>
                                </div>
                                <div class="card-body">
                                    <?php if (!$totalAlertas): ?>
                                        <p class="text-muted mb-0">No hay alertas. Todo está bajo control.</p>
                                    <?php endif; ?>

                                    <?php foreach ($alertas['bajoStock'] as $producto): ?>
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="icon-circle bg-warning text-white mr-3">
                                                <i class="fa-solid fa-box-open"></i>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark"><?= htmlspecialchars($producto['nombre_producto'], ENT_QUOTES, 'UTF-8') ?></div>
                                                <div class="text-muted small">Stock disponible: <?= (int) $producto['stock_actual'] ?> uds.</div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <?php foreach ($alertas['vencimientos'] as $lote): ?>
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="icon-circle bg-danger text-white mr-3">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark">Lote #<?= (int) $lote['id_lote'] ?> - <?= htmlspecialchars($lote['nombre_producto'], ENT_QUOTES, 'UTF-8') ?></div>
                                                <div class="text-muted small">Vence el <?= htmlspecialchars($lote['fecha_vencimiento'], ENT_QUOTES, 'UTF-8') ?> | Ingreso: <?= htmlspecialchars($lote['fecha_ingreso'], ENT_QUOTES, 'UTF-8') ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const inventario = <?= json_encode($productosInventario, JSON_UNESCAPED_UNICODE) ?> || [];
        const salidas = <?= json_encode($datosSalidas, JSON_UNESCAPED_UNICODE) ?> || { productos: [], fechas: [], valores: {} };
        const entradas = <?= json_encode($datosEntradas, JSON_UNESCAPED_UNICODE) ?> || { productos: [], fechas: [], valores: {} };

        const coloresBase = ['#6366F1', '#14B8A6', '#F59E0B', '#EF4444', '#0EA5E9', '#8B5CF6', '#10B981', '#F97316'];

        function crearPastelStock() {
            const ctx = document.getElementById('stockChart');
            if (!ctx) return;

            if (!inventario.length) {
                ctx.outerHTML = '<p class="text-center text-muted mb-0">No hay datos de inventario para graficar.</p>';
                return;
            }

            const labels = inventario.map(item => item.nombre);
            const data = inventario.map(item => Number(item.cantidad));

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                        data,
                        backgroundColor: labels.map((_, i) => coloresBase[i % coloresBase.length]),
                        borderWidth: 0
                    }]
                },
                options: {
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: context => `${context.label}: ${context.formattedValue} uds.`
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }

        function combinarFechas() {
            const fechas = new Set([...(entradas.fechas || []), ...(salidas.fechas || [])]);
            return Array.from(fechas).sort();
        }

        function totalesPorFecha(datos, fechas) {
            return fechas.map(fecha => {
                const valores = datos.valores?.[fecha] || {};
                return Object.values(valores).reduce((suma, valor) => suma + Number(valor || 0), 0);
            });
        }

        function crearFlujoFechas() {
            const ctx = document.getElementById('flujoChart');
            if (!ctx) return;

            const fechas = combinarFechas();
            if (!fechas.length) {
                ctx.outerHTML = '<p class="text-center text-muted mb-0">Aún no hay movimientos registrados.</p>';
                return;
            }

            const datosEntradas = totalesPorFecha(entradas, fechas);
            const datosSalidas = totalesPorFecha(salidas, fechas);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fechas,
                    datasets: [
                        { label: 'Entradas', data: datosEntradas, backgroundColor: '#14B8A6' },
                        { label: 'Salidas', data: datosSalidas, backgroundColor: '#EF4444' },
                    ]
                },
                options: {
                    responsive: true,
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        x: { stacked: false },
                        y: { stacked: false, beginAtZero: true }
                    }
                }
            });
        }

        function totalesPorProducto(datos) {
            const productos = datos.productos || [];
            return productos.map(producto => {
                const total = Object.values(datos.valores || {}).reduce((suma, valoresFecha) => {
                    return suma + Number(valoresFecha[producto] || 0);
                }, 0);
                return { producto, total };
            });
        }

        function crearRotacionProducto() {
            const ctx = document.getElementById('productoChart');
            if (!ctx) return;

            const entradasProducto = totalesPorProducto(entradas);
            const salidasProducto = totalesPorProducto(salidas);
            const productos = Array.from(new Set([
                ...entradasProducto.map(item => item.producto),
                ...salidasProducto.map(item => item.producto)
            ]));

            if (!productos.length) {
                ctx.outerHTML = '<p class="text-center text-muted mb-0">No hay productos con movimientos para mostrar.</p>';
                return;
            }

            const datosEntradas = productos.map(nombre => entradasProducto.find(item => item.producto === nombre)?.total || 0);
            const datosSalidas = productos.map(nombre => salidasProducto.find(item => item.producto === nombre)?.total || 0);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: productos,
                    datasets: [
                        { label: 'Entradas acumuladas', data: datosEntradas, backgroundColor: '#0EA5E9' },
                        { label: 'Salidas acumuladas', data: datosSalidas, backgroundColor: '#F59E0B' },
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { stacked: true },
                        y: { stacked: true, beginAtZero: true }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: context => `${context.dataset.label}: ${context.parsed.y} uds.`
                            }
                        }
                    }
                }
            });
        }

        crearPastelStock();
        crearFlujoFechas();
        crearRotacionProducto();
    </script>
</body>

</html>
