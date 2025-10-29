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
        case "btnAgregar":
                $select = "SELECT * FROM guia_de_entrada WHERE id_guia_entrada = '$id_guia_entrada'";
                $result = mysqli_query($conn, $select);
                if(mysqli_num_rows($result) > 0){
                    echo "<script> alert('¡Cuenta existente!')</script>";
                    header('location: ../../vista/adm/dashboard/tabla_guia_entrada.php');
                }else{

                    $insert = "INSERT INTO guia_de_entrada(fecha_entrada,descripcion, cantidad_entrada,producto, provedor, activo) VALUES('$fecha_entrada','$descripcion', '$cantidad_entrada', '$producto', '$provedor','$activo')";
                    mysqli_query($conn, $insert);

                    header('location: ../../vista/adm/dashboard/tabla_guia_entrada.php');
                }
            break;
            case "btnModificar":
                //falta implementar más...

                $update = "UPDATE guia_de_entrada SET fecha_entrada='$fecha_entrada',descripcion='$descripcion',cantidad_entrada='$cantidad_entrada', producto='$producto', provedor='$provedor',activo='$activo' WHERE id_guia_entrada='$id_guia_entrada'";
                mysqli_query($conn, $update);

                header('location: ../../vista/adm/dashboard/tabla_guia_entrada.php');
            break;
        case "btnEliminar":
                //Listo.
                $delete = "DELETE FROM guia_de_entrada WHERE id_guia_entrada = '$id_guia_entrada'";
                mysqli_query($conn,$delete);
                header('location: ../../vista/adm/dashboard/tabla_guia_entrada.php');
            break;
        case "btnCancelar":
            header('location: ../../vista/adm/dashboard/tabla_guia_entrada.php');
            break;

        case "Seleccionar":
            $pass="disabled";
            $accionAgregar="disabled";
            $accionModificar = $accionEliminar = $accionCancelar = "";
            $mostrarModal= true;
            break;
    }
?>