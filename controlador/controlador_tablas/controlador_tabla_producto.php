<?php
    @include '../../modelo/config.php';

    $id_producto = (isset($_POST['id_producto']))?$_POST['id_producto']:"";
    $nombre_producto = (isset($_POST['nombre_producto']))?$_POST['nombre_producto']:"";
    $descripcion = (isset($_POST['descripcion']))?$_POST['descripcion']:"";
    $categoria = (isset($_POST['categoria']))?$_POST['categoria']:"";
    $activo = (isset($_POST['activo']))?$_POST['activo']:"";
    $provedor = (isset($_POST['provedor']))?$_POST['provedor']:"";


    $accionAgregar="";
    $accionModificar = $accionEliminar = $accionCancelar = "disabled";
    $mostrarModal = false;

    $accion= (isset($_POST['accion']))?$_POST['accion']:"";
    switch($accion){
        case "btnAgregar":
                $select = "SELECT * FROM producto WHERE nombre_producto = '$nombre_producto'";
                $result = mysqli_query($conn, $select);
                if(mysqli_num_rows($result) > 0){
                    echo "<script> alert('¡Cuenta existente!')</script>";
                    header('location: ../../vista/adm/dashboard/tabla_producto.php');
                }else{

                    $descripcionSegura = mysqli_real_escape_string($conn, $descripcion);

                    $insert = "INSERT INTO producto(nombre_producto, descripcion, stock_actual, cantidad, precio_producto,categoria, activo, provedor) VALUES('$nombre_producto', '$descripcionSegura', 0, 0, 0, '$categoria', '$activo','$provedor')";
                    mysqli_query($conn, $insert);

                    header('location: ../../vista/adm/dashboard/tabla_producto.php');
                }
            break;
            case "btnModificar":
                //falta implementar más...

                $descripcionSegura = mysqli_real_escape_string($conn, $descripcion);

                $update = "UPDATE producto SET nombre_producto='$nombre_producto', descripcion='$descripcionSegura', categoria='$categoria', activo='$activo',provedor='$provedor' WHERE id_producto='$id_producto'";
                mysqli_query($conn, $update);

                header('location: ../../vista/adm/dashboard/tabla_producto.php');
            break;
        case "btnEliminar":
                //Listo.
                $delete = "DELETE FROM producto WHERE id_producto = '$id_producto'";
                mysqli_query($conn,$delete);
                header('location: ../../vista/adm/dashboard/tabla_producto.php');
            break;
        case "btnCancelar":
            header('location: ../../vista/adm/dashboard/tabla_producto.php');
            break;

        case "Seleccionar":
            $pass="disabled";
            $accionAgregar="disabled";
            $accionModificar = $accionEliminar = $accionCancelar = "";
            $mostrarModal= true;
            break;
    }
?>