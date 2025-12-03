<?php

session_start();

if(isset($_SESSION['nombre_colab'])){
   header('location:login_form.php');
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

    <title>Colaborador Bodega Maribel</title>

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
        @include 'sidebarColaborador.php';
        @include 'navbarColaborador.php';
        ?>
    </div>
    <div class="container">
        
        <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; text-align: center; font-weight: 600;">Agregar Stock</h3>
        <hr>

        
        <section>
        <?php


// Verificar la sesión o redirigir al formulario de inicio de sesión

// Incluir archivo de configuración de la base de datos
@include '../../modelo/config.php';

// Inicializar variables
$mensaje_error = "";
$guia = [];

// Verificar si se ha enviado el formulario de búsqueda
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la guía de salida desde el formulario
    $id_guia = mysqli_real_escape_string($conn, $_POST['id_guia']);

    // Consultar la base de datos para obtener la información de la guía de salida
    $query = "SELECT * FROM guia_de_salida WHERE id_guia_salida = '$id_guia'";
    $result = mysqli_query($conn, $query);

    // Verificar si se encontraron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        $guia = mysqli_fetch_assoc($result);
    } else {
        $mensaje_error = "No se encontró la guía de salida con el ID proporcionado.";
    }
}
?>

<section>
<h2>Búsqueda de Guía de Salida</h2>

<section>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label for="id_guia">ID de Guía de Salida:</label>
                    <input type="text" name="id_guia" required>
                    <button type="submit">Buscar</button>
                    <!-- Agregar campo oculto para almacenar el valor del ID -->
                    <input type="hidden" name="id_guia_hidden" value="<?php echo isset($guia['id_guia_salida']) ? $guia['id_guia_salida'] : ''; ?>">
                </form>

                <?php if ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
                    <?php if ($mensaje_error != "") : ?>
                        <p><?php echo $mensaje_error; ?></p>
                    <?php elseif (!empty($guia)) : ?>
                        <!-- Resto del código... -->
                    <?php endif; ?>
                <?php endif; ?>
            </section>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
    <?php if ($mensaje_error != "") : ?>
        <p><?php echo $mensaje_error; ?></p>
    <?php elseif (!empty($guia)) : ?>
        <table class="table table_id">
        <thead class="table-dark">
        <tr>
                         <th>Id Guia de Salida:</th>
                        <th>Fecha:</th>
                        <th>Descripcion</th>
                        <th>Cantidad:</th>
                        <th>Producto:</th>
                        <th>Destino:</th>
                        <th>Encargado:</th>
                        <th>Activo:</th>
            </tr>
            </thead>

            <tr>
                            <td><?php echo $guia['id_guia_salida']; ?></td>
                            <td><?php echo $guia['fecha_salida']; ?></td>
                            <td><?php echo $guia['descripcion']; ?></td>
                            <td><?php echo $guia['cantidad_salida']; ?></td>
                            <td><?php echo $guia['producto']; ?></td>
                            <td><?php echo $guia['destino']; ?></td>
                            <td><?php echo $guia['encargado']; ?></td>
                            <td><?php echo $guia['activo']; ?></td>
                
            </tr>
        </table>
        <div class="row">
        <div class="col-12 col-sm-6 mb-4">
            <form action="../../../controlador/controlador_tablas/controlador_tabla_salida_colab.php" method="POST">
                <input type="hidden" name="id_guia" value="<?php echo $guia['id_guia_salida']; ?>">
                <button type="submit" class="btn btn-success">Cambiar Estado a Entregado</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>
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