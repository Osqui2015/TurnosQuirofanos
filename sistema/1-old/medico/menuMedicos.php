
<nav class="navbar navbar-expand-lg navbar-light h5 text-white" style="background-color:#004993;">
  <a class="navbar-brand text-white font-weight-bold" href="index.php">Inicio</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse " id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto ">      
      <!-- <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
          Sistema
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
           a class="dropdown-item" href="turnoQuirofano.php">Turno Quirófano</a> 
          <a class="dropdown-item" href="pagos.php">Cuenta Corriente</a>
        </div>
      </li> -->

      <li class="nav-item active">
        <a class="nav-link text-white" href="turnoQuirofano.php"> Mis Turnos <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            Quirófano
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <!-- <a class="dropdown-item" href="turnoQuirofano.php">Mis Turnos</a> -->
          <a class="dropdown-item" href="todosTurnos.php">Todos Los Turnos</a>
          <a class="dropdown-item" href="nuevoT.php">Nuevo Turno</a>
        </div>
      </li>

      <!-- <li class="nav-item active">
        <a class="nav-link text-white" href="consentimientos.php"> Consentimientos <span class="sr-only">(current)</span></a>
      </li> -->


      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            Mensajes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php if ($_SESSION['mensaje'] == 2): ?>
            <a class="dropdown-item" href="#">Crear Mensajes</a>
          <?php endif; ?>
            <a class="dropdown-item" href="misMensaje.php">Mis Mensajes</a>
        </div>
      </li>

      <li class="nav-item active ">
        <a class="nav-link text-white" href="pagos.php">Pagos <span class="sr-only">(current)</span></a>
      </li>

     <!-- <li class="nav-item ">
        <a class="nav-link text-white" href="../salir.php" >Cerrar sesión</a>
      </li> -->
    </ul>
      <a>   <?php echo $_SESSION['nombre']  ?> </a>
      <a class="nav-link text-white" href="../salir.php" >Cerrar sesión</a>
  </div>
</nav>