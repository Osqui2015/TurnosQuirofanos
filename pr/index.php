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
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php  include_once "dependencias.php" ?>

    <title>Sanatorio Modelo</title>
  <link rel="icon" href="../../imagen/modelo.jpg">
</head>
  <body>
  
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="images/undraw_remotely_2j6y.svg" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>SANATORIO MODELO</h3>
              <p class="mb-4"></p>
            </div>
            <form action="" method="post">
              <div class="form-group first">
                <label for="username">USUARIO</label>
                <input type="text" class="form-control" name="user">

              </div>
              <div class="form-group last mb-4">
                <label for="password">CONTRASEÑA</label>
                <input type="password" class="form-control" name="pass">
                
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">recordar</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
              </div>

              <input type="submit" value="Iniciar Sesion" class="btn btn-block btn-primary">

              <span class="d-block text-left my-4 text-muted">&mdash; or login with &mdash;</span>              
              <div class="social-login">
                <a href="#" class="facebook">
                  <span class="icon-facebook mr-3"></span> 
                </a>
                <a href="#" class="twitter">
                  <span class="icon-twitter mr-3"></span> 
                </a>
                <a href="#" class="google">
                  <span class="icon-google mr-3"></span> 
                </a>
              </div>
            </form>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </div>
  </body>
</html>