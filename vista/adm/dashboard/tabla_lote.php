<?php
session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:index.php');
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/reloj.css" rel="sytlesheet">
</head>

<script>
    function confirmacion() {
        return confirm("¿Desea ELIMINAR el registro?");
    }

    function confirmacionM() {
        return confirm("¿Desea MODIFICAR el registro?");
    }
</script>

<body id="page-top">
    <div id="wrapper">
        <?php
        @include 'sidebar.php';
        @include 'navbar.php';
        ?>
    </div>
    <div class="container">
        <?php
        @include '../../../controlador/controlador_tablas/controlador_tabla_lote.php';
        $select = "SELECT l.id_lote, l.id_producto, l.cantidad_recibida, l.fecha_vencimiento, l.fecha_ingreso, p.nombre_producto FROM lote l INNER JOIN producto p ON p.id_producto = l.id_producto";
        $tabla = mysqli_query($conn, $select);

        $productos = mysqli_query($conn, "SELECT id_producto, nombre_producto FROM producto WHERE activo = 'activo' ORDER BY nombre_producto");
        ?>
        <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; text-align: center; font-weight: 600;">TABLA LOTES</h3>
        <hr>

        <form action="../../../controlador/controlador_tablas/controlador_tabla_lote.php" method="post">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Lote</h1>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>ID Lote:</label>
                                    <input type="text" class="form-control" required name="id_lote" placerholder="" id="id_lote" value="<?php echo $id_lote; ?>" readonly><br>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="">Producto:</label>
                                    <select name="id_producto" id="id_producto" class="form-control" required>
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($productos as $producto): ?>
                                            <option value="<?php echo $producto['id_producto']; ?>" <?php echo ($producto['id_producto'] == $id_producto) ? 'selected' : ''; ?>><?php echo $producto['nombre_producto']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Cantidad recibida:</label>
                                    <input type="number" class="form-control" required name="cantidad_recibida" min="0" id="cantidad_recibida" value="<?php echo $cantidad_recibida; ?>"><br>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Fecha de ingreso:</label>
                                    <input type="date" class="form-control" required name="fecha_ingreso" id="fecha_ingreso" value="<?php echo $fecha_ingreso; ?>"><br>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Fecha de vencimiento:</label>
                                    <input type="date" class="form-control" required name="fecha_vencimiento" id="fecha_vencimiento" value="<?php echo $fecha_vencimiento; ?>"><br>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">

                            <button value="btnAgregar" <?php echo $accionAgregar; ?> class="btn btn-success" type="submit" name="accion">Agregar</button>

                            <button value="btnModificar" <?php echo $accionModificar; ?> class="btn btn-warning" type="submit" name="accion" onclick='return confirmacionM()'>Modificar</button>

                            <button value="btnEliminar" <?php echo $accionEliminar; ?> class="btn btn-danger" type="submit" name="accion" onclick='return confirmacion()'>Eliminar</button>

                            <button value="btnCancelar" <?php echo $accionCancelar; ?> class="btn btn-primary" type="submit" name="accion">Cancelar</button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-3 d-flex justify-content-sm-end mb-4">
                    <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fa-solid fa-plus fa-xl" style="padding: 5px 3px; font-family: Verdana, Geneva, Tahoma, sans-serif;"></i>&nbsp;<b>Agregar registro </b>
                    </button>
                </div>
            </div>
        </form>

        <div class="row-prod" style="font-size: 11px; border-radius: 10px; overflow-x: auto; max-width: 100%;">
            <table class="table table_id">
                <thead class="table-dark">
                    <tr>
                        <th>ID Lote</th>
                        <th>Producto</th>
                        <th>Cantidad recibida</th>
                        <th>Fecha ingreso</th>
                        <th>Fecha vencimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($tabla)) { ?>
                        <tr>
                            <td><?php echo $row['id_lote']; ?></td>
                            <td><?php echo $row['nombre_producto']; ?></td>
                            <td><?php echo $row['cantidad_recibida']; ?></td>
                            <td><?php echo $row['fecha_ingreso']; ?></td>
                            <td><?php echo $row['fecha_vencimiento']; ?></td>

                            <form action="" method="POST">
                                <input type="hidden" value="<?php echo $row['id_lote']; ?>" name="id_lote">
                                <input type="hidden" value="<?php echo $row['id_producto']; ?>" name="id_producto">
                                <input type="hidden" value="<?php echo $row['cantidad_recibida']; ?>" name="cantidad_recibida">
                                <input type="hidden" value="<?php echo $row['fecha_ingreso']; ?>" name="fecha_ingreso">
                                <input type="hidden" value="<?php echo $row['fecha_vencimiento']; ?>" name="fecha_vencimiento">

                                <td><input type="submit" value="Seleccionar" name="accion"></td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php if ($mostrarModal) { ?>
            <script>
                $('#exampleModal').modal('show');
            </script>
        <?php } ?>
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
