<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Bodega Maribel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="icon"
      href="vista/imagenes/principal/makro.ico"
      type="image/x-icon"
    />
    <link href="vista/css/incio.css" type="text/css" rel="stylesheet" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <script
      src="https://kit.fontawesome.com/73c70fe811.js"
      crossorigin="anonymous"
    ></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Asap:wght@800&family=Lobster&display=swap");
      @import url("https://fonts.googleapis.com/css2?family=Kanit:wght@200&display=swap");
      .navbar.border-bottom {
        border-bottom: 4px solid #f30101 !important; /* cambia el color y grosor aquí */
      }
    </style>
  </head>
  <body>
    <!-- --------------------------------------   BARRA DE NAVEGACION   ------------------------------------ -->
    <div class="sticky-top">
      <!-- ============ NAVBAR ============ -->
      <nav
        class="navbar navbar-expand-lg navbar-dark bg-verde-bajito border-bottom border-verde sticky-top"
      >
        <div class="container-fluid">
          <!-- BRAND -->
          <a
            href="index.php"
            class="navbar-brand d-flex align-items-center gap-2"
          >
            <img
              src="vista/imagenes/fondo.png"
              alt="Bodega Maribel"
              class="img-logo"
            />
            <span class="fw-semibold d-none d-sm-inline">Bodega Maribel</span>
          </a>

          <!-- TOGGLER -->
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarMain"
            aria-controls="navbarMain"
            aria-expanded="false"
            aria-label="Abrir menú"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- MENU -->
          <div class="collapse navbar-collapse" id="navbarMain">
            <!-- IZQUIERDA -->
            <ul class="navbar-nav me-auto align-items-lg-center">
              <li class="nav-item">
                <a class="nav-link active" href="index.php">
                  <i class="fa-solid fa-house"></i>
                  <span class="ms-1">Inicio</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="index.php?ruta=productos">
                  <i class="fa-solid fa-cubes"></i>
                  <span class="ms-1">Productos</span>
                </a>
              </li>

              <!-- Dropdown categorías -->
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="ddCategorias"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i class="fa-solid fa-list"></i>
                  <span class="ms-1">Categorías</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="ddCategorias">
                  <li>
                    <a class="dropdown-item" href="#"
                      ><i class="fa-solid fa-wine-bottle me-2"></i>Bebidas</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="#"
                      ><i class="fa-solid fa-bread-slice me-2"></i>Panadería</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="#"
                      ><i class="fa-solid fa-cheese me-2"></i>Lácteos</a
                    >
                  </li>
                  <li><hr class="dropdown-divider" /></li>
                  <li>
                    <a class="dropdown-item" href="#"
                      ><i class="fa-solid fa-tags me-2"></i>Ofertas</a
                    >
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fa-solid fa-phone"></i>
                  <span class="ms-1">Contacto</span>
                </a>
              </li>
            </ul>

            <!-- DERECHA -->
            <div class="d-flex align-items-center gap-2">
              <!-- BUSCADOR (se oculta en XS) -->
              <form
                class="d-none d-md-flex"
                role="search"
                onsubmit="return false;"
              >
                <input
                  class="form-control form-control-sm rounded-pill px-3"
                  type="search"
                  placeholder="Buscar..."
                  aria-label="Buscar"
                />
              </form>

              <!-- WhatsApp -->
              <a class="btn btn-icon" href="#" aria-label="WhatsApp">
                <i class="fa-brands fa-whatsapp"></i>
              </a>

              <!-- Usuario -->
              <div class="nav-item dropdown">
                <a
                  class="btn btn-outline-light btn-user dropdown-toggle d-flex align-items-center gap-2"
                  href="#"
                  id="userMenu"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i class="fa-regular fa-user"></i
                  ><span class="d-none d-sm-inline">Iniciar Sesión</span>
                </a>
                <ul
                  class="dropdown-menu dropdown-menu-end"
                  aria-labelledby="userMenu"
                >
                  <li>
                    <a class="dropdown-item" href="vista/login/login_form.php"
                      ><i class="fa-solid fa-right-to-bracket me-2"></i
                      >Entrar</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="#"
                      ><i class="fa-solid fa-user-plus me-2"></i>Crear cuenta</a
                    >
                  </li>
                  <li><hr class="dropdown-divider" /></li>
                  <li>
                    <a class="dropdown-item" href="#"
                      ><i class="fa-solid fa-gear me-2"></i>Configuración</a
                    >
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </nav>
      <!-- ============ /NAVBAR ============ -->
    </div>
    <!-- --------------------------------------------------------------------------------------------------- -->

    <div>
      <img src="NECQSUWCVZHAJAZTSHJUFLDX6A.avif" alt="" class="makroimg" />
      <style>
        .makroimg {
          width: 100%;
        }
      </style>
    </div>
    <!-- ================= FOOTER ================= -->
    <footer class="footer mt-5 text-white">
      <div class="container py-4">
        <div class="row gy-4">
          <!-- Columna 1: Logo y descripción -->
          <div class="col-md-4 text-center text-md-start">
            <img
              src="vista/imagenes/fondo.png"
              alt="Bodega Maribel"
              class="footer-logo mb-3"
            />
            <p class="small mb-0">
              <strong>Bodega Maribel</strong> — Calidad, confianza y servicio
              para tu negocio.
            </p>
          </div>

          <!-- Columna 2: Enlaces -->
          <div class="col-md-4 text-center">
            <h6 class="fw-bold mb-3">Enlaces útiles</h6>
            <ul class="list-unstyled small">
              <li>
                <a href="index.php" class="footer-link"
                  ><i class="fa-solid fa-house me-2"></i>Inicio</a
                >
              </li>
              <li>
                <a href="index.php?ruta=productos" class="footer-link"
                  ><i class="fa-solid fa-boxes-stacked me-2"></i>Productos</a
                >
              </li>
              <li>
                <a href="#" class="footer-link"
                  ><i class="fa-solid fa-tag me-2"></i>Ofertas</a
                >
              </li>
              <li>
                <a href="#" class="footer-link"
                  ><i class="fa-solid fa-phone me-2"></i>Contacto</a
                >
              </li>
            </ul>
          </div>

          <!-- Columna 3: Redes sociales -->
          <div class="col-md-4 text-center text-md-end">
            <h6 class="fw-bold mb-3">Síguenos</h6>
            <div
              class="d-flex justify-content-center justify-content-md-end gap-3"
            >
              <a href="#" class="social-icon"
                ><i class="fa-brands fa-facebook-f"></i
              ></a>
              <a href="#" class="social-icon"
                ><i class="fa-brands fa-instagram"></i
              ></a>
              <a href="#" class="social-icon"
                ><i class="fa-brands fa-whatsapp"></i
              ></a>
            </div>
          </div>
        </div>

        <hr class="my-4 border-light" />

        <div class="text-center small">
          © 2025 <strong>Bodega Maribel</strong> — Todos los derechos
          reservados.
        </div>
      </div>
    </footer>
    <!-- =============== /FOOTER =============== -->

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
