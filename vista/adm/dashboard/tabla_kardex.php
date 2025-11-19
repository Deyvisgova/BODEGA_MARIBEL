<?php
session_start();

if(!isset($_SESSION['admin_name']) && !isset($_SESSION['colab_name'])){
   header('location:index.php');
   exit;
}

@include '../../../modelo/config.php';

$kardexQuery = mysqli_query(
    $conn,
    "SELECT id_kardex, fecha, producto, tipo, descripcion, cantidad, saldo, referencia FROM kardex ORDER BY fecha DESC, id_kardex DESC"
);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://kit.fontawesome.com/73c70fe811.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../../imagenes/principal/makro.ico" type="image/x-icon">
    <title>Administrador Bodega Maribel - Kardex</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
<div id="wrapper">
    <?php if (isset($_SESSION['admin_name'])): ?>
        <?php @include 'sidebar.php'; ?>
        <?php @include 'navbar.php'; ?>
    <?php else: ?>
        <?php @include 'sidebarColaborador.php'; ?>
        <?php @include 'navbarColaborador.php'; ?>
    <?php endif; ?>
</div>

<div class="container mb-5">
    <h3 class="text-center fw-semibold mt-4">Kardex de Movimientos</h3>
    <p class="text-center text-muted">Entradas y salidas acumuladas por producto</p>
    <div class="table-responsive" style="font-size: 12px; border-radius: 10px; overflow-x: auto; max-width: 100%;">
        <table class="table table-bordered table_id">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Saldo</th>
                    <th>Referencia</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($kardexQuery)) : ?>
                <tr>
                    <td><?php echo $row['id_kardex']; ?></td>
                    <td><?php echo $row['fecha']; ?></td>
                    <td><?php echo $row['producto']; ?></td>
                    <td class="text-capitalize"><?php echo $row['tipo']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td><?php echo $row['cantidad']; ?></td>
                    <td><?php echo $row['saldo']; ?></td>
                    <td><?php echo $row['referencia']; ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
</body>
</html>
