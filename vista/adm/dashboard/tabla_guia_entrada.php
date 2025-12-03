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

    <style>
        .modal-modern {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            background: linear-gradient(135deg, #ffffff 0%, #f7f9fc 100%);
        }

        .modal-modern .modal-header {
            background: linear-gradient(135deg, #dc3545 0%, #f66d6d 100%);
            color: #fff;
            border: none;
        }

        .modal-modern .modal-title {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .modal-modern .form-label {
            font-weight: 600;
            color: #1f2937;
        }

        .modal-modern .form-control,
        .modal-modern .form-select {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 12px;
        }

        .modal-modern .form-control:focus,
        .modal-modern .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.15);
            border-color: #f67b7b;
        }

        .modal-modern .modal-footer {
            border-top: none;
            background: #f8fafc;
        }

        .pill-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fef2f2;
            color: #991b1b;
            padding: 10px 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
        }
    </style>

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
        @include '../../../controlador/controlador_tablas/controlador_tabla_guia_entrada.php';
        $select = "SELECT * FROM guia_de_entrada";
        $tabla = mysqli_query($conn, $select);

        $productosDisponibles = mysqli_fetch_all(
            mysqli_query(
                $conn,
                "SELECT id_producto, nombre_producto FROM producto ORDER BY nombre_producto ASC"
            ),
            MYSQLI_ASSOC
        );

        $lotesDisponibles = mysqli_fetch_all(
            mysqli_query(
                $conn,
                "SELECT l.id_lote, l.fecha_vencimiento, p.nombre_producto FROM lote l JOIN producto p ON p.id_producto = l.id_producto ORDER BY l.id_lote DESC"
            ),
            MYSQLI_ASSOC
        );

        $proveedoresDisponibles = mysqli_fetch_all(
            mysqli_query(
                $conn,
                "SELECT id_provedor, Nombre_de_la_empresa FROM provedor ORDER BY Nombre_de_la_empresa ASC"
            ),
            MYSQLI_ASSOC
        );

        $categoriasDisponibles = mysqli_fetch_all(
            mysqli_query(
                $conn,
                "SELECT id_categoria, descripcion FROM categoria ORDER BY descripcion ASC"
            ),
            MYSQLI_ASSOC
        );
        ?>
        <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; text-align: center; font-weight: 600;">TABLA Guias de Entrada</h3>
        <hr>

        <form action="../../../controlador/controlador_tablas/controlador_tabla_guia_entrada.php" method="post">

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

                                <div class="form-group col-md-4">
                                    <label>Fecha</label>
                                    <input type="date" class="form-control" required name="fecha_entrada" placeholder="" id="fecha_entrada" value="<?php echo $fecha_entrada; ?>">
                                    <br>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Proveedor:</label>
                                    <select name="id_proveedor" id="id_proveedor" class="form-control" required>
                                        <option value="" disabled selected>Selecciona un proveedor</option>
                                        <?php foreach ($proveedoresDisponibles as $proveedor) { ?>
                                            <option value="<?php echo (int)$proveedor['id_provedor']; ?>">
                                                <?php echo htmlspecialchars($proveedor['Nombre_de_la_empresa'], ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                        <?php } ?>
                                    </select><br>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="">Descripcion:</label>
                                    <input type="text" class="form-control" name="descripcion" placerholder="" id="descripcion" value="<?php echo $descripcion; ?>"><br>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Activo:</label>
                                    <select name="activo" id="activo" class="form-control" required>
                                        <option value="" disabled selected>Selecciona el estado</option>
                                        <option value="pendiente">Pendiente</option>
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
                <div class="col-12 col-sm-9 d-flex justify-content-sm-start mb-4">
                    <button type="button" class="btn btn-outline-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#detalleGuiaModal">
                        <i class="fa-solid fa-file-circle-plus me-2"></i>Agregar detalle de guía
                    </button>
                </div>

                <div class="col-12 col-sm-9 d-flex justify-content-sm-end mb-4">
                    <a href="pdfs/pdf_guia_entrada.php" target="_blank" class="btn btn-danger btn-sm shadow-sm" style="padding: 8px 15px; font-family: Verdana, Geneva, Tahoma, sans-serif;">
                        <i class="fa-solid fa-file-pdf fa-xl"></i> <b>Generar Reporte</b>
                    </a>
                </div>
            </div>
        </form>

        <div class="" style="font-size: 11px; border-radius: 10px; overflow-x: auto; max-width: 100%;"> <!-- ESTE STYLE HACE RESPONSIVE LA TABLA -->
            <table class="table table_id">
                <thead class="table-dark">
                    <tr>
                        <th>Id Guia de Entrada:</th>
                        <th>Fecha:</th>
                        <th>Descripcion</th>
                        <th>Proveedor:</th>
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
                        <td><?php echo $row['provedor']; ?></td>
                        <td><?php echo $row['activo']; ?></td>


                           

                            <form action="" method="POST">
                                <input type="hidden" value="<?php echo $row['id_guia_entrada']; ?>" name="id_guia_entrada">
                                <input type="hidden" value="<?php echo $row['fecha_entrada']; ?>" name="fecha_entrada">
                        <input type="hidden" value="<?php echo $row['descripcion']; ?>" name="descripcion">
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

        <!-- Modal moderno para registrar detalle de guía de entrada -->
        <div class="modal fade" id="detalleGuiaModal" tabindex="-1" aria-labelledby="detalleGuiaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content modal-modern">
                    <div class="modal-header">
                        <div>
                            <p class="mb-1 text-uppercase small">Guía de entrada</p>
                            <h1 class="modal-title fs-4" id="detalleGuiaModalLabel">Agregar detalle de ingreso</h1>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="pill-badge mb-3">
                            <i class="fa-solid fa-circle-check"></i>
                            Completa la información para asociarla a la guía.
                        </div>

                        <div class="alert alert-dismissible fade show" role="alert" id="detalleGuiaAlert" style="display: none;"></div>

                        <form id="detalleEntradaForm" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="detalle_id_guia">ID Guía</label>
                                <input type="number" class="form-control" id="detalle_id_guia" name="id_guia_entrada" value="<?php echo htmlspecialchars($id_guia_entrada ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Ej. 4" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label" for="detalle_producto">Producto</label>
                                <div class="d-flex gap-2">
                                    <select class="form-select" id="detalle_producto" name="id_producto" required>
                                        <option value="" selected disabled>Selecciona un producto</option>
                                        <?php foreach ($productosDisponibles as $producto) { ?>
                                            <option value="<?php echo (int)$producto['id_producto']; ?>"><?php echo htmlspecialchars($producto['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?></option>
                                        <?php } ?>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal" aria-label="Crear producto">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="detalle_cantidad">Cantidad de entrada</label>
                                <input type="number" min="1" class="form-control" id="detalle_cantidad" name="cantidad_entrada" placeholder="Ej. 50" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="detalle_precio_unitario">Precio unitario</label>
                                <div class="input-group">
                                    <span class="input-group-text">S/</span>
                                    <input type="number" step="0.01" min="0" class="form-control" id="detalle_precio_unitario" name="precio_unitario" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="detalle_lote">Lote</label>
                                <div class="d-flex gap-2">
                                    <select class="form-select" id="detalle_lote" name="id_lote" required>
                                        <option value="" selected disabled>Selecciona un lote</option>
                                        <?php foreach ($lotesDisponibles as $lote) { ?>
                                            <option value="<?php echo (int)$lote['id_lote']; ?>">
                                                Lote #<?php echo (int)$lote['id_lote']; ?> · <?php echo htmlspecialchars($lote['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?> (Vence: <?php echo htmlspecialchars($lote['fecha_vencimiento'], ENT_QUOTES, 'UTF-8'); ?>)
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#nuevoLoteModal" aria-label="Crear lote">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="detalle_fecha_vencimiento">Fecha de vencimiento</label>
                                <input type="date" class="form-control" id="detalle_fecha_vencimiento" name="fecha_vencimiento" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark me-2"></i>Cancelar
                        </button>
                        <button type="submit" form="detalleEntradaForm" class="btn btn-danger" id="detalleGuardarBtn">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar detalle
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub-modal: crear producto rápido -->
        <div class="modal fade" id="nuevoProductoModal" tabindex="-1" aria-labelledby="nuevoProductoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content modal-modern">
                    <div class="modal-header">
                        <div>
                            <p class="mb-1 text-uppercase small">Producto</p>
                            <h1 class="modal-title fs-5" id="nuevoProductoModalLabel">Crear nuevo producto</h1>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-dismissible fade show" id="productoAlert" style="display: none;"></div>
                        <form id="nuevoProductoForm" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="producto_nombre">Nombre</label>
                                <input type="text" class="form-control" id="producto_nombre" name="nombre_producto" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="producto_categoria">Categoría</label>
                                <select class="form-select" id="producto_categoria" name="categoria" required>
                                    <option value="" selected disabled>Selecciona una categoría</option>
                                    <?php foreach ($categoriasDisponibles as $categoria) { ?>
                                        <option value="<?php echo (int)$categoria['id_categoria']; ?>"><?php echo htmlspecialchars($categoria['descripcion'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="producto_descripcion">Descripción</label>
                                <textarea class="form-control" id="producto_descripcion" name="descripcion" rows="2" placeholder="Notas internas"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="producto_proveedor">Proveedor</label>
                                <select class="form-select" id="producto_proveedor" name="provedor" required>
                                    <option value="" selected disabled>Selecciona un proveedor</option>
                                    <?php foreach ($proveedoresDisponibles as $proveedor) { ?>
                                        <option value="<?php echo htmlspecialchars($proveedor['Nombre_de_la_empresa'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($proveedor['Nombre_de_la_empresa'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="producto_activo">Estado</label>
                                <select class="form-select" id="producto_activo" name="activo" required>
                                    <option value="activo" selected>Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" form="nuevoProductoForm" class="btn btn-danger" id="guardarProductoBtn">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar producto
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub-modal: crear lote rápido -->
        <div class="modal fade" id="nuevoLoteModal" tabindex="-1" aria-labelledby="nuevoLoteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content modal-modern">
                    <div class="modal-header">
                        <div>
                            <p class="mb-1 text-uppercase small">Lote</p>
                            <h1 class="modal-title fs-5" id="nuevoLoteModalLabel">Crear nuevo lote</h1>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-dismissible fade show" id="loteAlert" style="display: none;"></div>
                        <form id="nuevoLoteForm" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="lote_producto">Producto</label>
                                <select class="form-select" id="lote_producto" name="id_producto" required>
                                    <option value="" selected disabled>Selecciona un producto</option>
                                    <?php foreach ($productosDisponibles as $producto) { ?>
                                        <option value="<?php echo (int)$producto['id_producto']; ?>"><?php echo htmlspecialchars($producto['nombre_producto'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="lote_cantidad">Cantidad recibida</label>
                                <input type="number" class="form-control" id="lote_cantidad" name="cantidad_recibida" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="lote_fecha_vencimiento">Fecha de vencimiento</label>
                                <input type="date" class="form-control" id="lote_fecha_vencimiento" name="fecha_vencimiento" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="lote_fecha_ingreso">Fecha de ingreso</label>
                                <input type="date" class="form-control" id="lote_fecha_ingreso" name="fecha_ingreso" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" form="nuevoLoteForm" class="btn btn-danger" id="guardarLoteBtn">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar lote
                        </button>
                    </div>
                </div>
            </div>
        </div>

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
    // Obtener el ID de la guía de entrada desde el formulario
    $id_guia = mysqli_real_escape_string($conn, $_POST['id_guia']);

    // Consultar la base de datos para obtener la información de la guía de entrada
    $query = "SELECT * FROM guia_de_entrada WHERE id_guia_entrada = '$id_guia'";
    $result = mysqli_query($conn, $query);

    // Verificar si se encontraron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        $guia = mysqli_fetch_assoc($result);
    } else {
        $mensaje_error = "No se encontró la guía de entrada con el ID proporcionado.";
    }
}
?>

<section class="reporte_uno"><style>.reporte_uno{margin-top:50px}</style>
<h4>Búsqueda de Guía de Entrada</h4>

<section>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label for="id_guia">ID de Guía de Entrada:</label>
                    <input type="text" name="id_guia" required>
                    <button type="submit">Buscar</button>
                    <!-- Agregar campo oculto para almacenar el valor del ID -->
                    <input type="hidden" name="id_guia_hidden" value="<?php echo isset($guia['id_guia_entrada']) ? $guia['id_guia_entrada'] : ''; ?>">
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
                <a href="pdfs/pdf_Guia_entrada_Uni_adm.php?id=<?php echo isset($guia['id_guia_entrada']) ? $guia['id_guia_entrada'] : ''; ?>" target="_blank" class="btn btn-danger btn-sm shadow-sm" style="margin-top:-55px;height:40px;padding: 8px 15px; font-family: Verdana, Geneva, Tahoma, sans-serif;">
                    <i class="fa-solid fa-file-pdf" ></i> <b>Generar Reporte</b>
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
                <th>ID Guía de Entrada</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Activo</th>
            </tr>
            </thead>

            <tr>
                <td><?php echo $guia['id_guia_entrada']; ?></td>
                <td><?php echo $guia['fecha_entrada']; ?></td>
                <td><?php echo $guia['descripcion']; ?></td>
                <td><?php echo $guia['cantidad_entrada']; ?></td>
                <td><?php echo $guia['producto']; ?></td>
                <td><?php echo $guia['provedor']; ?></td>
                <td><?php echo $guia['activo']; ?></td>
            </tr>
        </table>
    <?php endif; ?>
<?php endif; ?>
</section>
    </div></div>
    

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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const detalleForm = document.getElementById('detalleEntradaForm');
            const alertBox = document.getElementById('detalleGuiaAlert');
            const guardarBtn = document.getElementById('detalleGuardarBtn');
            const detalleModalEl = document.getElementById('detalleGuiaModal');
            const detalleModal = detalleModalEl ? new bootstrap.Modal(detalleModalEl) : null;
            const productoModal = new bootstrap.Modal(document.getElementById('nuevoProductoModal'));
            const loteModal = new bootstrap.Modal(document.getElementById('nuevoLoteModal'));
            const productoAlert = document.getElementById('productoAlert');
            const loteAlert = document.getElementById('loteAlert');
            const productoForm = document.getElementById('nuevoProductoForm');
            const loteForm = document.getElementById('nuevoLoteForm');
            const productoSelects = [document.getElementById('detalle_producto'), document.getElementById('lote_producto')].filter(Boolean);
            const loteSelect = document.getElementById('detalle_lote');

            if (!detalleForm || !detalleModal) {
                return;
            }

            const mostrarMensaje = (mensaje, tipo) => {
                alertBox.textContent = mensaje;
                alertBox.className = `alert alert-${tipo} alert-dismissible fade show`;
                alertBox.style.display = 'block';
            };

            detalleForm.addEventListener('submit', async (event) => {
                event.preventDefault();
                alertBox.style.display = 'none';

                    const payload = {
                        id_guia_entrada: detalleForm.id_guia_entrada.value,
                        id_producto: detalleForm.id_producto.value,
                        cantidad_entrada: detalleForm.cantidad_entrada.value,
                        id_lote: detalleForm.id_lote.value,
                        fecha_vencimiento: detalleForm.fecha_vencimiento.value,
                        precio_unitario: detalleForm.precio_unitario.value
                    };

                guardarBtn.disabled = true;
                guardarBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Guardando...';

                try {
                    const response = await fetch('../../../controlador/controlador_tablas/controlador_detalle_guia_entrada.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    if (!response.ok) {
                        throw new Error('No se pudo guardar el detalle en la base de datos.');
                    }

                    const resultado = await response.json();

                    if (resultado.success) {
                        mostrarMensaje(resultado.message || 'Detalle guardado.', 'success');
                        detalleForm.reset();
                        setTimeout(() => detalleModal.hide(), 400);
                    } else {
                        const detalleError = resultado.error ? ` Detalle técnico: ${resultado.error}` : '';
                        mostrarMensaje((resultado.message || 'No se pudo guardar el detalle.') + detalleError, 'warning');
                    }
                } catch (error) {
                    const mensajeError = error?.message ? ` ${error.message}` : '';
                    mostrarMensaje('Ocurrió un error al enviar la información. Inténtalo nuevamente.' + mensajeError, 'danger');
                } finally {
                    guardarBtn.disabled = false;
                    guardarBtn.innerHTML = '<i class="fa-solid fa-floppy-disk me-2"></i>Guardar detalle';
                }
            });

            const sendFormData = async (form, url, alertContainer, successMessage, onSuccess) => {
                if (!form) return;

                alertContainer.style.display = 'none';
                const formData = new FormData(form);
                formData.append('accion', 'btnAgregar');

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData
                    });

                    if (response.ok) {
                        alertContainer.textContent = successMessage;
                        alertContainer.className = 'alert alert-success alert-dismissible fade show';
                        alertContainer.style.display = 'block';
                        form.reset();

                        if (onSuccess) {
                            onSuccess();
                        }
                    } else {
                        throw new Error('No se pudo completar la solicitud.');
                    }
                } catch (error) {
                    alertContainer.textContent = 'No se pudo guardar. Verifica los datos e inténtalo nuevamente.';
                    alertContainer.className = 'alert alert-danger alert-dismissible fade show';
                    alertContainer.style.display = 'block';
                }
            };

            productoForm?.addEventListener('submit', async (event) => {
                event.preventDefault();
                await sendFormData(
                    productoForm,
                    '../../../controlador/controlador_tablas/controlador_tabla_producto.php',
                    productoAlert,
                    'Producto creado correctamente.',
                    () => {
                        const nombre = productoForm.nombre_producto.value;
                        const nuevaOpcion = new Option(nombre, '');
                        if (productoSelects.length) {
                            productoSelects.forEach((select) => {
                                const option = nuevaOpcion.cloneNode(true);
                                option.value = ''; // mantener vacío para forzar recarga manual
                                select.appendChild(option);
                            });
                        }
                        productoModal.hide();
                    }
                );
            });

            loteForm?.addEventListener('submit', async (event) => {
                event.preventDefault();
                await sendFormData(
                    loteForm,
                    '../../../controlador/controlador_tablas/controlador_tabla_lote.php',
                    loteAlert,
                    'Lote creado correctamente.',
                    () => {
                        if (loteSelect) {
                            const nuevoValor = 'pendiente';
                            const option = new Option('Nuevo lote registrado (actualiza para ver)', nuevoValor);
                            loteSelect.appendChild(option);
                            loteSelect.value = nuevoValor;
                        }
                        loteModal.hide();
                    }
                );
            });
        });
    </script>


</body>

</html>
