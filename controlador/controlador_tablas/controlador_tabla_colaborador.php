<?php
    @include '../../modelo/config.php';
    error_reporting(0);

    $id_colab = (isset($_POST['id_colab']))?$_POST['id_colab']:"";
    $dni_colab = (isset($_POST['dni_colab']))?$_POST['dni_colab']:"";
    $nombre_colab = (isset($_POST['nombre_colab']))?$_POST['nombre_colab']:"";
    $apellido_colab = (isset($_POST['apellido_colab']))?$_POST['apellido_colab']:"";
    $genero_colab = (isset($_POST['genero_colab']))?$_POST['genero_colab']:"";
    $direccion_colab = (isset($_POST['direccion_colab']))?$_POST['direccion_colab']:"";
    $telefono_colab = (isset($_POST['telefono_colab']))?$_POST['telefono_colab']:"";
    $email = (isset($_POST['email']))?$_POST['email']:"";
    $pass = md5($_POST['pass'] ?? '');
    $user_type = (isset($_POST['user_type']))?$_POST['user_type']:"";



    $accionAgregar="";
    $accionModificar = $accionEliminar = $accionCancelar = "disabled";
    $mostrarModal = false;

    
        $accion= (isset($_POST['accion']))?$_POST['accion']:"";
        switch($accion){
            
            case "btnAgregar":
                $select = " SELECT * FROM colaborador WHERE dni_colab= '$dni_colab' AND email = '$email'";
                $result = mysqli_query($conn, $select);
                
                if(mysqli_num_rows($result) > 0){
                    echo "<script> alert('¡Cuenta existente!')</script>";
                    header('location: ../../vista/adm/dashboard/tabla_colaborador.php');
                }else{
                    //EL ID_CLINICA DEBE EXISTIR EN LA TABLA CLÍNICA, SINO NO AGREGA
                    $insert = "INSERT INTO colaborador(dni_colab, nombre_colab, apellido_colab, genero_colab, direccion_colab, telefono_colab, email, password, user_type) VALUES('$dni_colab','$nombre_colab','$apellido_colab','$genero_colab','$direccion_colab','$telefono_colab','$email','$pass','$user_type')";
                    mysqli_query($conn, $insert);

                    header('location: ../../vista/adm/dashboard/tabla_colaborador.php');
                }
                break;
            case "btnModificar":
                    //COMPLETADO.
                    $update = "UPDATE colaborador SET dni_colab='$dni_colab', nombre_colab='$nombre_colab', apellido_colab='$apellido_colab', genero_colab='$genero_colab', direccion_colab='$direccion_colab', telefono_colab='$telefono_colab', email='$email' WHERE id_colab='$id_colab'";
                    mysqli_query($conn, $update);
                    header('location: ../../vista/adm/dashboard/tabla_colaborador.php');
                break;
            case "btnEliminar":
                    //Completado mensaje de confirmación.
                    $delete = "DELETE FROM colaborador WHERE email = '$email'";
                    mysqli_query($conn,$delete);
                    header('location: ../../vista/adm/dashboard/tabla_colaborador.php');
                break;
            case "btnCancelar":
                header('location: ../../vista/adm/dashboard/tabla_colaborador.php');
                break;

            case "Seleccionar":
                $pass="readonly";
                $accionAgregar="disabled";
                $accionModificar = $accionEliminar = $accionCancelar = "";
                $mostrarModal= true;
                break;
        }
?>