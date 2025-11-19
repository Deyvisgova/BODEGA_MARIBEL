<?php
session_start();

if(!isset($_SESSION['admin_name'])){
    header('location: ../../login/login_form.php');
    exit;
}

$registroAdminErrores = [];
$registroAdminExito = '';
$registroColaboradorErrores = [];
$registroColaboradorExito = '';

@include '../../../controlador/controlador_adm/controlador_register_form_adm.php';
@include '../../../controlador/controlador_login/controlador_register_form.php';

$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$scriptDir = str_replace('\\', '/', dirname($scriptName));
$vistaPos = strpos($scriptDir, '/vista/');
$projectBase = $vistaPos === false ? $scriptDir : substr($scriptDir, 0, $vistaPos);
$projectBase = rtrim($projectBase, '/');
$projectBase = $projectBase === '/' ? '' : $projectBase;

$buildUrl = static function (string $path) use ($projectBase): string {
    $normalized = '/' . ltrim($path, '/');
    $base = $projectBase !== '' ? $projectBase : '';
    return $base . $normalized;
};

$assetBase = $buildUrl('vista/adm/dashboard');
$adminName = $_SESSION['admin_name'];

$old = static function (string $key): string {
    return htmlspecialchars($_POST[$key] ?? '', ENT_QUOTES, 'UTF-8');
};

