<?php
/** @var array $categorias */
/** @var array $productosDestacados */
/** @var array $resumenInventario */
/** @var array $servicios */
/** @var array $horarios */
/** @var array $contacto */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Bodega Maribel - Gestión de almacén</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="vista/imagenes/principal/makro.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/73c70fe811.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="vista/css/base.css">
    <link rel="stylesheet" href="vista/css/home.css">
</head>
<body>
    <div class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-dark bg-danger border-bottom border-4 border-warning">
            <div class="container-fluid">
                <a href="index.php" class="navbar-brand d-flex align-items-center gap-2">
                    <img src="vista/imagenes/fondo.png" alt="Bodega Maribel" class="img-logo" width="160" />
                    <span class="fw-semibold d-none d-sm-inline">Bodega Maribel</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Abrir menú">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">
                                <i class="fa-solid fa-house"></i>
                                <span class="ms-1">Inicio</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?ruta=productos">
                                <i class="fa-solid fa-cubes"></i>
                                <span class="ms-1">Productos</span>
                            </a>
                        </li>
                        <?php if (!empty($categorias)): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="ddCategorias" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-list"></i>
                                    <span class="ms-1">Categorías</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="ddCategorias">
                                    <?php foreach ($categorias as $categoria): ?>
                                        <li>
                                            <span class="dropdown-item d-flex justify-content-between">
                                                <?php echo htmlspecialchars($categoria['categoria'], ENT_QUOTES, 'UTF-8'); ?>
                                                <span class="badge bg-danger rounded-pill"><?php echo (int) $categoria['total_productos']; ?></span>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <a class="btn btn-outline-light" href="vista/login/login_form.php">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>Ingresar
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <main class="container my-5">
        <section class="hero p-5 mb-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <p class="text-uppercase fw-bold mb-2 text-warning">Bodega Maribel</p>
                    <h1 class="display-5 fw-bold mb-3">Un panel moderno para controlar entradas y salidas</h1>
                    <p class="lead">Gestiona productos, actualiza stock y genera guías en segundos. Todo queda centralizado para que el equipo trabaje con datos confiables.</p>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="vista/login/login_form.php" class="btn btn-light btn-lg text-danger fw-semibold">
                            <i class="fa-solid fa-user-shield me-2"></i>Acceso Admin
                        </a>
                        <a href="#productos" class="btn btn-outline-light btn-lg">
                            <i class="fa-solid fa-boxes-stacked me-2"></i>Explorar inventario
                        </a>
                    </div>
                    <div class="row row-cols-1 row-cols-md-3 g-3 mt-4">
                        <div class="col">
                            <div class="pill-card">
                                <p class="text-uppercase small mb-1">SKU activos</p>
                                <p class="h3 fw-bold mb-0"><?php echo (int) $resumenInventario['total_productos']; ?></p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="pill-card">
                                <p class="text-uppercase small mb-1">Unidades</p>
                                <p class="h3 fw-bold mb-0"><?php echo number_format((int) $resumenInventario['total_unidades']); ?></p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="pill-card">
                                <p class="text-uppercase small mb-1">Valor</p>
                                <p class="h3 fw-bold mb-0">S/ <?php echo number_format((float) $resumenInventario['valor_estimado'], 2); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="panel shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <p class="text-uppercase text-muted small mb-1">Checklist inteligente</p>
                                <h2 class="h4 mb-0">Actualiza stock en equipo</h2>
                            </div>
                            <span class="badge bg-success rounded-pill">Nuevo</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-circle-check text-success me-2"></i>
                                <span>Agrega productos sin definir stock inicial</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-circle-check text-success me-2"></i>
                                <span>Registra varias líneas en una misma guía</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="fa-solid fa-circle-check text-success me-2"></i>
                                <span>Restas y sumas automáticas en el kardex</span>
                            </li>
                        </ul>
                        <div class="d-grid gap-2">
                            <a href="vista/login/login_form.php" class="btn btn-danger">
                                <i class="fa-solid fa-clipboard-list me-2"></i>Ir al panel de guías
                            </a>
                            <a href="index.php?ruta=productos" class="btn btn-outline-secondary">Ver catálogo completo</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5" id="servicios">
            <p class="section-title">Servicios logísticos</p>
            <h2 class="h3 mb-4">Acompañamos cada etapa de la cadena</h2>
            <div class="row g-4">
                <?php foreach ($servicios as $servicio): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card border-0 bg-light p-4 h-100">
                            <i class="fa-solid fa-check-double text-danger mb-3 fa-2x"></i>
                            <p class="mb-0 fw-semibold"><?php echo htmlspecialchars($servicio, ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="mb-5">
            <p class="section-title">Acciones rápidas</p>
            <h2 class="h3 mb-4">Lo esencial en un vistazo</h2>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="panel h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3 class="h6 mb-0">Guías de entrada</h3>
                            <span class="badge bg-light text-danger">Sumar stock</span>
                        </div>
                        <p class="text-muted small">Carga múltiples productos y registra el proveedor en segundos.</p>
                        <div class="d-grid">
                            <a class="btn btn-outline-danger" href="vista/login/login_form.php">Crear guía</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3 class="h6 mb-0">Guías de salida</h3>
                            <span class="badge bg-light text-success">Despacho</span>
                        </div>
                        <p class="text-muted small">Selecciona productos, cantidades y destinatarios en una sola vista.</p>
                        <div class="d-grid">
                            <a class="btn btn-outline-danger" href="vista/login/login_form.php">Despachar ahora</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3 class="h6 mb-0">Checklist</h3>
                            <span class="badge bg-light text-primary">Stock</span>
                        </div>
                        <p class="text-muted small">Agrega unidades a tus productos y genera reportes de control.</p>
                        <div class="d-grid">
                            <a class="btn btn-outline-danger" href="vista/login/login_form.php">Abrir checklist</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5" id="productos">
            <p class="section-title">Inventario destacado</p>
            <h2 class="h3 mb-4">Productos con mayor rotación</h2>
            <div class="row g-4">
                <?php foreach ($productosDestacados as $producto): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <?php
                                $idProducto = (int) $producto['id_producto'];
                                $imagen = "vista/imagenes/productos/{$idProducto}/principal.png";
                                if (!file_exists(__DIR__ . "/../imagenes/productos/{$idProducto}/principal.png")) {
                                    $imagen = "vista/imagenes/no-photo.jpg";
                                }
                            ?>
                            <img src="<?php echo htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" alt="Imagen del producto">
                            <div class="card-body">
                                <span class="badge bg-danger mb-2"><?php echo htmlspecialchars(trim($producto['categoria']), ENT_QUOTES, 'UTF-8'); ?></span>
                                <h3 class="h5"><?php echo htmlspecialchars($producto['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="text-muted mb-1">Stock: <?php echo (int) $producto['cantidad']; ?> unidades</p>
                                <p class="fw-bold mb-0">S/. <?php echo number_format((float) $producto['precio_producto'], 2); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-4">
                <a href="index.php?ruta=productos" class="btn btn-danger btn-lg">Explorar catálogo completo</a>
            </div>
        </section>

        <section class="mb-5">
            <p class="section-title">Categorías principales</p>
            <h2 class="h3 mb-4">Organiza la bodega por familias</h2>
            <div class="row g-4">
                <?php foreach ($categorias as $categoria): ?>
                    <div class="col-md-4">
                        <div class="stat-card border-0 bg-white p-4 h-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="h5 mb-1"><?php echo htmlspecialchars($categoria['categoria'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p class="text-muted mb-0"><?php echo (int) $categoria['total_unidades']; ?> unidades</p>
                                </div>
                                <span class="badge bg-danger rounded-pill fs-6"><?php echo (int) $categoria['total_productos']; ?> SKU</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="mb-5" id="contacto">
            <p class="section-title">Atención y soporte</p>
            <h2 class="h3 mb-4">Coordinemos tu próxima entrega</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="stat-card p-4 h-100">
                        <h3 class="h5 fw-semibold mb-3">Horarios</h3>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($horarios as $dia => $rango): ?>
                                <li class="d-flex justify-content-between py-1 border-bottom">
                                    <span><?php echo htmlspecialchars($dia, ENT_QUOTES, 'UTF-8'); ?></span>
                                    <span class="fw-semibold"><?php echo htmlspecialchars($rango, ENT_QUOTES, 'UTF-8'); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card p-4 h-100">
                        <h3 class="h5 fw-semibold mb-3">Contacto</h3>
                        <p class="mb-2"><i class="fa-solid fa-phone me-2 text-danger"></i><?php echo htmlspecialchars($contacto['telefono'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="mb-2"><i class="fa-solid fa-envelope me-2 text-danger"></i><?php echo htmlspecialchars($contacto['correo'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="mb-0"><i class="fa-solid fa-location-dot me-2 text-danger"></i><?php echo htmlspecialchars($contacto['direccion'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-1">&copy; <?php echo date('Y'); ?> Bodega Maribel</p>
        <small>Sistema de almacén y distribución</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
