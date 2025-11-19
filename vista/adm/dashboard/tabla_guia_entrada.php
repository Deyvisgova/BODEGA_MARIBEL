<?php
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:index.php');
}

@include '../../modelo/config.php';
@include '../../../controlador/controlador_tablas/controlador_tabla_guia_entrada.php';

$select = "SELECT * FROM guia_de_entrada";
$tabla = mysqli_query($conn, $select);

$productosDisponibles = [];
$detalleEntradaInicial = [];

if ($conn) {
    $consultaProductos = mysqli_query($conn, "SELECT nombre_producto FROM producto WHERE activo = 'activo' ORDER BY nombre_producto");
    if ($consultaProductos) {
        while ($row = mysqli_fetch_assoc($consultaProductos)) {
            $productosDisponibles[] = $row['nombre_producto'];
        }
    }
}

if (!empty($producto)) {
    $partes = array_map('trim', explode(',', $producto));
    foreach ($partes as $parte) {
        if (preg_match('/(.+)\((\d+)\)/', $parte, $coincidencia)) {
            $detalleEntradaInicial[] = [
                'producto' => trim($coincidencia[1]),
                'cantidad' => (int)$coincidencia[2],
            ];
        }
    }
    if (empty($detalleEntradaInicial) && $producto !== '') {
        $detalleEntradaInicial[] = [
            'producto' => $producto,
            'cantidad' => (int)$cantidad_entrada,
        ];
    }
}

