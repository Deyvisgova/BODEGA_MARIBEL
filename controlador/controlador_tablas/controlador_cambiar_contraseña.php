<?php
@include '../../modelo/config.php';
error_reporting(0);

session_start();

if(isset($_SESSION['nombre_colab'])){
    header('location:login_form.php');
 }

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $old_password = md5($_POST['old_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_new_password = md5($_POST['confirm_new_password']);

    $select_user = "SELECT * FROM colaborador WHERE email = '$email' AND password = '$old_password'";
    $result_user = mysqli_query($conn, $select_user);

    if (mysqli_num_rows($result_user) > 0) {
        if ($new_password != $confirm_new_password) {
            $error[] = 'Las nuevas contraseñas no coinciden!';
        } else if (!preg_match("/^.{3,12}$/", $_POST['new_password'])) {
            $error[] = 'La nueva contraseña debe tener entre 3 y 12 caracteres!';
        } else {
            // Actualizar la contraseña del usuario
            $update_password = "UPDATE colaborador SET password = '$new_password' WHERE email = '$email'";
            mysqli_query($conn, $update_password);
            header('location: ../../vista/adm/dashboard/cambiar_contraseña_colab.php');

        }
    } else {
        $error[] = 'La contraseña actual no es correcta!';
    }
}
?>
