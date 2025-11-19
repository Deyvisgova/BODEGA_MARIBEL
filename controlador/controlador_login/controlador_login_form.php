<?php

@include '../../modelo/config.php';
error_reporting(0);
session_start();

$errorr = [];

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);

   $erroresValidacion = [];

   if(trim($_POST['email']) === ''){
      $erroresValidacion[] = 'email no puede estar vacio!';
   }else if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-.]+$/", $_POST['email'])){
      $erroresValidacion[] = 'Ha introducido un email no valido!';
   }

   if(trim($_POST['password']) === ''){
      $erroresValidacion[] = 'Contraseña no puede estar vacio!';
   }

   if(empty($erroresValidacion)){
      $adminQuery = "SELECT nombre_adm AS nombre, user_type, password FROM administrador WHERE email = '$email' LIMIT 1";
      $adminResult = mysqli_query($conn, $adminQuery);

      if(mysqli_num_rows($adminResult) > 0){
         $row = mysqli_fetch_array($adminResult);
         if($row['password'] === $pass && strtolower($row['user_type']) === 'admin'){
            $_SESSION['admin_name'] = $row['nombre'];
            header('location:../adm/dashboard/dashboard.php');
            exit;
         }
      }

      $colabQuery = "SELECT nombre_colab AS nombre, user_type, password FROM colaborador WHERE email = '$email' LIMIT 1";
      $colabResult = mysqli_query($conn, $colabQuery);

      if(mysqli_num_rows($colabResult) > 0){
         $row = mysqli_fetch_array($colabResult);
         if($row['password'] === $pass && strtolower($row['user_type']) === 'colab'){
            $_SESSION['colab_name'] = $row['nombre'];
            header('location:../adm/dashboard/dashboardColaborador.php');
            exit;
         }
      }

      $errorr[] = 'Correo o contraseña equivocada!';
   }else{
      $errorr = $erroresValidacion;
   }
};
?>
