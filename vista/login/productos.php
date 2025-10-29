<?php
    @include '../../modelo/configuracion.php';
    @include '../../modelo/conexion.php';
    error_reporting(0);
    //session_destroy();

    $db = new Database();
    $con = $db->Conexion();

    $sql = $con->prepare("SELECT id_producto, nombre_producto, descripcion_producto, precio_producto FROM producto WHERE activo=1");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Productos - Ambar Veterinaria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/principal/icon-ambar.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c174601175.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Asap:wght@800&family=Lobster&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200&display=swap');
    </style>
    <link href="../css/principal/servicios.css" type="text/css" rel="stylesheet"/>
    <link href="../css/principal/productos.css" type="text/css" rel="stylesheet"/>
    
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
                            <li class="nav-item h5 ms-4"><a  class="nav-link" href="user_page.php">Inicio</a></li>
                            <li class="nav-item h5 ms-4"><a class="nav-link" href="SOBRE.php">Sobre Nosotros</a></li>
                            <li class="nav-item h5 ms-4"><a class="nav-link" href="SERVICIOS.php">Servicios</a></li>
                            <li class="nav-item h5 ms-4"><a class="nav-link" href="BLOG.php">Blog</a></li>
                            <li class="nav-item h5 ms-4"><a class="nav-link" href="productos.php">Productos</a></li>

                        
                        </ul>
                    </div>
                    <ul class="navbar-nav ms-3">
                        <li class="nav-item h5 ms-5 ml-5"><a  class="nav-link" href="#">Bienvenido <?php echo $_SESSION['user_name'] ?></a></li>
                        <div class="dropdown show">
                            <li class="nav-item">
                                <i class="nav-link text-nowrap fa-regular fa-user fa-2xl dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" type="button" aria-expanded="false"></i></a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                            </ul>
                            </li>
                        </div>
                    </ul>    
                    <ul class="navbar-nav ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-nowrap" href="checkout.php"><i class="fa-solid fa-cart-shopping fa-2xl"></i><span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span></a>
                        </li>
                    </ul>   
                </div>
            </nav>
        </div>   
    <!-- --------------------------------------------------------------------------------------------------- -->

    <!-- -------------------------------------   CONTENEDORES productos   ------------------------------------ -->
    <main>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php
                    foreach ($resultado as $row){ ?>
                        <div class="col">
                            <div class="card shadow-sm">
                                <?php
                                    $id = $row['id_producto'];
                                    $imagen="../imagenes/productos/" .$id. "/principal.png";

                                    if(!file_exists($imagen)){
                                        $imagen = "../imagenes/no-photo.jpg";
                                    }

                                ?>


                                <img src="<?php echo $imagen; ?>" alt="">
                                <div class="card-body">

                                    <h5 class="card-title"><?php echo $row['nombre_producto']; ?></h5>
                                    <!-- <p class="card-text"><?php echo $row['marca_producto']; ?></p> -->
                                    <!-- <p class="card-text"><?php echo $row['descripcion_producto']; ?></p> -->
                                    <p class="card-text">S/. <?php echo number_format($row['precio_producto'], 2, '.', ',') ; ?></p>
                                    <div class="d-flex justify-content-between align-items-center">

                                        <div class="btn-group">
                                            <a href="detalles.php?id_producto=<?php echo $row['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $row['id_producto'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                                        </div>
                                        <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php  echo $row['id_producto']; ?>, '<?php  echo hash_hmac('sha1', $row['id_producto'], KEY_TOKEN); ?>')">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } 
                ?>  
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script>
        
        function addProducto(id, token){
            let url = '../../controlador/carrito/carrito.php'
            let formData = new FormData()
            formData.append('id_producto', id)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })  
        }
    </script>
    <!-- ---------------------------------------------------------------------------------------------------->

    <!-- --------------------------------------   FOOTER   ----------------------------------------------- -->
    <footer class="bg-dark text-center text-white mt-5">
        <!-- Grid container -->
        <div class="container p-5">
        
            <!-- Section: Links -->
            <section class="">
                <!--Grid row-->
                <div class="row">
                <!--Grid column-->
                
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Horarios de Atención</h5>
            
                        <ul class="list-unstyled mb-0">
                        <li>
                            <a class="text-white text-decoration-none">Lunes a Sábados</a>
                        </li>
                        <li>
                            <a class="text-white text-decoration-none">08:00 - 20:00 hrs</a>
                        </li>
                        <li>
                            <font style="font-size:0px"><a display="none" href="#!" class="text-white">aa</a></font>
                        </li>
                        <li>
                            <a class="text-white text-decoration-none">Domingos</a>
                        </li>
                        <li>
                            <a class="text-white text-decoration-none">09:00 - 20:00 hrs</a>
                        </li>
                        </ul>
                    </div>
                    <!--Grid column-->
            
                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Enlaces de sitio</h5>
            
                        <ul class="list-unstyled mb-0">
                        <li>
                            <a href="index.html" class="text-white text-decoration-none">Inicio</a>
                        </li>
                        <li>
                            <a href="vista/principal/SOBRE.html" class="text-white text-decoration-none">Sobre Nosotros</a>
                        </li>
                        <li>
                            <a href="vista/principal/SERVICIOS.HTML" class="text-white text-decoration-none">Servicios</a>
                        </li>
                        </ul>
                    </div>
                    <!--Grid column-->
            
                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Servicios</h5>
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a  class="text-white text-decoration-none">Baños y estetica</a>
                            </li>
                            <li>
                                <a  class="text-white text-decoration-none">Vacunación</a>
                            </li>
                            <li>
                                <a  class="text-white text-decoration-none">Cirugía</a>
                            </li>
                            <li>
                                <a  class="text-white text-decoration-none">Analisis de Laboratorio</a>
                            </li>
                            <li>
                                <a  class="text-white text-decoration-none">Radiografías y diagnóstico</a>
                            </li>
                            <li>
                                <a  class="text-white text-decoration-none">Cuidados intensivos</a>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->
            
                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Contacto</h5>
            
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="#!" class="text-white text-decoration-none"><i class="fa-solid fa-envelope"></i> ambarveterinaria@gmail.com</a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?phone=%2B51937088722&data=AWBo416Lm1Bos9cr4XlX_dqQC31OSyL9fUTuFtVqf6CLzdlJ1Ml9BeFb8knhoIjWGzbiipxxil75kTwzUYmukwj3ikHiCqDAX_Yz2ZETDYoZlIF-kvAzYbtJ2vteB-SPuATGoCbyZh53MhoFpumazPL5q0GG-PPpmLP4bKIcyF46ht1jce48cUJP74ydg4mZnsAqrNGG1FBYMhnsu3qcejevRdpLME71A9M9I66LnuI8N1GCBY4y-9tdY4Y6zs74b5c4gNaKkMR-XChXj6n6NaA45ZokkZagQ3ktPBwWbULDXOX6bNE&source=FB_Page&app=facebook&entry_point=page_cta&fbclid=IwAR21hzyX6eUw3ojTd1mOwhs9_nL0r-k9ORHwYuHH6lQi2h30Jmt8bFarnFw" class="text-white text-decoration-none"><i class="fa-solid fa-phone"></i> +51 937 088 722</a>
                            </li>
                            <li>
                                <a href="https://maps.google.com/maps/dir//%C3%81mbar+Cl%C3%ADnica+Veterinaria+Sede+Principal+Sector+1,+Grupo+21,+Manzana+C,+Lote+12+Frente+al+mercado+12+de+mayo+Av.micaela+bastidas+s%2Fn+Villa+El+Salvador+Gobierno+Regional+de+Lima+LIMA+42/@-12.191812,-76.956365,16z/data=!4m5!4m4!1m0!1m2!1m1!1s0x9105b90ce3845f85:0xfce792d60db4020f" class="text-white text-decoration-none"><i class="fa-solid fa-location-dot"></i> Av. Micaela Bastidas mz. C. Villa el Salvador. Lima. Perú.</a>
                            </li>
                        </ul>
                    </div>
                <!--Grid column-->
                </div>
                <!--Grid row-->
            </section>
            <!-- Section: Links -->
            <!-- Section: Social media -->
            <br>
            <section class="mb-4">
                <!-- Facebook -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://www.facebook.com/ambarclinicasveterinarias/" role="button" target="_blank"
                ><i class="fab fa-facebook-f fa-xl"></i
                ></a>
        
                <!-- Instagram -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://instagram.com/ambarclinicaveterinaria?igshid=MzRlODBiNWFlZA==" role="button" target="_blank"
                ><i class="fab fa-instagram fa-xl"></i
                ></a>
        
                <!-- Tiktok -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://www.tiktok.com/@ambar_veterinaria?_t=8d5kU4xzjIj&_r=1" role="button" target="_blank"
                ><i class="fab fa-tiktok"></i
                ></a>
            </section>
            <!-- Section: Social media -->
        </div>
        <!-- Grid container -->
    
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2023 Copyright:
        <a class="text-white text-decoration-none">Ambar - Todos los derechos reservados.</a>
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