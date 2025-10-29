<?php
    @include '../../modelo/config.php';

    $id_guia_entrada = (isset($_POST['id_guia_entrada']))?$_POST['id_guia_entrada']:"";
    $activo = (isset($_POST['activo']))?$_POST['activo']:"";


    $accionModificar = $accionEliminar = $accionCancelar = "disabled";
    $mostrarModal = false;

    $accion= (isset($_POST['accion']))?$_POST['accion']:"";
    switch($accion){
            case "btnModificar":
                //falta implementar más...

                $update = "UPDATE guia_de_entrada SET activo='$activo' WHERE id_guia_entrada='$id_guia_entrada'
                UPDATE producto SET cantidad = cantidad +30 WHERE nombre_producto='leche Gloria'";
                mysqli_query($conn, $update);

                header('location: ../../vista/adm/dashboard/tabla_guia_salida_colab.php');
            break;
        
        case "btnCancelar":
            header('location: ../../vista/adm/dashboard/tabla_guia_salida_colab.php');
            break;

        case "Seleccionar":
            $pass="disabled";
            $accionAgregar="disabled";
            $accionModificar = $accionEliminar = $accionCancelar = "";
            $mostrarModal= true;
            break;
    }
?>