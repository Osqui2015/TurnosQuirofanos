<?php
	require_once "../../conSanatorio.php";
	require_once "../../conUsuario.php";
                use PHPMailer\PHPMailer\PHPMailer;
				use PHPMailer\PHPMailer\Exception;

				require '../../PHPMailer/Exception.php';
				require '../../PHPMailer/PHPMailer.php';
				require '../../PHPMailer/SMTP.php';

/*----- ENVIAR MENSAJE ---- */
    if(isset($_POST['enviar']))
    {
        $user = $_POST['nombre']; // usuarios
        $tamaño = sizeof($user);
        $mensaje = $_POST['mensaje'];
        $titulo = $_POST['titulo'];
        $iduser = $_POST['iduser'];
        $importancia = $_POST['importancia'];
        $DateAndTime = date('Y-m-d H:i:s', time());  


        $sql = "INSERT INTO mensajes (titulo,mensaje,fecha_creacion,id_usuario_creacion,importancia) VALUES('$titulo','$mensaje','$DateAndTime','$iduser','$importancia')";
        $result = mysqli_query($conUsuario, $sql);


        
		if (!$result) {
			echo "Error en la inserción: ".$conUsuario->error;
		}else {
            echo "Mensaje enviado correctamente";
        }

       

        if ($user[0] == 0 && !empty($user[1])){
            for ($i=1; $i < $rowcount; $i++) { 
                $sql = "INSERT INTO mensajes_usuarios (titulo,mensaje,fecha_creacion,id_usuario_creacion,importancia) VALUES('$titulo','$mensaje','$DateAndTime','$iduser','$importancia')";
                $result = mysqli_query($conUsuario, $sql);

                if (!$result) {
                    echo "Error en la inserción: ".$conUsuario->error;
                }else {
                    echo "Mensaje enviado correctamente";
                }                
            }
        }else{
            for ($i = 0; $i <= ($tamaño-1); $i++){
                echo "<br>".$user[$i]."<br>";
                
            }
        }
            
    }


