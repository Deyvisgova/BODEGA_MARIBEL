<?php
    @include '../../modelo/config.php';

    $id_producto = (isset($_POST['id_producto']))?$_POST['id_producto']:"";
    $nombre_producto = (isset($_POST['nombre_producto']))?$_POST['nombre_producto']:"";
    $precio_producto = (isset($_POST['precio_producto']))?$_POST['precio_producto']:"";
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

                    $insert = "INSERT INTO producto(nombre_producto,cantidad, precio_producto,categoria, activo, provedor) VALUES('$nombre_producto',0, '$precio_producto', '$categoria', '$activo','$provedor')";
                    mysqli_query($conn, $insert);

                    header('location: ../../vista/adm/dashboard/tabla_producto.php');
                }
            break;
            case "btnModificar":
                //falta implementar más...

                $update = "UPDATE producto SET nombre_producto='$nombre_producto',precio_producto='$precio_producto', categoria='$categoria', activo='$activo',provedor='$provedor' WHERE id_producto='$id_producto'";
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