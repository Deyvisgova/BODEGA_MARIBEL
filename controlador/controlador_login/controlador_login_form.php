<?php

@include '../../modelo/config.php';
error_reporting(0);
session_start();

$loginErrors = $loginErrors ?? [];

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
   $passwordRaw = $_POST['password'] ?? '';

   if(trim($email) === ''){
      $loginErrors[] = 'El correo es obligatorio.';
   }else if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-.]+$/", $email)){
      $loginErrors[] = 'Ha introducido un email no valido!';
   }else if(trim($passwordRaw) === ''){
      $loginErrors[] = 'La contraseña no puede estar vacía!';
   }else{
      $password = md5($passwordRaw);

      $adminQuery = "SELECT nombre_adm AS nombre, user_type FROM administrador WHERE email = '$email' AND password = '$password' LIMIT 1";
      $adminResult = mysqli_query($conn, $adminQuery);

      if($adminResult && mysqli_num_rows($adminResult) > 0){
         $user = mysqli_fetch_assoc($adminResult);
         $_SESSION['admin_name'] = $user['nombre'];
         echo "<script> alert('Login exitoso')</script>";
         header('location:../adm/dashboard/dashboard.php');
         exit;
      }

      $colabQuery = "SELECT nombre_colab AS nombre, user_type FROM colaborador WHERE email = '$email' AND password = '$password' LIMIT 1";
      $colabResult = mysqli_query($conn, $colabQuery);

      if($colabResult && mysqli_num_rows($colabResult) > 0){
         $user = mysqli_fetch_assoc($colabResult);

         if($user['user_type'] === 'admin'){
            $_SESSION['admin_name'] = $user['nombre'];
            echo "<script> alert('Login exitoso')</script>";
            header('location:../adm/dashboard/dashboard.php');
            exit;
         }

         $_SESSION['colab_name'] = $user['nombre'];
         echo "<script> alert('Login exitoso')</script>";
         header('location:../adm/dashboard/dashboardColaborador.php');
         exit;
      }

      $loginErrors[] = 'Correo o contraseña equivocada!';
   }
}
?>
