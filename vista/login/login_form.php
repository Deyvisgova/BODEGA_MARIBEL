<?php
   include "../../controlador/controlador_login/controlador_login_form.php";
   include "../../controlador/controlador_adm/controlador_login_form_adm.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="../imagenes/principal/makro.ico" type="image/x-icon">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/base.css">
   <link rel="stylesheet" href="../css/auth.css">
   <script src="https://kit.fontawesome.com/73c70fe811.js" crossorigin="anonymous"></script>
   <title>Login Bodega Maribel</title>
</head>
<body class="auth-body">
    <!-- --------------------------------------   BARRA DE NAVEGACION   ------------------------------------ -->
    <div class="sticky-top">
       <nav class="navbar navbar-expand-lg navbar-dark bg-login border-bottom sticky-top">
  <div class="container-fluid">

    <!-- BRAND -->
    <a href="../../index.php" class="navbar-brand d-flex align-items-center gap-2 ms-2">
      <img class="img-logo" src="../imagenes/fondo.png" alt="Bodega Maribel">
      <span class="fw-semibold d-none d-sm-inline">Bodega Maribel</span>
    </a>

    <!-- TOGGLER -->
    <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse"
            data-bs-target="#MenuNavegacion" aria-controls="MenuNavegacion"
            aria-expanded="false" aria-label="Abrir menú">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENÚ -->
    <div id="MenuNavegacion" class="collapse navbar-collapse">
      <!-- IZQUIERDA -->
      <ul class="navbar-nav ms-2">
        <li class="nav-item">
          <a class="nav-link" href="../../index.php">
            <i class="fa-solid fa-house"></i> <span class="ms-1">Inicio</span>
          </a>
        </li>
      </ul>

      <!-- DERECHA -->
      <ul class="navbar-nav ms-auto me-2 align-items-center">
        <!-- (Opcional) Ayuda -->
        <li class="nav-item me-1 d-none d-md-block">
          <a class="nav-link" href="#"><i class="fa-regular fa-circle-question"></i> Ayuda</a>
        </li>

        <!-- Usuario -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
             href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-regular fa-user"></i> Acceso
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
            <li>
              <a class="dropdown-item" href="login_form.php">
                <i class="fa-solid fa-right-to-bracket me-2"></i> Iniciar sesión
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>

  </div>
</nav>

    </div>
</section>
<div class="form-container">

   <form action="" method="post">
      <h3>INICIAR SESION</h3>
      <?php
        if(isset($error)){
            foreach($error as $error){
                echo '<span class="error-msg">'.$error.'</span>';
            };
        }else if($errorr){
            foreach($errorr as $errorr){
                echo '<span class="error-msg">'.$errorr.'</span>';
            };
        };
      ?>
      <input type="email" name="email" required placeholder="Ingresa tu correo">
      <input type="password" name="password" required placeholder="Ingresa tu contraseña">
      <input type="submit" name="submit" value="Ingresar" class="form-btn">
   </form>

</div>

<!-- =============== FOOTER LOGIN =============== -->
<footer class="footer-login text-white mt-5">
  <div class="container py-4">
    <div class="row align-items-center text-center text-md-start">
      
      <!-- Logo -->
      <div class="col-md-4 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start align-items-center gap-2">
        <img src="../imagenes/fondo.png" alt="Bodega Maribel" class="footer-logo">
        <h6 class="mb-0 fw-bold">Bodega Maribel</h6>
      </div>

      <!-- Texto central -->
      <div class="col-md-4 text-center small">
        © 2025 <strong>Bodega Maribel</strong> — Todos los derechos reservados.
      </div>

      <!-- Redes sociales -->
      <div class="col-md-4 d-flex justify-content-center justify-content-md-end gap-3">
        <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
        <a href="#" class="social-icon"><i class="fa-brands fa-whatsapp"></i></a>
      </div>
    </div>
  </div>
</footer>
<!-- =============== /FOOTER LOGIN =============== -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    
</body>
</html>
