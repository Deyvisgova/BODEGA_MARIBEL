<?php
    @include '../../modelo/config.php';

    $id_guia_entrada = (isset($_POST['id_guia_entrada']))?$_POST['id_guia_entrada']:"";
    $fecha_entrada = (isset($_POST['fecha_entrada']))?$_POST['fecha_entrada']:"";
    $descripcion = (isset($_POST['descripcion']))?$_POST['descripcion']:"";
    $cantidad_entrada = (isset($_POST['cantidad_entrada']))?$_POST['cantidad_entrada']:"";
    $producto = (isset($_POST['producto']))?$_POST['producto']:"";
    $provedor = (isset($_POST['provedor']))?$_POST['provedor']:"";
    $activo = (isset($_POST['activo']))?$_POST['activo']:"";


    $accionAgregar="";
    $accionModificar = $accionEliminar = $accionCancelar = "disabled";
    $mostrarModal = false;

    $accion= (isset($_POST['accion']))?$_POST['accion']:"";
    switch($accion){
            case "btnModificar":
                //falta implementar más...

                $update = "UPDATE activo='$activo' WHERE id_guia_entrada='$id_guia_entrada;
                        UPDATE producto SET cantidad = cantidad+$cantidad_entrada WHERE nombre_producto=$producto;

                ";
                mysqli_query($conn, $update);

                header('location: ../../vista/adm/dashboard/tabla_cantidad.php');
            break;
       
        case "btnCancelar":
            header('location: ../../vista/adm/dashboard/tabla_cantidad.php');
            break;

        case "Seleccionar":
            $pass="disabled";
            $accionAgregar="disabled";
            $accionModificar = $accionEliminar = $accionCancelar = "";
            $mostrarModal= true;
            break;
    }
?>