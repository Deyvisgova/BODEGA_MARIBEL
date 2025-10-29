<?php

session_start();

if(isset($_SESSION['nombre_colab'])){
   header('location:login_form.php');
}
?>
<html lang="es">
<!-- BARRA DE NAV EMPIEZA EN LA FILA 	pag 169-->
<!-- Recuperar nombre del admninitrador pag 338-->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://kit.fontawesome.com/73c70fe811.js" crossorigin="anonymous"></script>
    <link rel="icon" href="../../imagenes/principal/makro.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <title>Colaborador Bodega Maribel</title>

    <!-- Custom fonts for this template-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css?asd" rel="stylesheet">
    <link href="css/reloj.css" rel="sytlesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <?php
        @include 'sidebarColaborador.php';
        @include 'navbarColaborador.php';
        ?>
    </div>
    <div class="container">
        <?php
        @include '../../../controlador/controlador_tablas/controlador_cambiar_contraseña.php';
        $select = "SELECT * FROM colaborador";
        $tabla = mysqli_query($conn, $select);
        ?>
        <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; text-align: center; font-weight: 600;">Cambiar Contraseña</h3>
        <hr>

        <form action="../../../controlador/controlador_tablas/controlador_cambiar_contraseña.php" method="post">

            <!-- Modal -->
            <section>

            <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>


    <?php
    // Mostrar errores si los hay
    if (!empty($error)) {
        foreach ($error as $e) {
            echo "<p style='color: red;'>$e</p>";
        }
    }
    ?>
<?php
        include '../../../controlador/controlador_tablas/controlador_cambiar_contraseña.php';
        ?>
        <style>
      

        

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
        }
        .Cam_contra{
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border-radius: 16px;
        }
        input[type="submit"] {
            padding: 20px;
            border-radius: 20px;
            background-color: #d32f2f;
            color: #fff;
            cursor: pointer;
        }

       
    </style>
<form action="../../../controlador/controlador_tablas/controlador_cambiar_contraseña.php" method="post">
        <label class="Cam_contra" for="email">Correo Electrónico:</label>
        <input class="Cam_contra"  type="email" name="email" required> <br>

        <label  class="Cam_contra" for="old_password">Contraseña Actual:</label>
        <input  class="Cam_contra" type="password" name="old_password" required> <br>

        <label class="Cam_contra"  for="new_password">Nueva Contraseña:</label>
        <input class="Cam_contra"  type="password" name="new_password" required><br>

        <label class="Cam_contra"  for="confirm_new_password">Confirmar Nueva Contraseña:</label>
        <input class="Cam_contra"  type="password" name="confirm_new_password" required><br>

        <input type="submit" name="submit" value="Cambiar Contraseña">
    </form>

</body>
</html>

            </section>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="../../js/busqueda.js"></script>


</body>

</html>