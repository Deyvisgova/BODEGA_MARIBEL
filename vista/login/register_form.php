
<?php
@include '../../modelo/config.php';
   include "../../controlador/controlador_login/controlador_register_form.php"
   
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="../../imagenes/principal/makro.ico" type="image/x-icon">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link href="../css/incio.css" type="text/css" rel="stylesheet" />
   <link rel="stylesheet" href="../css/login.css">
   <script src="https://kit.fontawesome.com/73c70fe811.js" crossorigin="anonymous"></script>
   <title>Crear Usuario - Bodega Maribel</title>
</head>
<body>
<!-- --------------------------------------   BARRA DE NAVEGACION   ------------------------------------ -->
<div class="sticky-top">
        <nav class="navbar navbar-expand-lg bg-danger navbar-dark border-5 border-bottom border-primary">
            <div class="container-fluid">
                <a href="#" class="navbar-brand ms-3"><img class="img-logo" src="../imagenes/fondo.png" width="240px"></a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#MenuNavegacion">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="MenuNavegacion" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-3">
                        <li class="nav-item h5 ms-4"><a class="nav-link" href="../adm/dashboard/dashboard.php">Regresar al Dashboard</a></li>
                                           
                    </ul>
                </div>
                <ul class="navbar-nav ms-3">
                <li class="nav-item h5 ms-5 ml-5"><a  class="nav-link" href="#">Administrador-<?php echo $_SESSION['admin_name'] ?></a></li>
                    <div class="dropdown show">
                    <li class="nav-item">
                        <i class="nav-link text-nowrap fa-regular fa-user fa-2xl dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" type="button" aria-expanded="false"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                    </div>
                </ul>    
                 
            </div>
        </nav>
    </div>
</section>
<div class="form-container">

   <form action="" method="post">
      <h3>Crear Usuario</h3>
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
      <input type="text" name="dni_colab" required placeholder="Digita tu DNI">
      <input type="text" name="nombre_colab" required placeholder="Digita tu nombre">
      <input type="text" name="apellido_colab" required placeholder="Digita tus apellidos">
      <select name="genero_colab">
         <option value="Masculino">Masculino</option>
         <option value="Femenino">Femenino</option>
      </select>
      <input type="text" name="direccion_colab" required placeholder="Digita tu direccion">
      <input type="text" name="telefono_colab" required placeholder="Digita tu telefono">
      <input type="email" name="email" required placeholder="Digita tu correo">
      <input type="password" name="password" required placeholder="Digita tu contraseña">
      <input type="password" name="cpassword" required placeholder="Repita su contraseña">
        <select class="usernose" name="user_type">
         <option value="colab">colab</option>
         
    </select> 
    <p><input type="submit" name="submit" value="Crear cuenta" class="form-btn"> <a href="../adm/dashboard/dashboard.php"></p>
     
      
      <p>Ya tienes una cuenta? <a href="login_form.php">Inicia Sesion</a></p>
   </form>

</div>
<!-- --------------------------------------------------------------------------------------------------- -->
<!-- --------------------------------------   FOOTER   ------------------------------------ -->
<footer class="bg-dark text-center text-white mt-5">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2025 Copyright:
        <a class="text-white text-decoration-none">Bodega Maribel - Todos los derechos reservados.</a>
        </div>
        <!-- Copyright -->
    </footer>
<!-- ---------------------------------------------------------------------------------------------------->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    
</body>
</html>
</body>
</html>