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
				$_SESSION['usuario'] = $data['usuario']; 
				$_SESSION['idUsuario'] = $data['userid'];
				header('location: sistema/');
			}else{
				echo "<script>
						alert ('Usuario o contraseña incorrectos');
						window.location = 'login.php';
					</script>";
				$alert = 'El usuario o la clave son incorrectos';
				session_destroy();			
			}
		}
	}
}
?>
 

<!doctype html>
<html>
<head>	
  	<meta charset="UTF-8">
	<title>Sanatorio Modelo</title>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>
	<?php  include_once "dependencias.php" ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.transit/0.9.12/jquery.transit.js" integrity="sha256-mkdmXjMvBcpAyyFNCVdbwg4v+ycJho65QLDwVE3ViDs=" crossorigin="anonymous"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel="stylesheet" href="./style.css">	<link rel="icon" href="./imagen/modelo.jpg">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	
<link rel="icon" href="../../imagen/modelo.jpg">
</head>
<body>
<!-- partial:index.partial.html -->
<!-- NORMALIZED CSS INSTALLED-->
<!-- View settings for more info.-->
<div id="container">
  <div id="inviteContainer">
    <div class="logoContainer"><img class="text" src="imagen/modelo.jpg"/></div>
    <div class="acceptContainer">
      <form action="" method="post">        
        <div class="formContainer">
          <div class="formDiv" style="transition-delay: 0.2s">
            <p>Usuario</p>
            <input type="text" name="user" autofocus required=""/>
          </div>
          <div class="formDiv" style="transition-delay: 0.4s">
            <p>Contraseña</p>
            <input type="password" name="pass" required=""/>
          </div>
          <div class="formDiv" style="transition-delay: 0.6s">
		  <span class="register">No tienes Cuentas? <a data-toggle="modal" data-target=".bd-example-modal-lg">Registrarte</a></span>
		  <span class="olvide"><a data-toggle="modal" data-target="#exampleModalCenter">Recuperar Contraseña</a></span>
		  <span class="olvide">   ㅤㅤㅤ  </span>
        	<input type="submit" value="Iniciar Sesión" class="acceptBtn btn btn-block btn-primary">          
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- partial -->
  <script  src="./script.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
	  $(document).ready(function() {
							$('.js-example-basic-single').select2();
						});
 </script>						
  	
</body>
</html>




<!-- Modal -->


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
	<div class="modal-header">
        <h5 class="modal-title">Formulario de Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- 
		<form>
			<div class="form-group row">
					<label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold font-weight-bold">Profesional</label>
				<div class="col-5">


				<select class="js-example-basic-single" name="state" id="profesional" >                                        
					<option value="">ㅤㅤㅤㅤㅤㅤㅤSeleccioneㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</option>
					<?php 
						require_once "conSanatorio.php";
						/*$sql = "SELECT Matricula, Nombre FROM profesionales WHERE Activo = 1 ORDER BY Nombre"; */
						$sql = "SELECT pr.Matricula, pr.Nombre 
						FROM sanatorio.profesionales AS pr 
						WHERE pr.Matricula NOT IN (
							SELECT matricula FROM zetap_sanatorio.usuarios WHERE matricula IS NOT NULL
							)
						AND pr.Matricula NOT IN ( 1, 2, 3, 66, 99, 111, 333, 559, 1111, 1234, 5563 )
						AND pr.Activo = 1 order by pr.Nombre";
						
						$result = mysqli_query($conSanatorio, $sql);
						while($row = mysqli_fetch_array($result)){ ?>						
						<option value="<?php echo $row['Matricula'] ?>" ><?php echo $row['Matricula'] ?> | <?php echo utf8_encode($row['Nombre']) ?> </option>";
					<?php }?>
				</select>
					
					<span id="vMatricula" hidden = ""> <?php echo $matricula; ?> </span>
					<script>						
						$('#profesional').on('change', function(){
							var valor = this.value;
							$('#vMatricula').text(valor);                                                                                                
						});
						
					</script>
				</div>				
			</div>
			
			<div class="form-group row">
				<label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold" >E-MAIL</label>
				<div class="col-sm-8">
					<input type="email" class="form-control" id="email" name="email" onblur="validEmail()">	
				</div>
			</div>
			<div class="form-group row">				
					<label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold" >Usuario</label>				
				<div class="col-sm-8">
					<input id="user" type="text" class="form-control" onblur="validUser()">	
				</div>
			</div>
			<div class="form-group row">				
					<label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Contraseña</label>				
				<div class="col-sm-8">
					<input type="password" class="form-control" id="pass" name="pass">
				</div>
			</div>
			<div class="form-group row">				
					<label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Repetir Contraseña</label>				
				<div class="col-sm-8">
					<input type="password" class="form-control" id="passw" name="passw" onblur="validContra()">	
				</div>
			</div>
		</form>		
	    -->
		<div class="container">
			<div class="row">
				<div class="col-sm">
					Matricula:
				</div>
				<div class="col-sm">
					<input class="form-control" id="matreg" type="matreg" onblur="ValidarMatriculaRegistro()">
				</div> 
				<div class="col-sm">
							<button type="button" class="btn btn-success" id="matSi" style="display: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"></path>
                                    </svg>
                            </button>
                            <button type="button" class="btn btn-danger" id="matNo" style="display: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"></path>
                                    </svg>
                            </button>
				</div>			
			</div>
			<br>
			<div class="row">
				<div class="col-sm">
					Nombre y Apellido
				</div>
				<div class="col-sm">
					<input type="text" class="form-control" id="nya" name="nya">
				</div>
				<div class="col-sm">
					
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm">
					Email
				</div>
				<div class="col-sm">
					<input type="email" class="form-control" id="email" name="email" onblur="validEmail()">
				</div>
				<div class="col-sm">
					
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm">
					Usuario
				</div>
				<div class="col-sm">
					<input id="user" type="text" class="form-control" onblur="">
				</div>
				<div class="col-sm">
					
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm">
					Contraseña
				</div>
				<div class="col-sm">
					<input type="password" class="form-control" id="pass" name="pass" onchange="validContr()">
				</div>
				<div class="col-sm">
					
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm">
					Repetir Contraseña
				</div>
				<div class="col-sm">
					<input type="password" class="form-control" id="passw" name="passw" onblur="validContra()">
				</div>
				<div class="col-sm">
					<button type="button" class="btn btn-success" id="contrSi" style="display: none;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
								<path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"></path>
							</svg>
					</button>
					<button type="button" class="btn btn-danger" id="contrNo" style="display: none;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
								<path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z"></path>
							</svg>
					</button>
				</div>
			</div>
			<br>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id=conf onclick="ConfirmarR()" style="display: none;">Confirmar</button>
      </div>
 
    </div>
  </div>
</div>
	

  
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Recuperar Contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
			<div class="form-group row">
				<label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="mail" name="mail">
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary" onclick="Recupero()">Confirmar</button>
      </div>
    </div>
  </div>
</div>