if (empty($detalleEntradaInicial)) {
    $detalleEntradaInicial[] = ['producto' => '', 'cantidad' => 1];
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
    <link href="css/sb-admin-2.min.css?asd" rel="stylesheet">
    <link href="css/reloj.css" rel="sytlesheet">

    <script>
        function confirmacion() {
            return confirm("¿Desea ELIMINAR el registro?");
        }

        function confirmacionM() {
            return confirm("¿Desea MODIFICAR el registro?");
        }
    </script>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php
        @include 'sidebar.php';
        @include 'navbar.php';
        ?>
    </div>
    <div class="container">
        <h3 class="text-center fw-bold">TABLA Guias de Entrada</h3>
        <hr>

        <form action="../../../controlador/controlador_tablas/controlador_tabla_guia_entrada.php" method="post" id="formGuiaEntrada">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Guía de entrada</h1>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="form-group col-md-4">
                                    <label>ID:</label>
                                    <input type="text" class="form-control" required name="id_guia_entrada" id="id_guia_entrada" value="<?php echo $id_guia_entrada; ?>" readonly>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Fecha</label>
                                    <input type="date" class="form-control" required name="fecha_entrada" id="fecha_entrada" value="<?php echo $fecha_entrada; ?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Estado</label>
                                    <select name="activo" id="activo" class="form-control">
                                        <option value="<?php echo $activo; ?>"><?php echo $activo; ?></option>
                                        <option value="pendiente">Pendiente</option>
                                        <option value="recibido">Recibido</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="">Descripción</label>
                                    <input type="text" class="form-control" required name="descripcion" id="descripcion" value="<?php echo $descripcion; ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Proveedor</label>
                                    <select name="provedor" id="provedor" class="form-control">
                                        <?php
                                        include 'config.php';
                                        $consulta = "SELECT * from provedor";
                                        $ejecutar = mysqli_query($conn, $consulta);
                                        foreach ($ejecutar as $opciones):
                                        ?>
                                            <option value="<?php echo $opciones['Nombre_de_la_empresa'] ?>"><?php echo $opciones['Nombre_de_la_empresa'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <label class="mb-1">Productos</label>
                                            <p class="text-muted small mb-0">Agrega múltiples productos a la misma guía y define sus cantidades.</p>
                                        </div>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="agregarFilaEntrada">
                                            <i class="fa-solid fa-plus"></i> Añadir producto
                                        </button>
                                    </div>
                                    <div id="contenedorDetalleEntrada" class="vstack gap-2 mt-2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="detalles" id="detalleEntrada">
                            <input type="hidden" name="cantidad_entrada" id="cantidadEntradaTotal" value="<?php echo $cantidad_entrada; ?>">
                            <input type="hidden" name="producto" id="productosResumen" value="<?php echo htmlspecialchars($producto, ENT_QUOTES, 'UTF-8'); ?>">

                            <button value="btnAgregar" <?php echo $accionAgregar; ?> class="btn btn-success" type="submit" name="accion">Agregar</button>

                            <button value="btnModificar" <?php echo $accionModificar; ?> class="btn btn-warning" type="submit" name="accion" onclick='return confirmacionM()'>Modificar</button>

                            <button value="btnEliminar" <?php echo $accionEliminar; ?> class="btn btn-danger" type="submit" name="accion" onclick='return confirmacion()'>Eliminar</button>

                            <button value="btnCancelar" <?php echo $accionCancelar; ?> class="btn btn-primary" type="submit" name="accion">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-3 d-flex justify-content-sm-end mb-2">
                    <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fa-solid fa-plus fa-xl me-2"></i><b>Agregar registro</b>
                    </button>
                </div>

                <div class="col-12 col-sm-9 d-flex justify-content-sm-end mb-2">
                    <a href="pdfs/pdf_guia_entrada.php" target="_blank" class="btn btn-danger btn-sm shadow-sm">
                        <i class="fa-solid fa-file-pdf fa-xl"></i> <b>Generar Reporte</b>
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive" style="font-size: 11px; border-radius: 10px;">
            <table class="table table_id align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Id Guia de Entrada:</th>
                        <th>Fecha:</th>
                        <th>Descripcion</th>
                        <th>Total Cantidad:</th>
                        <th>Productos:</th>
                        <th>proveedor:</th>
                        <th>Activo:</th>
                        <th>Acciones:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($tabla)) { ?>
                        <tr>
                            <td><?php echo $row['id_guia_entrada']; ?></td>
                            <td><?php echo $row['fecha_entrada']; ?></td>
                            <td><?php echo $row['descripcion']; ?></td>
                            <td><?php echo $row['cantidad_entrada']; ?></td>
                            <td><?php echo htmlspecialchars($row['producto'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo $row['provedor']; ?></td>
                            <td><?php echo $row['activo']; ?></td>

                            <form action="" method="POST">
                                <input type="hidden" value="<?php echo $row['id_guia_entrada']; ?>" name="id_guia_entrada">
                                <input type="hidden" value="<?php echo $row['fecha_entrada']; ?>" name="fecha_entrada">
                                <input type="hidden" value="<?php echo $row['descripcion']; ?>" name="descripcion">
                                <input type="hidden" value="<?php echo $row['cantidad_entrada']; ?>" name="cantidad_entrada">
                                <input type="hidden" value="<?php echo htmlspecialchars($row['producto'], ENT_QUOTES, 'UTF-8'); ?>" name="producto">
                                <input type="hidden" value="<?php echo $row['provedor']; ?>" name="provedor">
                                <input type="hidden" value="<?php echo $row['activo']; ?>" name="activo">
                                <td><input type="submit" value="Seleccionar" name="accion"></td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php if ($mostrarModal) { ?>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    modal.show();
                });
            </script>
        <?php } ?>
    </div>

    <datalist id="listaProductosEntrada">
        <?php foreach ($productosDisponibles as $productoNombre): ?>
            <option value="<?php echo htmlspecialchars($productoNombre, ENT_QUOTES, 'UTF-8'); ?>"></option>
        <?php endforeach; ?>
    </datalist>

    <script>
        const detalleEntradaInicial = <?php echo json_encode($detalleEntradaInicial); ?>;

        const contenedorEntrada = document.getElementById('contenedorDetalleEntrada');
        const detalleEntradaInput = document.getElementById('detalleEntrada');
        const cantidadEntradaTotal = document.getElementById('cantidadEntradaTotal');
        const productosResumen = document.getElementById('productosResumen');
        const btnAgregarFilaEntrada = document.getElementById('agregarFilaEntrada');
        const formEntrada = document.getElementById('formGuiaEntrada');

        function crearFilaEntrada(detalle = {producto: '', cantidad: 1}) {
            const fila = document.createElement('div');
            fila.classList.add('row', 'g-2', 'align-items-center', 'detalle-item');
            fila.innerHTML = `
                <div class="col-md-7">
                    <input list="listaProductosEntrada" class="form-control input-producto" placeholder="Producto" value="${detalle.producto}" required>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control input-cantidad" min="1" value="${detalle.cantidad}" required>
                </div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-remover">&times;</button>
                </div>`;

            fila.querySelector('.btn-remover').addEventListener('click', () => {
                fila.remove();
                actualizarDetallesEntrada();
            });

            fila.querySelector('.input-producto').addEventListener('input', actualizarDetallesEntrada);
            fila.querySelector('.input-cantidad').addEventListener('input', actualizarDetallesEntrada);

            contenedorEntrada.appendChild(fila);
        }

        function actualizarDetallesEntrada() {
            const filas = contenedorEntrada.querySelectorAll('.detalle-item');
            const detalles = [];
            let total = 0;
            let resumen = [];

            filas.forEach(fila => {
                const producto = fila.querySelector('.input-producto').value.trim();
                const cantidad = parseInt(fila.querySelector('.input-cantidad').value, 10) || 0;
                if (producto && cantidad > 0) {
                    detalles.push({producto, cantidad});
                    total += cantidad;
                    resumen.push(`${producto} (${cantidad})`);
                }
            });

            detalleEntradaInput.value = JSON.stringify(detalles);
            cantidadEntradaTotal.value = total;
            productosResumen.value = resumen.join(', ');
        }

        btnAgregarFilaEntrada.addEventListener('click', () => {
            crearFilaEntrada();
        });

        formEntrada.addEventListener('submit', (event) => {
            actualizarDetallesEntrada();
            if (!detalleEntradaInput.value || detalleEntradaInput.value === '[]') {
                event.preventDefault();
                alert('Agrega al menos un producto a la guía.');
            }
        });

        detalleEntradaInicial.forEach(item => crearFilaEntrada(item));
        actualizarDetallesEntrada();
    </script>

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
