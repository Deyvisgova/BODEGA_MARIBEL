<?php
@include '../../modelo/config.php';
error_reporting(0);
session_start();

$id_provedor = $_POST['id_provedor'];
$Nombre_de_la_empresa = mysqli_real_escape_string($conn, $_POST['Nombre_de_la_empresa']);
$ruc = mysqli_real_escape_string($conn, $_POST['ruc']);
$Persona_de_Contacto = mysqli_real_escape_string($conn, $_POST['Persona_de_Contacto']);
$Numero_de_contacto = mysqli_real_escape_string($conn, $_POST['Numero_de_contacto']);
$correo_electronico = mysqli_real_escape_string($conn, $_POST['correo_electronico']);

$accionAgregar = "";
$accionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
switch ($accion) {

    case "btnAgregar":
        $insert = "INSERT INTO provedor (Nombre_de_la_empresa, ruc, Persona_de_Contacto, Numero_de_contacto, correo_electronico) VALUES ('$Nombre_de_la_empresa','$ruc','$Persona_de_Contacto','$Numero_de_contacto', '$correo_electronico')";
        mysqli_query($conn, $insert);

        header('location: ../../vista/adm/dashboard/tabla_provedor_colab.php');
        break;
    case "btnModificar":
        $update = "UPDATE provedor SET Nombre_de_la_empresa='$Nombre_de_la_empresa', ruc='$ruc', Persona_de_Contacto='$Persona_de_Contacto', Numero_de_contacto='$Numero_de_contacto', correo_electronico='$correo_electronico' WHERE id_provedor='$id_provedor'";
        mysqli_query($conn, $update);


        header('location: ../../vista/adm/dashboard/tabla_provedor_colab.php');
        break;
    case "btnEliminar":
        $delete = "DELETE FROM provedor WHERE id_provedor = '$id_provedor'";
        mysqli_query($conn, $delete);
        header('location: ../../vista/adm/dashboard/tabla_provedor_colab.php');
        break;
    case "btnCancelar":
        header('location: ../../vista/adm/dashboard/tabla_provedor_colab.php');
        break;
    case "Seleccionar":
        $pass = "readonly";
        $accionAgregar = "disabled";
        $accionModificar = $accionEliminar = $accionCancelar = "";
        $mostrarModal = true;
        break;
}
?>