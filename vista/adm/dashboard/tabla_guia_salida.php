<?php
session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:index.php');
}
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <title>Administrador Bodega Maribel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="css/sb-admin-2.min.css?asd" rel="stylesheet">
    <link href="css/reloj.css" rel="sytlesheet">
    <style>
        .guia-card {
            border: 1px solid #d9d9d9;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            background: #fff;
        }
        .section-title {
            font-weight: 700;
            font-size: 1.05rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .detalle-table th, .detalle-table td {
            vertical-align: middle;
            font-size: 0.9rem;
        }
        .detalle-table .lote-info {
            font-size: 0.8rem;
        }
        .guia-layout {
            border: 2px solid #000;
            padding: 1rem;
            background: #fafafa;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php
        @include 'sidebar.php';
        @include 'navbar.php';
        @include '../../../controlador/controlador_tablas/controlador_tabla_guia_salida.php';
        @include '../../modelo/config.php';

        $productos = [];
        $productoQuery = mysqli_query($conn, "SELECT id_producto, nombre_producto FROM producto WHERE stock_actual > 0");
        if ($productoQuery) {
            while ($prod = mysqli_fetch_assoc($productoQuery)) {
                $productos[] = $prod;
            }
        }

        $guias = [];
        $guiasQuery = mysqli_query(
            $conn,
            "SELECT g.*, COUNT(d.id_detalle_salida) AS items, COALESCE(SUM(d.cantidad),0) AS total_cantidad " .
            "FROM guia_de_salida g LEFT JOIN guia_de_salida_detalle d ON g.id_guia_salida = d.id_guia_salida " .
            "GROUP BY g.id_guia_salida ORDER BY g.fecha_salida DESC"
        );
        if ($guiasQuery) {
            while ($guia = mysqli_fetch_assoc($guiasQuery)) {
                $guias[] = $guia;
            }
        }
        ?>
    </div>
    <div class="container-fluid">
        <h3 class="text-center fw-bold my-4">Guía de Salida</h3>

        <div class="guia-card mb-4 guia-layout">
            <form action="../../../controlador/controlador_tablas/controlador_tabla_guia_salida.php" method="post" id="guiaForm">
                <input type="hidden" name="accion" value="btnAgregar">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">RUC / Remitente</label>
                        <input type="text" class="form-control" name="numero_documento" placeholder="001-1238614" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha de emisión</label>
                        <input type="date" class="form-control" name="fecha_salida" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Domicilio Fiscal</label>
                        <input type="text" class="form-control" name="domicilio_fiscal" placeholder="Dirección del remitente">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Fecha inicio de traslado</label>
                        <input type="date" class="form-control" name="fecha_inicio_traslado">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Destinatario</label>
                        <input type="text" class="form-control" name="destinatario" placeholder="Nombre / Razón social">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">RUC / DNI destinatario</label>
                        <input type="text" class="form-control" name="ruc_dni_destinatario">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Punto de partida</label>
                        <input type="text" class="form-control" name="punto_partida" placeholder="Dirección de partida">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Punto de llegada</label>
                        <input type="text" class="form-control" name="punto_llegada" placeholder="Dirección de llegada">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Motivo del traslado</label>
                        <select class="form-select" name="motivo_traslado">
                            <option value="Venta">Venta</option>
                            <option value="Compra">Compra</option>
                            <option value="Consignación">Consignación</option>
                            <option value="Traslado interno">Traslado entre almacenes</option>
                            <option value="Devolución">Devolución</option>
                            <option value="Exportación">Exportación</option>
                            <option value="Importación">Importación</option>
                            <option value="Recepción de bien">Recepción de bien</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Modalidad de transporte</label>
                        <select class="form-select" name="modalidad_transporte">
                            <option value="Particular">Particular</option>
                            <option value="Transportista">Transportista</option>
                            <option value="Despacho propio">Despacho del remitente</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Destino</label>
                        <input type="text" class="form-control" name="destino" placeholder="Área / Cliente" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Encargado</label>
                        <input type="text" class="form-control" name="encargado" placeholder="Responsable" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Marca y placa</label>
                        <input type="text" class="form-control" name="marca_placa">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Licencia de conducir</label>
                        <input type="text" class="form-control" name="licencia_conducir">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">RUC transportista</label>
                        <input type="text" class="form-control" name="ruc_transporte">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Denominación transportista</label>
                        <input type="text" class="form-control" name="denominacion_conductor">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="activo">
                            <option value="pendiente">Pendiente</option>
                            <option value="Entregado">Entregado</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción general</label>
                    <textarea class="form-control" name="descripcion" rows="2" placeholder="Detalle general del traslado"></textarea>
                </div>

                <div class="mb-2 d-flex align-items-center justify-content-between">
                    <span class="section-title">Detalle de productos</span>
                    <button class="btn btn-outline-primary btn-sm" type="button" id="addRow"><i class="fa-solid fa-plus"></i> Añadir línea</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered detalle-table">
                        <thead class="table-light">
                            <tr>
                                <th>Descripción</th>
                                <th style="width:120px">Cantidad</th>
                                <th style="width:150px">Unidad de medida</th>
                                <th style="width:130px">Peso total</th>
                                <th style="width:260px">Producto y lote sugerido</th>
                            </tr>
                        </thead>
                        <tbody id="detalleBody">
                            <tr class="detalle-row">
                                <td><input type="text" name="detalle_descripcion[]" class="form-control" placeholder="Descripción del ítem"></td>
                                <td><input type="number" name="detalle_cantidad[]" class="form-control detalle-cantidad" min="1" required></td>
                                <td><input type="text" name="detalle_unidad[]" class="form-control" value="UND"></td>
                                <td><input type="number" step="0.01" name="detalle_peso[]" class="form-control" placeholder="0.00"></td>
                                <td>
                                    <select name="detalle_producto[]" class="form-select producto-select" required>
                                        <option value="">Seleccione un producto</option>
                                        <?php foreach ($productos as $producto): ?>
                                            <option value="<?= $producto['id_producto']; ?>"><?= htmlspecialchars($producto['nombre_producto']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="text-muted lote-info">Lote: -- | Vence: -- | Disp: --</div>
                                    <input type="hidden" name="detalle_lote[]" class="detalle-lote-id">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Guardar guía de salida</button>
                </div>
            </form>
        </div>

        <div class="guia-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Guías de salida registradas</h5>
                <a href="pdfs/pdf_guia_salida.php" target="_blank" class="btn btn-danger btn-sm"><i class="fa-solid fa-file-pdf"></i> Reporte general</a>
            </div>
            <div class="table-responsive" style="font-size: 0.9rem;">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Documento</th>
                            <th>Destino</th>
                            <th>Motivo</th>
                            <th>Items</th>
                            <th>Cantidad total</th>
                            <th>Estado</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($guias as $guia): ?>
                            <tr>
                                <td><?= $guia['id_guia_salida']; ?></td>
                                <td><?= $guia['fecha_salida']; ?></td>
                                <td><?= htmlspecialchars($guia['numero_documento']); ?></td>
                                <td><?= htmlspecialchars($guia['destino']); ?></td>
                                <td><?= htmlspecialchars($guia['motivo_traslado']); ?></td>
                                <td><?= $guia['items']; ?></td>
                                <td><?= $guia['total_cantidad']; ?></td>
                                <td><?= $guia['activo']; ?></td>
                                <td>
                                    <a href="pdfs/pdf_Guia_salida_Uni_adm.php?id=<?= $guia['id_guia_salida']; ?>" class="btn btn-outline-danger btn-sm" target="_blank">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const controllerUrl = '../../../controlador/controlador_tablas/controlador_lote_reciente.php';

        function crearFilaDetalle() {
            const fila = document.querySelector('.detalle-row').cloneNode(true);
            fila.querySelectorAll('input').forEach((input) => {
                input.value = '';
            });
            fila.querySelector('.lote-info').textContent = 'Lote: -- | Vence: -- | Disp: --';
            fila.querySelector('.detalle-lote-id').value = '';
            fila.querySelector('.producto-select').selectedIndex = 0;
            return fila;
        }

        async function actualizarLote(row) {
            const select = row.querySelector('.producto-select');
            const loteInfo = row.querySelector('.lote-info');
            const loteInput = row.querySelector('.detalle-lote-id');
            const productoId = select.value;

            if (!productoId) {
                loteInfo.textContent = 'Lote: -- | Vence: -- | Disp: --';
                loteInput.value = '';
                return;
            }

            try {
                const response = await fetch(`${controllerUrl}?id_producto=${productoId}`);
                const data = await response.json();
                if (data && data.id_lote) {
                    loteInfo.textContent = `Lote: ${data.id_lote} | Vence: ${data.fecha_vencimiento} | Disp: ${data.cantidad_disponible}`;
                    loteInput.value = data.id_lote;
                } else {
                    loteInfo.textContent = 'No hay lotes disponibles para este producto';
                    loteInput.value = '';
                }
            } catch (error) {
                loteInfo.textContent = 'Error al buscar el lote';
                loteInput.value = '';
            }
        }

        document.addEventListener('change', (event) => {
            if (event.target.classList.contains('producto-select')) {
                actualizarLote(event.target.closest('.detalle-row'));
            }
        });

        document.getElementById('addRow').addEventListener('click', () => {
            const body = document.getElementById('detalleBody');
            const nuevaFila = crearFilaDetalle();
            body.appendChild(nuevaFila);
        });

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.producto-select').forEach((select) => {
                if (select.value) {
                    actualizarLote(select.closest('.detalle-row'));
                }
            });
        });
    </script>
</body>

</html>
