
<nav class="navbar navbar-expand-lg navbar-light h5 text-white" style="background-color: #097ea9;">
  <a class="navbar-brand text-white font-weight-bold" href="index.php">Inicio</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse " id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto ">      
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
          Bloqueo
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="turnoQuirofano.php">Matricula - Quirofano</a>
          <a class="dropdown-item" href="pagos.php">Practica - Quirofano</a>
        </div>
      </li>

      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            Privilegios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Matricula - Quirofano - Privilegios</a>
        </div>
      </li>

      <li class="nav-item active">
        <a class="nav-link text-white" href="horaQuirofano.php">Horarios Quirofanos <span class="sr-only">(current)</span></a>
      </li>


      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            Reporte
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php if ($_SESSION['reporte'] == 1 || $_SESSION['turno'] == 1): ?>
            <a class="dropdown-item" href="reporteTurno.php">Reportes de Turnos</a>
          <?php endif; ?>
          <!--  <a class="dropdown-item" href="reporteCreacion.php">Reportes de Creación de Turnos</a> -->
        </div>
      </li>

      <li class="nav-item active ">
        <a class="nav-link text-white" href="actUsuarios.php">Usuarios <span class="sr-only">(current)</span></a>

      </li>

      <li class="nav-item active ">
        <a class="nav-link text-white" href="pagos.php">Turnos <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item active ">
        <a class="nav-link text-white" href="mensaje.php">Mensajes <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item text-white">
        <a class="nav-link " href="../salir.php" >Cerrar sesión</a>
      </li>
    </ul>
      <a>   Usuario: Administrador </a>
  </div>
</nav>