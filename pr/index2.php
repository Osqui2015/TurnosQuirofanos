<?php 
	
$alert = '';
session_start();
if(!empty($_SESSION['active'])){
	header('location: sistema/');
}else{

	if(!empty($_POST))
	{
		if(empty($_POST['user']) || empty($_POST['pass']))
		{
			$alert = 'Ingrese su usuario y su calve';
		}else{
			require_once "conUsuario.php";
			$user = mysqli_real_escape_string($conUsuario,$_POST['user']);
			$pass = md5(mysqli_real_escape_string($conUsuario,$_POST['pass']));
			$query = mysqli_query($conUsuario,"SELECT * FROM usuarios WHERE usuario= '$user' AND password = '$pass'");
			mysqli_close($conUsuario);
			$result = mysqli_num_rows($query);
			if($result > 0)
			{
				$data = mysqli_fetch_array($query);
				$_SESSION['active'] = true;
				$_SESSION['matricula'] = $data['matricula'];
				$_SESSION['nombre'] = $data['nombre'];
				$_SESSION['tipo']  = $data['tipo'];
				$_SESSION['reporte']   = $data['reporte'];
				$_SESSION['panel']    = $data['panel'];
        $_SESSION['mensaje']    = $data['mensajes'];
				header('location: sistema/');
			}else{
				$alert = 'El usuario o la clave son incorrectos';
				session_destroy();
			}
		}
	}
}
?>



<!DOCTYPE html>
<html lang="es-ES">
<head>
  <meta charset="UTF-8">
  <title>Sanatorio Modelo</title>

<script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>

<link rel="stylesheet" href="css/style.css">

<?php  include_once "dependencias.php" ?>

<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body>
<!-- partial:index.partial.html -->
<!-- NORMALIZED CSS INSTALLED-->
<!-- View settings for more info.-->
<div id="container">
  <div id="inviteContainer">    
    <div class="logoContainer">
      <img class="text" src="imag/modelo.jpg"/>      
    </div>

    <div class="acceptContainer">
      <form>
        <h1>¡BIENVENIDO DE NUEVO!</h1>
        <br>
        <div class="formContainer">
          <div class="formDiv" style="transition-delay: 0.2s">
            <p>USUARIO</p>
            <input type="text" class="form-control" name="user" required=""/>
          </div>
          <div class="formDiv" style="transition-delay: 0.4s">
            <p>CONTRASEÑA</p>
            <input type="password" class="form-control" name="pass" required=""/>
            <a class="forgotPas" href="#">Olvidaste Contraseña</a>
          </div>
          <div class="formDiv" style="transition-delay: 0.6s">
            <button class="acceptBtn" type="submit">INICIAR</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- partial -->
  <script  src="js/script.js"></script>
</body>
</html>