$selected = static function (string $key, string $value): string {
    return ((string)($_POST[$key] ?? '') === $value) ? 'selected' : '';
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registrar usuarios - Bodega Maribel</title>
    <link rel="icon" href="<?= htmlspecialchars($buildUrl('vista/imagenes/principal/makro.ico'), ENT_QUOTES, 'UTF-8') ?>" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/73c70fe811.js" crossorigin="anonymous"></script>
</head>
<body id="page-top">
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= htmlspecialchars($buildUrl('index.php?ruta=admin/dashboard'), ENT_QUOTES, 'UTF-8') ?>">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fa-solid fa-warehouse"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Maribel Mayorista<sup> Admin</sup></div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item">
            <a class="nav-link" href="<?= htmlspecialchars($buildUrl('index.php?ruta=admin/dashboard'), ENT_QUOTES, 'UTF-8') ?>">
                <i class="fa-solid fa-house"></i>
                <span>Inicio</span>
            </a>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading text-white">Gestión de Usuarios</div>
        <li class="nav-item">
            <a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_admin.php'), ENT_QUOTES, 'UTF-8') ?>">
                <i class="fa-solid fa-key"></i>
                <span>Administradores</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_colaborador.php'), ENT_QUOTES, 'UTF-8') ?>">
                <i class="fa-solid fa-user"></i>
                <span>Colaboradores</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-user-plus"></i>
                <span>Registrar usuarios</span>
            </a>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading text-white">Inventario</div>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_producto.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-box"></i> <span>Productos</span></a></li>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_checkList.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-list-check"></i> <span>Check List</span></a></li>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_categoria.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-layer-group"></i> <span>Categorías</span></a></li>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_guia_entrada.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-file-import"></i> <span>Guía de Entrada</span></a></li>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_guia_salida.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-file-export"></i> <span>Guía de Salida</span></a></li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading text-white">Proveedores</div>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/adm/dashboard/tabla_provedor.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fa-solid fa-handshake"></i> <span>Proveedores</span></a></li>
        <hr class="sidebar-divider d-none d-md-block">
        <li class="nav-item">
            <a class="nav-link" href="<?= htmlspecialchars($buildUrl('vista/login/logout.php'), ENT_QUOTES, 'UTF-8') ?>">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                <span>Salir</span>
            </a>
        </li>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrador - <?= htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8') ?></span>
                            <img class="img-profile rounded-circle" src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/img/undraw_profile.svg" alt="Perfil">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="<?= htmlspecialchars($buildUrl('index.php?ruta=admin/dashboard'), ENT_QUOTES, 'UTF-8') ?>"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Inicio</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= htmlspecialchars($buildUrl('vista/login/logout.php'), ENT_QUOTES, 'UTF-8') ?>"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Salir</a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Registrar usuarios</h1>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-danger">Nuevo administrador</h6>
                            </div>
                            <div class="card-body">
                                <?php if(!empty($registroAdminErrores)): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php foreach($registroAdminErrores as $mensaje): ?>
                                                <li><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php elseif($registroAdminExito): ?>
                                    <div class="alert alert-success mb-4"><?= htmlspecialchars($registroAdminExito, ENT_QUOTES, 'UTF-8') ?></div>
                                <?php endif; ?>
                                <form method="post">
                                    <div class="mb-3">
                                        <label class="form-label">DNI</label>
                                        <input type="text" name="dni_adm" class="form-control" value="<?= $old('dni_adm') ?>" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nombre</label>
                                            <input type="text" name="nombre_adm" class="form-control" value="<?= $old('nombre_adm') ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Apellidos</label>
                                            <input type="text" name="apellido_adm" class="form-control" value="<?= $old('apellido_adm') ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Género</label>
                                        <select name="genero_adm" class="form-control">
                                            <option value="Masculino" <?= $selected('genero_adm', 'Masculino') ?>>Masculino</option>
                                            <option value="Femenino" <?= $selected('genero_adm', 'Femenino') ?>>Femenino</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Dirección</label>
                                        <input type="text" name="direccion_adm" class="form-control" value="<?= $old('direccion_adm') ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" name="telefono_adm" class="form-control" value="<?= $old('telefono_adm') ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Correo</label>
                                        <input type="email" name="email_adm" class="form-control" value="<?= $old('email_adm') ?>" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <input type="password" name="password_adm" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Confirmar contraseña</label>
                                            <input type="password" name="cpassword_adm" class="form-control" required>
                                        </div>
                                    </div>
                                    <button type="submit" name="registrar_admin" class="btn btn-danger">Guardar administrador</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Nuevo colaborador</h6>
                            </div>
                            <div class="card-body">
                                <?php if(!empty($registroColaboradorErrores)): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php foreach($registroColaboradorErrores as $mensaje): ?>
                                                <li><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php elseif($registroColaboradorExito): ?>
                                    <div class="alert alert-success mb-4"><?= htmlspecialchars($registroColaboradorExito, ENT_QUOTES, 'UTF-8') ?></div>
                                <?php endif; ?>
                                <form method="post">
                                    <div class="mb-3">
                                        <label class="form-label">DNI</label>
                                        <input type="text" name="dni_colab" class="form-control" value="<?= $old('dni_colab') ?>" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nombre</label>
                                            <input type="text" name="nombre_colab" class="form-control" value="<?= $old('nombre_colab') ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Apellidos</label>
                                            <input type="text" name="apellido_colab" class="form-control" value="<?= $old('apellido_colab') ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Género</label>
                                        <select name="genero_colab" class="form-control">
                                            <option value="Masculino" <?= $selected('genero_colab', 'Masculino') ?>>Masculino</option>
                                            <option value="Femenino" <?= $selected('genero_colab', 'Femenino') ?>>Femenino</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Dirección</label>
                                        <input type="text" name="direccion_colab" class="form-control" value="<?= $old('direccion_colab') ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" name="telefono_colab" class="form-control" value="<?= $old('telefono_colab') ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Correo</label>
                                        <input type="email" name="email_colab" class="form-control" value="<?= $old('email_colab') ?>" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <input type="password" name="password_colab" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Confirmar contraseña</label>
                                            <input type="password" name="cpassword_colab" class="form-control" required>
                                        </div>
                                    </div>
                                    <button type="submit" name="registrar_colaborador" class="btn btn-primary">Guardar colaborador</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>/js/sb-admin-2.min.js"></script>
</body>
</html>
