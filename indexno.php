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
				header('location: sistema/');
			}else{
				echo "<script>
						alert ('Usuario o contraseña incorrectos');
						window.location = 'index.php';
					</script>";
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
            <input type="text" name="user" required=""/>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	<div class="modal-header">
        <h5 class="modal-title">Formulario de Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- -->
		<form>
			<div class="form-group row">
					<label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold font-weight-bold">Profesional</label>
				<div class="col-5">


				<select class="js-example-basic-single" name="state" id="profesional" >                                        
					<option value="">Seleccione</option>
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
						})
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
					<label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Usuario</label>				
				<div class="col-sm-8">
					<input id="user" type="text" class="form-control" >	
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
	   <!-- -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="ConfirmarR()">Confirmar</button>
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
					<input type="email" class="form-control" id="exampleInputEmail1" name="email">
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