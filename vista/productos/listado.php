<?php
/** @var array $productos */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Productos - Bodega Maribel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="vista/imagenes/principal/makro.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c174601175.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Asap:wght@800&family=Lobster&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200&display=swap');
    </style>
    <link href="vista/css/principal/servicios.css" type="text/css" rel="stylesheet"/>
    <link href="vista/css/principal/productos.css" type="text/css" rel="stylesheet"/>
</head>
<body>
    <div class="sticky-top">
        <nav class="navbar navbar-expand-lg bg-danger navbar-dark border-5 border-bottom border-primary">
            <div class="container-fluid">
                <a href="index.php" class="navbar-brand ms-3">
                    <img class="img-logo" src="vista/imagenes/fondo.png" width="240" alt="Logo Bodega Maribel">
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#MenuNavegacion">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="MenuNavegacion" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-3">
                        <li class="nav-item h5 ms-4"><a class="nav-link" href="index.php">Inicio</a></li>
                        <li class="nav-item h5 ms-4"><a class="nav-link" href="#nosotros">Sobre Nosotros</a></li>
                        <li class="nav-item h5 ms-4"><a class="nav-link" href="#servicios">Servicios</a></li>
                        <li class="nav-item h5 ms-4"><a class="nav-link active" href="index.php?ruta=productos">Productos</a></li>
                    </ul>
                </div>
                <ul class="navbar-nav ms-3">
                    <li class="nav-item h5 ms-5 ml-5">
                        <a class="nav-link" href="vista/login/login_form.php">
                            Iniciar sesión
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <main class="py-4">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php if (empty($productos)): ?>
                    <div class="col">
                        <div class="alert alert-info" role="alert">
                            No hay productos activos registrados en el inventario.
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="col mb-4">
                            <div class="card shadow-sm h-100">
                                <?php
                                    $idProducto = (int) $producto['id_producto'];
                                    $imagen = "vista/imagenes/productos/{$idProducto}/principal.png";
                                    if (!file_exists(__DIR__ . "/../imagenes/productos/{$idProducto}/principal.png")) {
                                        $imagen = "vista/imagenes/no-photo.jpg";
                                    }
                                ?>
                                <img src="<?php echo htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" alt="Imagen del producto">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($producto['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                    <p class="card-text text-muted mb-3"><?php echo htmlspecialchars($producto['descripcion_producto'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p class="card-text fw-bold">S/. <?php echo number_format((float) $producto['precio_producto'], 2, '.', ','); ?></p>
                                    <div class="mt-auto">
                                        <span class="badge bg-success">Disponible</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <footer class="bg-dark text-center text-white mt-5">
        <div class="container p-5">
            <section>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Horarios de Atención</h5>
                        <ul class="list-unstyled mb-0">
                            <li><span class="text-white text-decoration-none">Lunes a Sábados</span></li>
                            <li><span class="text-white text-decoration-none">08:00 - 20:00 hrs</span></li>
                            <li><span class="text-white text-decoration-none">Domingos</span></li>
                            <li><span class="text-white text-decoration-none">09:00 - 20:00 hrs</span></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Enlaces de sitio</h5>
                        <ul class="list-unstyled mb-0">
                            <li><a href="index.php" class="text-white text-decoration-none">Inicio</a></li>
                            <li><a href="vista/login/login_form.php" class="text-white text-decoration-none">Ingresar</a></li>
                            <li><a href="index.php?ruta=productos" class="text-white text-decoration-none">Productos</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Servicios</h5>
                        <ul class="list-unstyled mb-0">
                            <li><span class="text-white text-decoration-none">Recepción de mercadería</span></li>
                            <li><span class="text-white text-decoration-none">Control de inventario</span></li>
                            <li><span class="text-white text-decoration-none">Distribución a tiendas</span></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Contacto</h5>
                        <ul class="list-unstyled mb-0">
                            <li><span class="text-white text-decoration-none">+51 913 123 456</span></li>
                            <li><span class="text-white text-decoration-none">bodega.maribel@almacen.com</span></li>
                            <li><span class="text-white text-decoration-none">Av. San Martín 123, Lima</span></li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © <?php echo date('Y'); ?> Bodega Maribel - Sistema de almacén
        </div>
    </footer>
</body>
</html>
