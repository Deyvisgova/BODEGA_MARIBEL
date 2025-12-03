<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    @include '../../modelo/config.php';
    require_once __DIR__ . '/../kardex_helper.php';

    $id_guia_entrada = (isset($_POST['id_guia_entrada']))?$_POST['id_guia_entrada']:"";
    $fecha_entrada = (isset($_POST['fecha_entrada']))?$_POST['fecha_entrada']:"";
    $descripcion = (isset($_POST['descripcion']))?$_POST['descripcion']:"";
    $id_proveedor = (isset($_POST['id_proveedor']))?$_POST['id_proveedor']:"";
    $activo = (isset($_POST['activo']))?$_POST['activo']:"";


    $accionAgregar="";
    $accionModificar = $accionEliminar = $accionCancelar = "disabled";
    $mostrarModal = false;

    $accion= (isset($_POST['accion']))?$_POST['accion']:"";
    switch($accion){
        case "btnAgregar":
                $select = "SELECT * FROM guia_de_entrada WHERE id_guia_entrada = '$id_guia_entrada'";
                $result = mysqli_query($conn, $select);
                if(mysqli_num_rows($result) > 0){
                    echo "<script> alert('¡Cuenta existente!')</script>";
                    header('location: ../../vista/adm/dashboard/tabla_guia_entrada.php');
                }else{

                    $insert = "INSERT INTO guia_de_entrada(fecha_entrada, descripcion, id_proveedor, activo) VALUES('$fecha_entrada','$descripcion', '$id_proveedor', '$activo')";
                    mysqli_query($conn, $insert);

                    $_SESSION['guia_actual_id'] = mysqli_insert_id($conn);
                    $_SESSION['guia_actual_proveedor'] = $id_proveedor;

                    header('location: ../../vista/adm/dashboard/tabla_guia_entrada.php');
                }
            break;
            case "btnModificar":
                //falta implementar más...

                $update = "UPDATE guia_de_entrada SET fecha_entrada='$fecha_entrada', descripcion='$descripcion', id_proveedor='$id_proveedor', activo='$activo' WHERE id_guia_entrada='$id_guia_entrada'";
                mysqli_query($conn, $update);

                $_SESSION['guia_actual_id'] = $id_guia_entrada;
                $_SESSION['guia_actual_proveedor'] = $id_proveedor;

                header('location: ../../vista/adm/dashboard/tabla_guia_entrada.php');
            break;
        case "btnEliminar":
                //Listo.
                $delete = "DELETE FROM guia_de_entrada WHERE id_guia_entrada = '$id_guia_entrada'";
                mysqli_query($conn,$delete);
                unset($_SESSION['guia_actual_id'], $_SESSION['guia_actual_proveedor']);
                header('location: ../../vista/adm/dashboard/tabla_guia_entrada.php');
            break;
        case "btnCancelar":
            unset($_SESSION['guia_actual_id'], $_SESSION['guia_actual_proveedor']);
            header('location: ../../vista/adm/dashboard/tabla_guia_entrada.php');
            break;

        case "Seleccionar":
            $pass="disabled";
            $accionAgregar="disabled";
            $accionModificar = $accionEliminar = $accionCancelar = "";
            $mostrarModal= true;
            $_SESSION['guia_actual_id'] = $id_guia_entrada;
            $_SESSION['guia_actual_proveedor'] = $id_proveedor;
            break;
    }
?>