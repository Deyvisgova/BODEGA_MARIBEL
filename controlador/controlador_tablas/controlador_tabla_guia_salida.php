<?php
    @include '../../modelo/config.php';

    $id_guia_salida = (isset($_POST['id_guia_salida']))?$_POST['id_guia_salida']:"";
    $fecha_salida = (isset($_POST['fecha_salida']))?$_POST['fecha_salida']:"";
    $descripcion = (isset($_POST['descripcion']))?$_POST['descripcion']:"";
    $cantidad_salida = (isset($_POST['cantidad_salida']))?$_POST['cantidad_salida']:"";
    $producto = (isset($_POST['producto']))?$_POST['producto']:"";
    $destino = (isset($_POST['destino']))?$_POST['destino']:"";
    $encargado = (isset($_POST['encargado']))?$_POST['encargado']:"";
    $activo = (isset($_POST['activo']))?$_POST['activo']:"";


    $accionAgregar="";
    $accionModificar = $accionEliminar = $accionCancelar = "disabled";
    $mostrarModal = false;

    $accion= (isset($_POST['accion']))?$_POST['accion']:"";
    switch($accion){
        case "btnAgregar":
                $select = "SELECT * FROM guia_de_salida WHERE id_guia_salida = '$id_guia_salida'";
                $result = mysqli_query($conn, $select);
                if(mysqli_num_rows($result) > 0){
                    echo "<script> alert('¡Cuenta existente!')</script>";
                    header('location: ../../vista/adm/dashboard/tabla_guia_salida.php');
                }else{

                    $insert = "INSERT INTO guia_de_salida(fecha_salida,descripcion, cantidad_salida,producto, destino,encargado, activo) VALUES('$fecha_salida','$descripcion', '$cantidad_salida', '$producto', '$destino','$encargado','$activo')";
                    mysqli_query($conn, $insert);

                    header('location: ../../vista/adm/dashboard/tabla_guia_salida.php');
                }
            break;
            case "btnModificar":
                //falta implementar más...

                $update = "UPDATE guia_de_salida SET fecha_salida='$fecha_salida',descripcion='$descripcion',cantidad_salida='$cantidad_salida', producto='$producto', destino='$destino',encargado='$encargado', activo='$activo' WHERE id_guia_salida='$id_guia_salida'";
                mysqli_query($conn, $update);

                header('location: ../../vista/adm/dashboard/tabla_guia_salida.php');
            break;
        case "btnEliminar":
                //Listo.
                $delete = "DELETE FROM guia_de_salida WHERE id_guia_salida = '$id_guia_salida'";
                mysqli_query($conn,$delete);
                header('location: ../../vista/adm/dashboard/tabla_guia_salida.php');
            break;
        case "btnCancelar":
            header('location: ../../vista/adm/dashboard/tabla_guia_salida.php');
            break;

        case "Seleccionar":
            $pass="disabled";
            $accionAgregar="disabled";
            $accionModificar = $accionEliminar = $accionCancelar = "";
            $mostrarModal= true;
            break;
    }
?>