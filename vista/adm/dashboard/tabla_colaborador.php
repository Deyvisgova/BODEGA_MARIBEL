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
    <link href="css/sb-admin-2.min.css?as" rel="stylesheet">
    <link href="css/reloj.css" rel="sytlesheet">
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
        include '../../../controlador/controlador_tablas/controlador_tabla_colaborador.php';
        $select = "SELECT * FROM colaborador";
        $tabla = mysqli_query($conn, $select);
        ?>

        <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; text-align: center; font-weight: 600;">Tabla Colaborador</h3>
        <hr>

        <form action="../../../controlador/controlador_tablas/controlador_tabla_colaborador.php" method="post">
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Colaborador</h1>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                    <label for="">ID:</label>
                                    <input type="text" class="form-control" name="id_colab" id="id_colab" value="<?php echo $id_colab; ?>" readonly><br>
                                </div>

                                

                                <div class="form-group col-md-8">
                                    <label for="">DNI_colb:</label>
                                    <input type="text" class="form-control" required name="dni_colab" placerholder="" id="dni_colab" value="<?php echo $dni_colab; ?>"><br>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Nombre:</label>
                                    <input type="text" class="form-control" required name="nombre_colab" placerholder="" id="nombre_colab" value="<?php echo $nombre_colab; ?>"><br>
                                </div>

                                <div class="form-group col-md-8">
                                    <label>Apellido:</label>
                                    <input type="text" class="form-control" required name="apellido_colab" placerholder="" id="apellido_colab" value="<?php echo $apellido_colab; ?>"><br>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Género:</label>
                                    <select name="genero_colab" class="form-control">
                                        <option value="<?php echo $genero_colab; ?>"> <?php echo $genero_colab; ?></option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Masculino">Masculino </option>
                                    </select><br>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="">Dirección:</label>
                                    <input type="text" class="form-control" required name="direccion_colab" placerholder="" id="direccion_colab" value="<?php echo $direccion_colab; ?>"><br>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Telefono:</label>
                                    <input type="text" class="form-control" required name="telefono_colab" placerholder="" id="telefono_colab" value="<?php echo $telefono_colab; ?>"><br>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="">Correo:</label>
                                    <input type="email" class="form-control" required name="email" placerholder="" id="email" value="<?php echo $email; ?>"><br>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Contraseña:</label>
                                    <input type="password" class="form-control" name="pass" <?php echo $pass; ?> placeholder="" id="pass" value=""><br>
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="">Tipo de usuario:</label>
                                    <select name="user_type" id="user_type" class="form-control">
                                        <option value=" <?php echo $user_type; ?>"><?php echo $user_type; ?></option>
                                        <option value="colab">colab</option>
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
                    <a href="pdfs/pdf_colaborador.php" class="btn btn-danger btn-sm shadow-sm" style="padding: 8px 15px; font-family: Verdana, Geneva, Tahoma, sans-serif;">
                        <i class="fa-solid fa-file-pdf fa-xl"></i> <b>Generar Reporte</b>
                    </a>
                </div>
            </div>
        </form>

        <div class="row1" style="font-size: 11px; border-radius: 10px; overflow-x: auto; max-width: 100%;"> <!-- ESTE STYLE HACE RESPONSIVE LA TABLA -->
            <table class="table table_id">
                <thead class="table-dark">
                    <tr>
                        <th>ID:</th>
                        <th>DNI:</th>
                        <th>Nombre:</th>
                        <th>Apellido:</th>
                        <th>Género:</th>
                        <th>Direccion:</th>
                        <th>Telefono:</th>
                        <th>Correo:</th>
                        <th>Contraseña:</th>
                        <th>Tipo:</th>
                        <th>Acciones:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($tabla)) { ?>
                        <tr>
                            <td><?php echo $row['id_colab']; ?></td>
                            <td><?php echo $row['dni_colab']; ?></td>
                            <td><?php echo $row['nombre_cocolab']; ?></td>
                            <td><?php echo $row['apellido_colab']; ?></td>
                            <td><?php echo $row['genero_colab']; ?></td>
                            <td><?php echo $row['direccion_colab']; ?></td>
                            <td><?php echo $row['telefono_colab']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['password']; ?></td>
                            <td><?php echo $row['user_type']; ?></td>

                            <form action="" method="post">

                                <input type="hidden" name="id_colab" value=" <?php echo $row['id_colab']; ?>">
                                <input type="hidden" name="dni_colab" value=" <?php echo $row['dni_colab']; ?>">
                                <input type="hidden" name="nombre_colab" value=" <?php echo $row['nombre_colab']; ?>">
                                <input type="hidden" name="apellido_colab" value=" <?php echo $row['apellido_colab']; ?>">
                                <input type="hidden" name="genero_colab" value=" <?php echo $row['genero_colab']; ?>">
                                <input type="hidden" name="direccion_colab" value=" <?php echo $row['direccion_colab']; ?>">
                                <input type="hidden" name="telefono_colab" value=" <?php echo $row['telefono_colab']; ?>">
                                <input type="hidden" name="email" value=" <?php echo $row['email']; ?>">
                                <input type="hidden" name="pass" value=" <?php echo $row['password']; ?>">
                                <input type="hidden" name="user_type" value=" <?php echo $row['user_type']; ?>">
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