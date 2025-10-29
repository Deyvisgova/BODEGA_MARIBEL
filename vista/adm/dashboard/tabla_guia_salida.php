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
        <?php
        @include '../../../controlador/controlador_tablas/controlador_tabla_guia_salida.php';
        $select = "SELECT * FROM guia_de_salida";
        $tabla = mysqli_query($conn, $select);
        ?>
        <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; text-align: center; font-weight: 600;">TABLA Guias de Salida</h3>
        <hr>

        <form action="../../../controlador/controlador_tablas/controlador_tabla_guia_salida.php" method="post">

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
                                    <label>Id Guia de Salida:</label>
                                    <input type="text" class="form-control" required name="id_guia_salida" placerholder="" id="id_guia_salida" value="<?php echo $id_guia_salida; ?>" readonly><br>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Fecha</label>
                                    <input type="date" class="form-control" required name="fecha_salida" placeholder="" id="fecha_salida" value="<?php echo $fecha_salida; ?>">
                                    <br>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="">Descripcion:</label>
                                    <input type="text" class="form-control" required name="descripcion" placerholder="" id="descripcion" value="<?php echo $descripcion; ?>"><br>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Cantidad:</label>
                                    <input type="number" class="form-control" required name="cantidad_salida" placerholder="" id="cantidad_salida" value="<?php echo $cantidad_salida; ?>"><br>
                                </div>

                                

                                <div class="form-group col-md-8">
                                    <label for="">Producto:
                                    <select name="producto" id="producto" class="form-control">
                                        <?php 
                                        include 'config.php';
                                        $consulta="SELECT * from producto where cantidad>0";
                                        $ejecutar=mysqli_query($conn,$consulta);
                                        ?>
                                     <?php 
                                        foreach ($ejecutar as $opciones):
                                        ?>
                                    <option value="<?php echo $opciones['nombre_producto']?>"><?php echo $opciones['nombre_producto']?></option>
						      	
                                    <?php 
                                        endforeach
                                        ?>
                                 </select></label>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="">Destino:</label>
                                    <input type="text" class="form-control" required name="destino" placerholder="" id="destino" value="<?php echo $destino; ?>"><br>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="">Encargado:</label>
                                    <input type="text" class="form-control" required name="encargado" placerholder="" id="encargado" value="<?php echo $encargado; ?>"><br>
                                </div>
                                
                                <div class="form-group col-md-8">
                                    <label for="">Activo:</label>
                                    <select name="activo" id="activo" class="form-control">
                                        <option value="<?php echo $activo; ?>"><?php echo $activo; ?></option>
                                        <option value="pendiente">pendiente</option>
                                        <option value="Entregado">Entregado</option>
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
                    <a href="pdfs/pdf_guia_salida.php" target="_blank" class="btn btn-danger btn-sm shadow-sm" style="padding: 8px 15px; font-family: Verdana, Geneva, Tahoma, sans-serif;">
                        <i class="fa-solid fa-file-pdf fa-xl"></i> <b>Generar Reporte</b>
                    </a>
                </div>
            </div>
        </form>

        <div class="" style="font-size: 11px; border-radius: 10px; overflow-x: auto; max-width: 100%;"> <!-- ESTE STYLE HACE RESPONSIVE LA TABLA -->
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
                        <th>Acciones:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($tabla)) {
                    ?>
                        <tr>
                            <td><?php echo $row['id_guia_salida']; ?></td>
                            <td><?php echo $row['fecha_salida']; ?></td>
                            <td><?php echo $row['descripcion']; ?></td>
                            <td><?php echo $row['cantidad_salida']; ?></td>
                            <td><?php echo $row['producto']; ?></td>
                            <td><?php echo $row['destino']; ?></td>
                            <td><?php echo $row['encargado']; ?></td>
                            <td><?php echo $row['activo']; ?></td>


                           

                            <form action="" method="POST">
                                <input type="hidden" value="<?php echo $row['id_guia_salida']; ?>" name="id_guia_salida">
                                <input type="hidden" value="<?php echo $row['fecha_salida']; ?>" name="fecha_salida">
                                <input type="hidden" value="<?php echo $row['descripcion']; ?>" name="descripcion">
                                <input type="hidden" value="<?php echo $row['cantidad_salida']; ?>" name="cantidad_salida">
                                <input type="hidden" value="<?php echo $row['producto']; ?>" name="producto">
                                <input type="hidden" value="<?php echo $row['destino']; ?>" name="destino">
                                <input type="hidden" value="<?php echo $row['encargado']; ?>" name="encargado">
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

        <div>
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

<section class="reporte_uno"><style>.reporte_uno{margin-top:50px}</style>
<h4>Búsqueda de Guía de Salida</h4>

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
            <div class="row">
            <div class="col-12 col-sm-9 d-flex justify-content-sm-end mb-4">
                <!-- Agregar el ID almacenado en el campo oculto al enlace del reporte PDF -->
                <a href="pdfs/pdf_Guia_salida_Uni_adm.php?id=<?php echo isset($guia['id_guia_salida']) ? $guia['id_guia_salida'] : ''; ?>" target="_blank" class="btn btn-danger btn-sm shadow-sm" style="margin-top:-55px;height:40px;padding: 8px 15px; font-family: Verdana, Geneva, Tahoma, sans-serif;">
                    <i class="fa-solid fa-file-pdf" ></i> <b>Imprimir Guia buscada </b>
                </a>
            </div>
        </div>

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
    <?php endif; ?>
<?php endif; ?>
</section>
        </div>
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