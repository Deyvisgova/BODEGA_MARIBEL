<?php

@include '../../modelo/config.php';
error_reporting(0);

$registroColaboradorErrores = $registroColaboradorErrores ?? [];
$registroColaboradorExito = $registroColaboradorExito ?? '';

if(isset($_POST['registrar_colaborador'])){


    $dni_colab = mysqli_real_escape_string($conn, $_POST['dni_colab'] ?? '');
    $nombre_colab = mysqli_real_escape_string($conn, $_POST['nombre_colab'] ?? '');
    $apellido_colab = mysqli_real_escape_string($conn, $_POST['apellido_colab'] ?? '');
    $genero_colab = mysqli_real_escape_string($conn, $_POST['genero_colab'] ?? '');
    $direccion_colab = mysqli_real_escape_string($conn, $_POST['direccion_colab'] ?? '');
    $telefono_colab = mysqli_real_escape_string($conn, $_POST['telefono_colab'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email_colab'] ?? '');
    $pass = md5($_POST['password_colab'] ?? '');
    $cpass = md5($_POST['cpassword_colab'] ?? '');

    $select = "SELECT 1 FROM colaborador WHERE email = '$email' LIMIT 1";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){

       $registroColaboradorErrores[] = 'El correo ya está registrado.';

    }else{

       if($pass != $cpass){
          $registroColaboradorErrores[] = 'La contraseña no coincide!';
       }else if (!preg_match("/^[\d]{1,3}\.?[\d]{3,3}\.?[\d]{3,3}$/", $_POST['dni_colab'] ?? '')){
         $registroColaboradorErrores[] = 'El Dni tiene que ser de 7 a 9 dígitos!';

       }else if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,40}$/", $_POST['nombre_colab'] ?? '')){
         $registroColaboradorErrores[] = 'El nombre debe ser de 3 a 40 caracteres!';

       }else if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,40}$/", $_POST['apellido_colab'] ?? '')){
         $registroColaboradorErrores[] = 'El apellido debe ser de 3 a 40 caracteres!';

       }else if (!preg_match("/^[a-zA-Z0-9\ \-\_]{4,100}$/", $_POST['direccion_colab'] ?? '')){
         $registroColaboradorErrores[] = 'Ha introducido una direccion no valida!';

       }else if (!preg_match("/^\d{7,14}$/", $_POST['telefono_colab'] ?? '')){
         $registroColaboradorErrores[] = 'El telefono debe ser de 7 a 14 dígitos!';

       }else if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $_POST['email_colab'] ?? '')){
         $registroColaboradorErrores[] = 'Ha introducido un correo no valido!';

       }else if (!preg_match("/^.{3,12}$/", $_POST['password_colab'] ?? '')){
         $registroColaboradorErrores[] = 'La contraseña debe ser de 3 a 12 digitos!';
       }
       else{
          $insert = "INSERT INTO colaborador(dni_colab, nombre_colab, apellido_colab, genero_colab, direccion_colab, telefono_colab, email, password, user_type) VALUES('$dni_colab','$nombre_colab','$apellido_colab','$genero_colab','$direccion_colab','$telefono_colab','$email','$pass','colab')";
          mysqli_query($conn, $insert);
          $registroColaboradorExito = 'Colaborador registrado correctamente.';
       }
    }

};
?>