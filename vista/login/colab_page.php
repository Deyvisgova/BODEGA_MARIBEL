<?php

@include '../../modelo/config.php';

session_start();

if(!isset($_SESSION['colab_name'])){
   header('location:login_form.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link rel="icon" href="../imagenes/principal/makro.ico" type="image/x-icon">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Panel de Colaboradores - Bodega Maribel</title>

   <link rel="stylesheet" href="../css/base.css">
   <link rel="stylesheet" href="../css/auth.css">

</head>
<body class="auth-body">

<div class="auth-welcome">

   <div class="auth-welcome__card">
      <h3>Hola, <span>colaborador</span></h3>
      <h1>Bienvenido <span><?php echo $_SESSION['colab_name'] ?></span></h1>
      <p>Gestiona pedidos y movimientos de almacén para Bodega Maribel.</p>
      <a href="login_form.php" class="btn">Iniciar sesión</a>
      <a href="logout.php" class="btn">Cerrar sesión</a>
   </div>

</div>

</body>
</html>
