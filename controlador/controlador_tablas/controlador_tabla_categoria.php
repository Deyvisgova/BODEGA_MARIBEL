<?php
    @include '../../modelo/config.php';

    $id_categoria = (isset($_POST['id_categoria']))?$_POST['id_categoria']:"";
    $nombre_categoria = (isset($_POST['nombre_categoria']))?$_POST['nombre_categoria']:"";

    $accionAgregar="";
    $accionModificar = $accionEliminar = $accionCancelar = "disabled";
    $mostrarModal = false;

    $accion= (isset($_POST['accion']))?$_POST['accion']:"";
    switch($accion){
        case "btnAgregar":
                $select = "SELECT * FROM categoria WHERE nombre_categoria = '$nombre_categoria'";
                $result = mysqli_query($conn, $select);
                if(mysqli_num_rows($result) > 0){
                    echo "<script> alert('¡Cuenta existente!')</script>";
                    header('location: ../../vista/adm/dashboard/tabla_categoria.php');
                }else{

                    $insert = "INSERT INTO categoria (nombre_categoria) VALUES('$nombre_categoria')";
                    mysqli_query($conn, $insert);

                    header('location: ../../vista/adm/dashboard/tabla_categoria.php');
                }
            break;
            case "btnModificar":
                //falta implementar más...

                $update = "UPDATE categoria SET nombre_categoria='$nombre_categoria' WHERE id_categoria='$id_categoria'";
                mysqli_query($conn, $update);

                header('location: ../../vista/adm/dashboard/tabla_categoria.php');
            break;
        case "btnEliminar":
                //Listo.
                $delete = "DELETE FROM categoria WHERE id_categoria = '$id_categoria'";
                mysqli_query($conn,$delete);
                header('location: ../../vista/adm/dashboard/tabla_categoria.php');
            break;
        case "btnCancelar":
            header('location: ../../vista/adm/dashboard/tabla_categoria.php');
            break;

        case "Seleccionar":
            $pass="disabled";
            $accionAgregar="disabled";
            $accionModificar = $accionEliminar = $accionCancelar = "";
            $mostrarModal= true;
            break;
    }
?>