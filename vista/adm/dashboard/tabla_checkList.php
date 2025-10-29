<?php
session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:index.php');
} 

?>
<html lang="es">
<!-- BARRA DE NAV EMPIEZA EN LA FILA 	pag 169-->
<!-- Recuperar nombre del admninitrador pag 338-->

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

    <!-- Custom fonts for this template-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css?asd" rel="stylesheet">
    <link href="css/reloj.css" rel="sytlesheet">

</head>

<!--FUNCIÓN DE MENSAJE DE CONFIRMACIÓN PARA LA EMLIMINACIÓN DE REGISTROS-->
<script>
    function confirmacion() {
        var respuesta = confirm("¿Desea ELIMINAR el registro?");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
    }

    function confirmacionM() {
        var res = confirm("¿Desea MODIFICAR el registro?");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
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
        <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; text-align: center; font-weight: 600;">Agregar Stock</h3>
        <hr>

        <section>
            <?php
            // Incluir archivo de configuración de la base de datos
            @include '../../modelo/config.php';

            // Inicializar variables
            $mensaje_error = "";
            $productos = [];

            // Verificar si se ha enviado el formulario de búsqueda
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtener el nombre del producto desde el formulario
                $nombre_producto = mysqli_real_escape_string($conn, $_POST['id_guia']);

                // Consultar la base de datos para obtener la información de los productos
                $query = "SELECT * FROM producto WHERE nombre_producto LIKE '%$nombre_producto%'";
                $result = mysqli_query($conn, $query);

                // Verificar si se encontraron resultados
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $productos[] = $row;
                    }
                } else {
                    $mensaje_error = "No se encontraron productos con el nombre proporcionado.";
                }
            }
            ?>

            <section>
                <h2>Búsqueda de Producto</h2>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <label for="id_guia">Nombre del Producto:</label>
    <input type="text" name="id_guia" required>
    <button type="submit">Buscar</button>
</form>

                <?php if ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
                    <?php if ($mensaje_error != "") : ?>
                        <p><?php echo $mensaje_error; ?></p>
                    <?php elseif (!empty($productos)) : ?>
                        <a href="pdfs/reporte_cheklist.php?nombre_producto=<?php echo urlencode($nombre_producto); ?>" target="_blank">Generar Reporte PDF</a>
                        <table class="table table_id">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID:</th>
                                    <th>Nombre:</th>
                                    <th>Cantidad:</th>
                                    <th>Precio:</th>
                                    <th>Categoría:</th>
                                    <th>Activo:</th>
                                    <th>Proveedor:</th>
                                    <th>Acciones:</th>
                                </tr>
                            </thead>

                            <?php foreach ($productos as $producto) : ?>
                                <tr>
                                    <td><?php echo $producto['id_producto']; ?></td>
                                    <td><?php echo $producto['nombre_producto']; ?></td>
                                    <td><?php echo $producto['cantidad']; ?></td>
                                    <td><?php echo $producto['precio_producto']; ?></td>
                                    <td><?php echo $producto['categoria']; ?></td>
                                    <td><?php echo $producto['activo']; ?></td>
                                    <td><?php echo $producto['provedor']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                <?php endif; ?>
            </section>
        </section>


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