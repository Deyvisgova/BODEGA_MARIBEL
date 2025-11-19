<?php

require_once __DIR__ . '/../../modelo/config.php';
error_reporting(0);

$registroAdminErrores = $registroAdminErrores ?? [];
$registroAdminExito = $registroAdminExito ?? '';

if(isset($_POST['registrar_admin'])){


    $dni_adm = mysqli_real_escape_string($conn, $_POST['dni_adm'] ?? '');
    $nombre_adm = mysqli_real_escape_string($conn, $_POST['nombre_adm'] ?? '');
    $apellido_adm = mysqli_real_escape_string($conn, $_POST['apellido_adm'] ?? '');
    $genero_adm = mysqli_real_escape_string($conn, $_POST['genero_adm'] ?? '');
    $direccion_adm = mysqli_real_escape_string($conn, $_POST['direccion_adm'] ?? '');
    $telefono_adm = mysqli_real_escape_string($conn, $_POST['telefono_adm'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email_adm'] ?? '');
    $pass = md5($_POST['password_adm'] ?? '');
    $cpass = md5($_POST['cpassword_adm'] ?? '');

    $select = "SELECT 1 FROM administrador WHERE email = '$email' LIMIT 1";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){

       $registroAdminErrores[] = 'El correo ya está registrado.';

    }else{

       if($pass != $cpass){
          $registroAdminErrores[] = 'La contraseña no coincide!';
       }else if (!preg_match("/^[\d]{1,3}\.?[\d]{3,3}\.?[\d]{3,3}$/", $_POST['dni_adm'] ?? '')){
         $registroAdminErrores[] = 'El Dni tiene que ser de 7 a 9 dígitos!';

       }else if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,40}$/", $_POST['nombre_adm'] ?? '')){
         $registroAdminErrores[] = 'El nombre debe ser de 3 a 40 caracteres!';

       }else if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,40}$/", $_POST['apellido_adm'] ?? '')){
         $registroAdminErrores[] = 'El apellido debe ser de 3 a 40 caracteres!';

       }else if (!preg_match("/^[a-zA-Z0-9\ \-\_]{4,100}$/", $_POST['direccion_adm'] ?? '')){
         $registroAdminErrores[] = 'Ha introducido una direccion no valida!';

       }else if (!preg_match("/^\d{7,14}$/", $_POST['telefono_adm'] ?? '')){
         $registroAdminErrores[] = 'El telefono debe ser de 7 a 14 dígitos!';

       }else if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $_POST['email_adm'] ?? '')){
         $registroAdminErrores[] = 'Ha introducido un correo no valido!';

       }else if (!preg_match("/^.{3,12}$/", $_POST['password_adm'] ?? '')){
         $registroAdminErrores[] = 'La contraseña debe ser de 3 a 12 digitos!';
       }
       else{
          $insert = "INSERT INTO administrador(dni_adm, nombre_adm, apellido_adm, genero_adm, direccion_adm, telefono_adm, email, password, user_type) VALUES('$dni_adm','$nombre_adm','$apellido_adm','$genero_adm','$direccion_adm','$telefono_adm','$email','$pass','admin')";
          mysqli_query($conn, $insert);
          $registroAdminExito = 'Administrador registrado correctamente.';
       }
    }

};
?>