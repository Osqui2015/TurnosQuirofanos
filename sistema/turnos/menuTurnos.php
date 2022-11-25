<nav class="navbar navbar-expand-lg navbar-dark fixed-top h5" style="background-color:#004993;">  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon">Menu</span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active"><a href="index.php" class="nav-link">Inicio</a></li>
      <li class="nav-item active"><a class="nav-link">ㅤㅤ</a></li>
      <li class="nav-item active"><a href="nuevoTurno.php" class="nav-link">Nuevo Turno</a></li>
      <li class="nav-item active"><a class="nav-link">ㅤㅤ</a></li>
      <li class="nav-item active"><a href="reporte.php" class="nav-link">Reporte de Turno</a></li>
      <li class="nav-item active"><a class="nav-link">ㅤㅤ</a></li>
      <li class="nav-item active"><a href="reportepre.php" class="nav-link">Reporte de Turno con Pre Admisión </a></li>
      <li class="nav-item active"><a class="nav-link">ㅤㅤ</a></li>
      <li class="nav-item active"><a href="todosTurnos.php" class="nav-link">Todos los Turno</a></li>
      <li class="nav-item active"><a class="nav-link">ㅤㅤ</a></li>
      <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Perfil</a>
            <div class="dropdown-menu" aria-labelledby="dropdown04">
              <a class="dropdown-item" href="cambioContra.php">Cambio de Contraseña</a>
              <a class="dropdown-item" href="../salir.php">Cerrar Sesión</a>                
            </div>
      </li>
    </ul>
    <span class="navbar-text">
      <?php echo $_SESSION['nombre'] ?>
    </span>
  </div>
</nav>
