<?php
				use PHPMailer\PHPMailer\PHPMailer;
				use PHPMailer\PHPMailer\Exception;

				require 'PHPMailer/Exception.php';
				require 'PHPMailer/PHPMailer.php';
				require 'PHPMailer/SMTP.php';
				require_once "conSanatorio.php";
				require_once "conUsuario.php";
	
/* -------------REGISTRO CARGA DOCTOR---------------- */
	if(isset($_POST['buscarDoc']))
	{ 
		$mat = $_POST['mat'];
		$valores = array();
		$valores['existe'] = "0";

		//CONSULTAR
		$resultados = mysqli_query($conSanatorio,"SELECT Matricula, 
		LTRIM(RTRIM(Nombre)) AS Nombre 
		FROM profesionales 
		WHERE Activo = 1 AND Matricula = '$mat'");

		while($consulta = mysqli_fetch_array($resultados))
		{
			$valores['existe'] = "1"; 
			$valores['Nombre'] = $consulta['Nombre'];	    
		}
		$valores = json_encode($valores);
			echo $valores;
	}

/* -------------REGISTRO CARGA DOCTOR---------------- */
	if(isset($_POST['registrarDoc']))
	{ 
		$mat = $_POST['valorMatricula'];
		$profesionales = $_POST['profesional'];
		$email = $_POST['email'];
		$usuario = $_POST['username'];
		$pass = $_POST['pass1'];
		$pass2 = $_POST['pass2'];

		$valores = array();
		$valores['existe'] = "0";
		$ok = '';


		if ($resultado = mysqli_query($conSanatorio, "SELECT Matricula, 
		LTRIM(RTRIM(Nombre)) AS Nombre 
		FROM profesionales 
		WHERE Activo = 1 AND Matricula = '$mat'")) {


		while ($fila = mysqli_fetch_row($resultado)) {
			$valores['Nombre'] = $fila[1];
		}
		}else{
			echo "Error: " . $resultado . "<br>" . mysqli_error($conUsuario);
		}

		$nombre = $valores['Nombre'];
		/* 
		$registro = "INSERT INTO usuarios (mail,usuario,PASSWORD,matricula,activacion,tipo,nombre) 
		VALUES (mail,usuario,PASSWORD,matricula,activacion,tipo,nombre)";
		*/
		$registro = "INSERT INTO usuarios (mail,usuario,PASSWORD,matricula,activacion,tipo,nombre) 
		VALUES ('$email','$usuario',md5('$pass'),$mat,0,2,'$nombre')";

		$resultadoUno = mysqli_query($conUsuario,$registro);

		if (!$resultadoUno) {
			echo "Error Registro: ".$conSanatorio->error;
		}else{
			$ok = 1;
		}



		if ($ok == 1){
				$mail = new PHPMailer();
				$mail->IsSMTP();

				$mensaje =  "<h2>".'Nuevo Registro de Usuario'."</h2>".
							"<br>"."<br>".
							"<b>".'Doctor: : '."</b>".$valores['Nombre']."<br>".
							"<b>".'Usuario: '."</b>".$usuario."<br>".
							"<b>".'Contraseña: '."</b>".$pass."<br>".
							"<b>".'Email: '."</b>".$email."<br>".
							"<b>".'Matricula: '."</b>".$mat."<br>".
							"<b>".'Fecha: '."</b>".date("d/m/Y");

				$mail->SMTPAuth = true;
				$mail->SMTPSecure = "STARTTLS";
				$mail->Host = "smtp-mail.outlook.com";
				$mail->Port = 587;
				$mail->Username = "SanatorioModelosaWeb@outlook.com";
				$mail->Password = "Acreta123";
				$mail->CharSet = "utf-8";

				$mail->From = "SanatorioModelosaWeb@outlook.com";

				$mail->FromName = "SanatorioModelosaWeb";

				$mail->Subject = "Nuevo Registro de Usuario";

				$mail->Body = $mensaje;

				$mail->AddAddress("sistemas@sanatoriomodelosa.com.ar");
 
				$mail->IsHTML(true);
				if(!$mail->Send()) {
					echo "Error: " . $mail->ErrorInfo;
				} else {
					/* echo "Mensaje enviado!"; */
				}

			/* */
			$valores['existe'] = "1";

		}else{
			$valores['existe'] = "0";
		}

		$valores = json_encode($valores);
		echo $valores;			
	}

/*---------------- validar email -----------------*/
	if(isset($_POST['validEmail']))
	{ 
		$email = $_POST['email'];

		$valores = array();
		$valores['existe'] = "0";

		//CONSULTAR
		$resultados = mysqli_query($conUsuario,"SELECT * FROM usuarios WHERE mail = '$email'");
		while($turnocons = mysqli_fetch_array($resultados)){
			$valores['tipo'] = $turnocons['tipo'];
		}
		if(!$resultados){
			echo mysqli_error($conUsuario);
		}

		$row_cnt = mysqli_num_rows($resultados);

		if ($row_cnt == 0){
			$valores['existe'] = "0";
			
		}else{
			$valores['existe'] = "1";			
		}

		$valores = json_encode($valores);
			echo $valores;
	}

/* ------------- validar user ------------- */
	if(isset($_POST['validUser']))
	{ 
		$user = $_POST['username'];
		$valores = array();
		$valores['existe'] = "0";

		//CONSULTAR
		$resultados = mysqli_query($conUsuario,"SELECT mail FROM usuarios WHERE usuario = '$user'");

		if(!$resultados){
			echo mysqli_error($conUsuario);
		}

		$row_cnt = mysqli_num_rows($resultados);
		
		if ($row_cnt == 0){
			$valores['existe'] = "0";
			
		}else{
			$valores['existe'] = "1";
		}
		
		$valores = json_encode($valores);
			echo $valores;
	}
		

/* ------------- RECUPERAR CONTRASEÑA ------------- */
	if(isset($_POST['recuperar']))
	{
		$email = $_POST['email'];
		$valores = array();
		$valores['existe'] = "0";
		$ok = 0;

		//CONSULTAR
		$resultados = mysqli_query($conUsuario,"SELECT mail FROM usuarios WHERE mail = '$email'");

		if(!$resultados){
			echo mysqli_error($conUsuario);
		}

		$row_cnt = mysqli_num_rows($resultados);

		if ($row_cnt == 0){
			$ok = "0";
			
		}else{
			$ok = "1";
		}

		if ($ok == 1){
			$mail = new PHPMailer();
			$mail->IsSMTP();

			$mensaje =  "<h1>".'SANATORIO MODELO'."</h1>".
						"<h2>".'SOLICITUD DE RECUPERACIÓN DE CONTRASEÑA'."</h2>".
						"<br>"."<br>".
						"<br>".$email."<br>".
						"<br>"."<br>".
						'<p> <a href="http://181.12.6.58/sanatorio/recupero.php"> 
								para restablecer da click aquí </a> </p>'."<br>"."<br>".
						'<p> <small>Si usted no envió este codigo favor de omitir</small> </p>';

			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "STARTTLS";
			$mail->Host = "smtp-mail.outlook.com";
			$mail->Port = 587;
			$mail->Username = "SanatorioModelosaWeb@outlook.com";
			$mail->Password = "Acreta123";
			$mail->CharSet = "utf-8";

			$mail->From = "SanatorioModelosaWeb@outlook.com";

			$mail->FromName = "SanatorioModelosaWeb";

			$mail->Subject = "SOLICITUD DE RECUPERACIÓN DE CONTRASEÑA";

			$mail->Body = $mensaje;

			$mail->AddAddress("$email");
			$mail->AddAddress("oscarguerrero@sanatoriomodelosa.com.ar");

			$mail->IsHTML(true);
			if(!$mail->Send()) {
				echo "Error: " . $mail->ErrorInfo;
			} else {
				/* echo "Mensaje enviado!"; */
			}

		/* */
		$valores['existe'] = "1";

	}else{
		$valores['existe'] = "0";
	}
	$valores = json_encode($valores);
	echo $valores;

	}



/* ------------- validar matricula ------------- */
	if(isset($_POST['validMatricula']))
	{
		$mat = $_POST['mat'];
		$email = $_POST['email'];
		$valores = array();
		$valores['existe'] = "0";
		$ok = 0;

		//CONSULTAR
		$resultados = mysqli_query($conUsuario,"SELECT matricula FROM usuarios WHERE matricula = '$mat' AND mail = '$email'");

		if(!$resultados){
			echo mysqli_error($conUsuario);
		}
		$row_cnt = mysqli_num_rows($resultados);

		if ($row_cnt == 0){
			$ok = "0";

		}else{
			$ok = "1";
		}

		if ($ok == 1){
			$valores['existe'] = "1";

		}else{
			$valores['existe'] = "0";
		}

		$valores = json_encode($valores);
		echo $valores;

	}

/* ------------- cambioContra ---------- */
	if(isset($_POST['cambioContra']))
	{
		$mat = $_POST['mat'];
		$pass = md5($_POST['pass']);		
		$valores = array();
		$valores['existe'] = "0";
		$ok = 0;

		//CONSULTAR
		$resultados = mysqli_query($conUsuario,"SELECT mail FROM usuarios WHERE mail = '$mat'");

		if(!$resultados){
			echo mysqli_error($conUsuario);
		}
		$row_cnt = mysqli_num_rows($resultados);

		if ($row_cnt == 0){
			$ok = "0";

		}else{
			$ok = "1";
		}

		if ($ok == 1){			
			$resultados = mysqli_query($conUsuario,"UPDATE usuarios SET password = '$pass' WHERE mail = '$mat'");			

			if(!$resultados){
				echo mysqli_error($conUsuario);
			}

			$valores['existe'] = "1";

		}else{
			$valores['existe'] = "0";
		}

		$valores = json_encode($valores);
		echo $valores;

	}
/*----------- ValidarMatriculaRegistro ----------------*/
	if (isset($_POST['ValidarMatriculaRegistro'])){
		$matreg = $_POST['matreg'];
		//CONSULTAR
		$resultados = mysqli_query($conSanatorio,"SELECT pr.Matricula, pr.Nombre, pr.mail, pr.NumeroDocumento 
		FROM sanatorio.profesionales AS pr 
		WHERE pr.Matricula NOT IN (
		SELECT matricula FROM zetap_sanatorio.usuarios WHERE matricula IS NOT NULL)
		AND pr.Matricula NOT IN ( 1, 2, 3, 66, 99, 111, 333, 559, 1111, 1234, 5563)
		AND pr.Activo = 1 
		AND pr.Matricula = $matreg
		ORDER BY pr.Nombre");

	$valores['existe'] = "0";

		while($consulta = mysqli_fetch_array($resultados))
		{
			$valores['existe'] = "1"; 
			$valores['Nombre'] = utf8_encode($consulta['Nombre']);
			$valores['email'] = utf8_encode($consulta['mail']);
			$valores['NumeroDocumento'] = $consulta['NumeroDocumento'];
		}
		$valores = json_encode($valores, JSON_THROW_ON_ERROR);
			echo $valores;

	}