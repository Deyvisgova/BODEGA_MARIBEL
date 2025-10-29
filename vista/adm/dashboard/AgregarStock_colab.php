<?php
session_start();

if(isset($_SESSION['nombre_colab'])){
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

    <title>Colaborador Bodea Maribel</title>

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
        <?php
        @include '../../../controlador/controlador_tablas/controlador_Agregar_stock.php';
        $select = "SELECT * FROM guia_de_entrada where activo='pendiente'";
        $tabla = mysqli_query($conn, $select);
        ?>
        <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; text-align: center; font-weight: 600;">TABLA Guias de Entrada</h3>
        <hr>

        <form action="../../../controlador/controlador_tablas/controlador_Agregar_stock.php" method="post">

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Producto</h1>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <!-- Etiquetas e dentro del formulario-->

                                <div class="form-group col-md-4">
                                    <label>Id Guia de Entrada:</label>
                                    <input type="text" class="form-control" required name="id_guia_entrada" placerholder="" id="id_guia_entrada" value="<?php echo $id_guia_entrada; ?>" readonly><br>
                                </div>

                                <div class="form-group col-md-8">
                                    <label>Fecha</label>
                                    <input type="date" class="form-control" required name="fecha_entrada" placeholder="" id="fecha_entrada" value="<?php echo $fecha_entrada; ?>" readonly>
                                    <br>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="">Descripcion:</label>
                                    <input type="text" class="form-control" required name="descripcion" placerholder="" id="descripcion" value="<?php echo $descripcion; ?>"readonly><br>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Cantidad:</label>
                                    <input type="number" class="form-control" required name="cantidad_entrada" placerholder="" id="cantidad_entrada" value="<?php echo $cantidad_entrada; ?>"readonly><br>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="">Producto:</label>
                                    <input type="text" class="form-control" required name="producto" placerholder="" id="producto" value="<?php echo $producto; ?>"readonly><br>
                                </div>


                                <div class="form-group col-md-8">
                                    <label for="">Provedor:
                                    <select name="provedor" id="provedor" class="form-control" readonly>
                                        <?php 
                                        include 'config.php';
                                        $consulta="SELECT * from provedor";
                                        $ejecutar=mysqli_query($conn,$consulta);
                                        ?>
                                     <?php 
                                        foreach ($ejecutar as $opciones):
                                        ?>
                                    <option value="<?php echo $opciones['Nombre_de_la_empresa']?>"><?php echo $opciones['Nombre_de_la_empresa']?></option>
						      	
                                    <?php 
                                        endforeach
                                        ?>
                                 </select></label>
                                </div>

                                

                                <div class="form-group col-md-8">
                                    <label for="">Activo:</label>
                                    <select name="activo" id="activo" class="form-control">
                                        <option value="<?php echo $activo; ?>"><?php echo $activo; ?></option>
                                        <option value="pendiente">pendiente</option>
                                        <option value="recibido">Recibido</option>
                                    </select><br><br>
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
                    <a href="pdfs/pdf_productos.php" class="btn btn-danger btn-sm shadow-sm" style="padding: 8px 15px; font-family: Verdana, Geneva, Tahoma, sans-serif;">
                        <i class="fa-solid fa-file-pdf fa-xl"></i> <b>Generar Reporte</b>
                    </a>
                </div>
            </div>
        </form>

        <div class="row-prod" style="font-size: 11px; border-radius: 10px; overflow-x: auto; max-width: 100%;"> <!-- ESTE STYLE HACE RESPONSIVE LA TABLA -->
            <table class="table table_id">
                <thead class="table-dark">
                    <tr>
                        <th>Id Guia de Entrada:</th>
                        <th>Fecha:</th>
                        <th>Descripcion</th>
                        <th>Cantidad:</th>
                        <th>Producto:</th>
                        <th>provedor:</th>
                        <th>Activo:</th>
                        <th>Acciones:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($tabla)) {
                    ?>
                        <tr>
                            <td><?php echo $row['id_guia_entrada']; ?></td>
                            <td><?php echo $row['fecha_entrada']; ?></td>
                            <td><?php echo $row['descripcion']; ?></td>
                            <td><?php echo $row['cantidad_entrada']; ?></td>
                            <td><?php echo $row['producto']; ?></td>
                            <td><?php echo $row['provedor']; ?></td>
                            <td><?php echo $row['activo']; ?></td>


                           

                            <form action="" method="POST">
                                <input type="hidden" value="<?php echo $row['id_guia_entrada']; ?>" name="id_guia_entrada">
                                <input type="hidden" value="<?php echo $row['fecha_entrada']; ?>" name="fecha_entrada">
                                <input type="hidden" value="<?php echo $row['descripcion']; ?>" name="descripcion">
                                <input type="hidden" value="<?php echo $row['cantidad_entrada']; ?>" name="cantidad_entrada">
                                <input type="hidden" value="<?php echo $row['producto']; ?>" name="producto">
                                <input type="hidden" value="<?php echo $row['provedor']; ?>" name="provedor">
                                <input type="hidden" value="<?php echo $row['activo']; ?>" name="activo">


                                
                                <td><input type="submit" value="Seleccionar" name="accion"></td>
                        
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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