/*--- cargar mensaje ---*/
    if(isset($_POST['buscarM']))
    { 
    	$id = $_POST['id'];
		
    	$valores = array();
    	$valores['existe'] = "0";

		require_once "../../conUsuario.php";
    	//CONSULTAR
		  $msj = mysqli_query($conUsuario,"SELECT mj.id_mensaje, mj.fecha_creacion, mj.id_usuario_creacion, mj.mensaje, mj.titulo, us.nombre, mj.importancia
          FROM mensajes AS mj INNER JOIN usuarios AS us ON us.userid = mj.id_usuario_creacion
          WHERE mj.id_mensaje = $id");

		$rowcount=mysqli_num_rows($msj);
		
		  while($msjj = $msj->fetch_assoc()){
			$valores['existe'] = "1"; 
			$valores['Fecha'] = $msjj['fecha_creacion'];
			$valores['Titulo'] = utf8_encode($msjj['titulo']);	
		  	$valores['Mensaje'] = utf8_encode($msjj['mensaje']);
		  	$valores['Usuario'] = $msjj['nombre'];
		  }  		

		  $valores = json_encode($valores, JSON_THROW_ON_ERROR);
		  echo $valores;
		
    }

/*--- cargar editar ---*/
    if(isset($_POST['editarUser']))
    { 
        $matricula = $_POST['matricula'];        
        $valores = array();
        $valores['existe'] = "0";

        require_once "../../conUsuario.php";
        //CONSULTAR
        $msj = mysqli_query($conUsuario,"SELECT * FROM usuarios WHERE matricula = '$matricula';");

        $rowcount=mysqli_num_rows($msj);
        
        while($msjj = $msj->fetch_assoc()){
            $valores['existe'] = "1"; 
            $valores['mail'] = $msjj['mail'];
            $valores['usuario'] = $msjj['usuario'];
            $valores['matricula'] = $msjj['matricula'];
            $valores['activacion'] = $msjj['activacion'];
            $valores['nombre'] = $msjj['nombre'];
            $valores['tipo'] = $msjj['tipo'];
            $valores['panel'] = $msjj['panel'];
            $valores['mensajes'] = $msjj['mensajes'];
            $valores['turno'] = $msjj['turno'];
        }  		

        $valores = json_encode($valores, JSON_THROW_ON_ERROR);
        echo $valores;
        
    }

/*--- editar usuario ---*/
    if(isset($_POST['editarGuardar']))
    { 
        $matricula = $_POST['matricula'];
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $mail = $_POST['mail'];
        $tipo = $_POST['tipo'];
        
        $panel = $_POST['panel'];
        $mensajes = $_POST['mensajes'];
        $turno = $_POST['turno'];
        $valores = array();
        $valores['existe'] = "0";

        require_once "../../conUsuario.php";
        //CONSULTAR
        $msj = mysqli_query($conUsuario,"UPDATE usuarios SET nombre = '$nombre', usuario = '$usuario', mail = '$mail', tipo = '$tipo', panel = '$panel', mensajes = '$mensajes', turno = '$turno' WHERE matricula = '$matricula'");

        if (!$msj) {
            echo "Error en la inserción: ".$conUsuario->error;
        }else {
            $valores['existe'] = "1";            
        }
        $valores = json_encode($valores, JSON_THROW_ON_ERROR);
        echo $valores;
    }

    /*---------------- validar email -----------------*/
		if(isset($_POST['validEmail']))
		{ 
			$email = $_POST['email'];

			$valores = array();
			$valores['existe'] = "0";

			//CONSULTAR
			$resultados = mysqli_query($conUsuario,"SELECT mail FROM usuarios WHERE mail = '$email'");

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
		VALUES ('$email','$usuario',md5('$pass'),$mat,0,0,'$nombre')";

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



/* ------------- Cargar Editar Quirofano ------------- */
	if(isset($_POST['editarQuirofano']))
	{ 
		$quirofano = $_POST['quirofano'];
		
		$valores = array();
		$valores['existe'] = "0";

		$registro = "SELECT * 
		FROM quirofanoshorarios AS tur 
		INNER JOIN quirofanos AS q ON q.Numero = tur.Quirofano 
		WHERE Quirofano = $quirofano ";

		$resu = mysqli_query($conSanatorio,$registro);

		if (!$resu) {
			echo "Error Registro: ".$conSanatorio->error;
		}else{
			$valores['existe'] = "1";
		}
		
        
        while($msjj = $resu->fetch_assoc()){
            $valores['existe'] = "1"; 
            $valores['tp'] = $msjj['Descripcion'];
            $valores['horaI'] = $msjj['HoraInicio'];
            $valores['horaF'] = $msjj['HoraFin'];
            $valores['intervalo'] = $msjj['Intervalo'];
            $valores['entre'] = $msjj['TiempoEntreTurno'];
            $valores['esta'] = $msjj['web'];
            $valores['q'] = $msjj['Quirofano'];
        }  		

		$valores = json_encode($valores);
		echo $valores;			
	}

/*--- Modificar Quirofano ---------------*/
	if(isset($_POST['modificarQuirofano']))
	{ 
		$quirofano = $_POST['quirofano'];
		$tp = $_POST['tp'];
		$horaI = $_POST['horaI'];
		$horaF = $_POST['horaF'];
		$intervalo = $_POST['intervalo'];
		$entre = $_POST['entre'];
		$esta = $_POST['esta'];
		$q = $_POST['q'];
		
		$valores = array();
		$valores['existe'] = "0";

		$registro = "UPDATE quirofanoshorarios 
		HoraInicio = '$horaI', HoraFin = '$horaF', Intervalo = '$intervalo', TiempoEntreTurno = '$entre', web = '$esta' 
		WHERE Quirofano = $q ";

		$resu = mysqli_query($conSanatorio,$registro);

		if (!$resu) {
			echo "Error Registro: ".$conSanatorio->error;
		}else{
			$valores['existe'] = "1";
		}
			
		$valores = json_encode($valores);
		echo $valores;			
	}