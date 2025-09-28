<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="../css/Inicio.css">
</head>

<body>
    <div class="d-flex" style="min-height: 100vh;">
        <!-- SIDEBAR -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-primary text-white">
            <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                TECNICELL RM
            </a>
            <hr>
            <div class="menu-barra-lateral">
                <div class="seccion-menu">
                    <div class="elemento-menu activo">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </div>
                    <a href="../indexcompras.php" class="elemento-menu">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Compras</span>
                    </a>
                    <a href="RDevolucion.php" class="elemento-menu">
                        <i class="fas fa-undo"></i>
                        <span>Devoluciones</span>
                    </a>
                    
                    <a href="../indexventas.php" class="elemento-menu">
                        <i class="fas fa-chart-line"></i>
                        <span>Ventas</span>
                    </a>
                </div>
                <hr>
                <div class="seccion-menu">
                    <a href="/indexproveedor.php" class="elemento-menu">
                        <i class="fas fa-users"></i>
                        <span>Proveedores</span>
                    </a>
                    <a href="Productos.php" class="elemento-menu">
                        <i class="fas fa-boxes"></i>
                        <span>Productos</span>
                  
                                        </a>
                     <a class="elemento-menu d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
     href="#" 
     id="rolesMenu" 
     role="button" 
     data-bs-toggle="dropdown" 
     aria-expanded="false">
    <i class="fas fa-user-friends me-2"></i><span>Roles</span>
  </a>
  <ul class="dropdown-menu" aria-labelledby="rolesMenu">
  <li><a class="dropdown-item" href="../indexcli.php">Cliente</a></li>
  <li><a class="dropdown-item" href="../Indexempleado.php">Empleado</a></li>
</ul>
                </div>
            </div>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="flex-grow-1">
            <!-- NAVBAR -->
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" >Sistema gestión de inventarios</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <!-- Puedes agregar aquí más links si lo necesitas -->
                    </div>
                    <div class="dropdown ms-auto">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="fotos_empleados/6865b20c9ef22_Foto de carnet Mateo.jpeg" alt="" width="32" height="32" class="rounded-circle me-2">
                            <strong>Perfil</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="Perfil.html">Mi perfil</a></li>
                            <li><a class="dropdown-item" href="EditarPerfil.php">Editar perfil</a></li>
                            <li><a class="dropdown-item" href="Registro.php">Registrarse</a></li>
                            <li><a class="dropdown-item" href="Index.html">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- CONTENIDO VACÍO PARA LLENAR -->
            <div class="container mt-4">
  <div class="row g-4">
    <!-- Órdenes de Compra -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card tarjeta-dashboard azul h-100 text-center">
        <div class="icono-tarjeta-dashboard mx-auto mt-3 mb-2">
          <i class="fas fa-file-invoice"></i>
        </div>
        <div class="card-body py-2">
          <div class="titulo-tarjeta-dashboard">Compras</div>
          <div class="numero-tarjeta-dashboard">3</div>
        </div>
      </div>
    </div>
    <!-- Compras Recibidas -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card tarjeta-dashboard verde-azul h-100 text-center">
        <div class="icono-tarjeta-dashboard mx-auto mt-3 mb-2">
          <i class="fas fa-users"></i>
        </div>
        <div class="card-body py-2">
          <div class="titulo-tarjeta-dashboard">Devoluciones</div>
          <div class="numero-tarjeta-dashboard">2</div>
        </div>
      </div>
    </div>
    <!-- Devoluciones -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card tarjeta-dashboard naranja h-100 text-center">
        <div class="icono-tarjeta-dashboard mx-auto mt-3 mb-2">
          <i class="fas fa-undo"></i>
        </div>
        <div class="card-body py-2">
          <div class="titulo-tarjeta-dashboard">Ventas</div>
          <div class="numero-tarjeta-dashboard">1</div>
        </div>
      </div>
    </div>
    <!-- Ventas -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card tarjeta-dashboard azul-oscuro h-100 text-center">
        <div class="icono-tarjeta-dashboard mx-auto mt-3 mb-2">
          <i class="fas fa-file-alt"></i>
        </div>
        <div class="card-body py-2">
          <div class="titulo-tarjeta-dashboard">Proveedores</div>
          <div class="numero-tarjeta-dashboard">1</div>
        </div>
      </div>
    </div>
    <!-- Proveedores -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card tarjeta-dashboard naranja-alternativo h-100 text-center">
        <div class="icono-tarjeta-dashboard mx-auto mt-3 mb-2">
          <i class="fas fa-building"></i>
        </div>
        <div class="card-body py-2">
          <div class="titulo-tarjeta-dashboard">Productos</div>
          <div class="numero-tarjeta-dashboard">1</div>
        </div>
      </div>
    </div>
    <!-- Productos -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card tarjeta-dashboard morado h-100 text-center">
        <div class="icono-tarjeta-dashboard mx-auto mt-3 mb-2">
          <i class="fas fa-th-large"></i>
        </div>
        <div class="card-body py-2">
          
          <div class="titulo-tarjeta-dashboard">Usuarios</div>
          <div class="numero-tarjeta-dashboard">2</div>
        </div>
      </div>
    </div>
    
  </div>
</div>

        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>