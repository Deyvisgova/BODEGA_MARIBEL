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

    <!-- Custom fonts for this template-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css?asd" rel="stylesheet">
    <link href="css/reloj.css" rel="stylesheet">

</head>
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
        <?php
        include '../../../controlador/controlador_tablas/controlador_tabla_provedor.php';
        $select = "SELECT * FROM provedor";
        $tabla = mysqli_query($conn, $select);
        ?>
        <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; text-align: center; font-weight: 600;">TABLA PROVEDOR</h3>
        <hr>

        <form action="../../../controlador/controlador_tablas/controlador_tabla_provedor.php" method="post">

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">provedor</h1>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="">id provedor:</label>
                                    <input type="text" class="form-control" name="id_provedor" id="id_provedor" value="<?php echo $id_provedor; ?>" readonly><br>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="">Nombre de la empresa:</label>
                                    <input type="text" class="form-control" name="Nombre_de_la_empresa" id="Nombre_de_la_empresa" value="<?php echo $Nombre_de_la_empresa; ?>"><br>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">ruc:</label>
                                    <input type="text" class="form-control" required name="ruc" id="ruc" value="<?php echo $ruc; ?>"><br>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="">Persona de Contacto:</label>
                                    <input type="text" class="form-control" required name="Persona_de_Contacto" id="Persona_de_Contacto" value="<?php echo $Persona_de_Contacto; ?>"><br>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Numero:</label>
                                    <input type="text" class="form-control" required name="Numero_de_contacto" id="Numero_de_contacto" value="<?php echo $Numero_de_contacto; ?>"><br>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="">Correo electronico:</label>
                                    <input type="text" class="form-control" required name="correo_electronico" id="correo_electronico" value="<?php echo $correo_electronico; ?>"><br>
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

            <!-- Button trigger modal -->
            <div class="row">
                <div class="col-12 col-sm-3 d-flex justify-content-sm-end mb-4">
                    <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fa-solid fa-plus fa-xl" style="padding: 5px 3px; font-family: Verdana, Geneva, Tahoma, sans-serif;"></i>&nbsp;<b>Agregar registro </b>
                    </button>
                </div>

                <div class="col-12 col-sm-9 d-flex justify-content-sm-end mb-4">
                    <a href="pdfs/pdf_provedores.php" class="btn btn-danger btn-sm shadow-sm" style="padding: 8px 15px; font-family: Verdana, Geneva, Tahoma, sans-serif;">
                        <i class="fa-solid fa-file-pdf fa-xl"></i> <b>Generar Reporte</b>
                    </a>
                </div>
            </div>
        </form>

        <div class="row1" style="font-size: 11px; border-radius: 10px; overflow-x: auto; max-width: 100%;"> <!-- ESTE STYLE HACE RESPONSIVE LA TABLA -->
            <table class="table table_id">
                <thead class="table-dark">
                    <tr>
                        <th>id provedor:</th>
                        <th>Nombre de la empresa:</th>
                        <th>Ruc:</th>
                        <th>Persona de Contacto:</th>
                        <th>Numero de contacto:</th>
                        <th>Correo Electronico:</th>
                        <th>Acciones:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($tabla)) { ?>
                        <tr>
                            <td><?php echo $row['id_provedor']; ?></td>
                            <td><?php echo $row['Nombre_de_la_empresa']; ?></td>
                            <td><?php echo $row['ruc']; ?></td>
                            <td><?php echo $row['Persona_de_Contacto']; ?></td>
                            <td><?php echo $row['Numero_de_contacto']; ?></td>
                            <td><?php echo $row['correo_electronico']; ?></td>
                            <form action="" method="post">
                                <input type="hidden" name="id_provedor" value=" <?php echo $row['id_provedor']; ?>">
                                <input type="hidden" name="Nombre_de_la_empresa" value=" <?php echo $row['Nombre_de_la_empresa']; ?>">
                                <input type="hidden" name="ruc" value=" <?php echo $row['ruc']; ?>">
                                <input type="hidden" name="Persona_de_Contacto" value=" <?php echo $row['Persona_de_Contacto']; ?>">
                                <input type="hidden" name="Numero_de_contacto" value=" <?php echo $row['Numero_de_contacto']; ?>">
                                <input type="hidden" name="correo_electronico" value=" <?php echo $row['correo_electronico']; ?>">
                                <td><input type="submit" value="Seleccionar" name="accion"></td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--CÓDIGO PARA MOSTRAR EL MODAL CUANDO SE SELECCIONA EL REGISTRO (Implementar en todas las tablas)-->
    <?php if ($mostrarModal) { ?>
        <script>
            $('#exampleModal').modal('show');
        </script>
    <?php } ?>
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