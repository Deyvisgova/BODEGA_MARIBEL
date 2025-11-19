<?php
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:index.php');
}

@include '../../modelo/config.php';
require_once '../../../controlador/kardex_helper.php';

$mensaje_error = "";
$mensaje_exito = "";
$productosEncontrados = [];
$nombreBuscado = '';
$productosDisponibles = [];

if ($conn) {
    $consultaProductos = mysqli_query($conn, "SELECT nombre_producto, cantidad, precio_producto, categoria, activo, provedor FROM producto ORDER BY nombre_producto");
    if ($consultaProductos) {
        while ($row = mysqli_fetch_assoc($consultaProductos)) {
            $productosDisponibles[] = $row;
        }
    }
}

if (isset($_POST['accion']) && $_POST['accion'] === 'ajustar') {
    $productoStock = mysqli_real_escape_string($conn, $_POST['producto_stock'] ?? '');
    $cantidadStock = (int)($_POST['cantidad_stock'] ?? 0);

    if ($productoStock === '' || $cantidadStock <= 0) {
        $mensaje_error = 'Selecciona un producto y una cantidad válida para agregar stock.';
    } else {
        registrarKardex(
            $conn,
            date('Y-m-d'),
            $productoStock,
            'entrada',
            $cantidadStock,
            'Ajuste de stock desde checklist',
            'CHECKLIST'
        );
        $mensaje_exito = "Se agregaron {$cantidadStock} unidades a {$productoStock}.";
    }
}

if (isset($_POST['accion']) && $_POST['accion'] === 'buscar') {
    $nombreBuscado = mysqli_real_escape_string($conn, $_POST['id_guia'] ?? '');
    if ($nombreBuscado === '') {
        $mensaje_error = 'Ingresa un nombre de producto para buscar.';
    } else {
        $query = "SELECT * FROM producto WHERE nombre_producto LIKE '%$nombreBuscado%'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $productosEncontrados[] = $row;
            }
        } else {
            $mensaje_error = "No se encontraron productos con el nombre proporcionado.";
        }
    }
}
?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://kit.fontawesome.com/73c70fe811.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../../imagenes/principal/makro.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Administrador Bodega Maribel</title>
    <link href="css/sb-admin-2.min.css?asd" rel="stylesheet">
    <link href="css/reloj.css" rel="sytlesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php
        @include 'sidebar.php';
        @include 'navbar.php';
        ?>
    </div>
    <div class="container py-4">
        <h3 class="text-center fw-bold mb-4">Checklist de stock</h3>
        <p class="text-center text-muted">Usa esta pantalla para agregar unidades a productos existentes y consultar sus datos actuales.</p>

        <?php if ($mensaje_error !== ''): ?>
            <div class="alert alert-danger"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>
        <?php if ($mensaje_exito !== ''): ?>
            <div class="alert alert-success"><?php echo $mensaje_exito; ?></div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h4 class="h5 mb-3">Agregar stock</h4>
                        <form method="POST" class="vstack gap-3">
                            <div>
                                <label class="form-label">Producto</label>
                                <input list="productosDisponibles" name="producto_stock" class="form-control" placeholder="Escribe para buscar" required>
                                <datalist id="productosDisponibles">
                                    <?php foreach ($productosDisponibles as $producto): ?>
                                        <option value="<?php echo htmlspecialchars($producto['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($producto['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div>
                                <label class="form-label">Cantidad a ingresar</label>
                                <input type="number" name="cantidad_stock" min="1" class="form-control" placeholder="Ej: 25" required>
                            </div>
                            <input type="hidden" name="accion" value="ajustar">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fa-solid fa-plus me-2"></i>Actualizar stock
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h4 class="h5 mb-3">Buscar producto</h4>
                        <form method="POST" class="row g-2 align-items-end mb-3">
                            <div class="col-sm-9">
                                <label class="form-label">Nombre del producto</label>
                                <input list="productosDisponibles" name="id_guia" class="form-control" value="<?php echo htmlspecialchars($nombreBuscado, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Ingresa un nombre" required>
                            </div>
                            <div class="col-sm-3 d-grid">
                                <input type="hidden" name="accion" value="buscar">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i>Buscar
                                </button>
                            </div>
                        </form>

                        <?php if (!empty($productosEncontrados)): ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Resultados</h5>
                                <a href="pdfs/reporte_cheklist.php?nombre_producto=<?php echo urlencode($nombreBuscado); ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                                    <i class="fa-solid fa-file-pdf me-1"></i>Reporte PDF
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Stock</th>
                                            <th>Precio</th>
                                            <th>Categoría</th>
                                            <th>Estado</th>
                                            <th>Proveedor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($productosEncontrados as $producto) : ?>
                                            <tr>
                                                <td><?php echo $producto['id_producto']; ?></td>
                                                <td><?php echo htmlspecialchars($producto['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo (int)$producto['cantidad']; ?></td>
                                                <td><?php echo number_format((float)$producto['precio_producto'], 2); ?></td>
                                                <td><?php echo htmlspecialchars($producto['categoria'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($producto['activo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($producto['provedor'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Busca un producto para ver su información y generar un reporte.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="../../js/busqueda.js"></script>
</body>
</html>
